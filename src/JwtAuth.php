<?php

namespace PakPak\JwtAuth;

use DateTime;

/**
 * Class JwtAuth
 *
 * A PHP Class for JWT manipulation using native PHP.
 *
 * @author Davi Lhlapak Rosa
 * @license Apache 2.0
 * @package PakPak\JwtAuth
 */
class JwtAuth{

    /** @var string */
    private $header;

    /** @var JwtPayload */
    private $payload;

    /** @var string */
    private $sign;

    /** @var JwtException */
    private $error;

    /**
     * Função que cria um JwtAuth a partir de um Jwt (token)
     * @param string $token Token jwt
     * @return JwtAuth
     */
    public static function byJwt(string $token):JwtAuth{

        if (empty($token)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_5,5);
            return $jwt;
        }

        $part = explode(".",$token);

        $header = $part[0];
        $payload = $part[1];
        $sign = $part[2];

        if (empty($header)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_1,1);
            return $jwt;
        }
        if (empty($payload)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_2,2);
            return $jwt;
        }
        if (empty($sign)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_4,4);
            return $jwt;
        }

        $jwt = new JwtAuth();

        $jwt->header = $header;
        $jwt->sign = $sign;

        $payload = json_decode(JwtFunctions::base64url_decode($payload),true);
        $jwt->payload = JwtPayload::createByArray($payload);

        return $jwt;
    }

    /**
     * Função que cria um novo JwtAuth
     * @param array $header
     * @param JwtPayload $payload
     * @param string $key
     * @return JwtAuth
     */
    public static function createJwt(JwtPayload $payload, string $key, array $header = []):JwtAuth{

        if (empty($payload)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_2,2);
            return $jwt;
        }
        if (empty($key)){
            $jwt = new JwtAuth();
            $jwt->error = new JwtException(JwtException::ERROR_CODE_3,3);
            return $jwt;
        }

        $jwt = new JwtAuth();

        if (empty($header)){
            $jwt->header = JwtFunctions::base64url_encode(json_encode(JwtFunctions::createHeader()));
        }else{
            $jwt->header = JwtFunctions::base64url_encode(json_encode($header));
        }

        $jwt->payload = $payload;

        $sign = hash_hmac('sha256', "{$jwt->header}.{$jwt->payload}", $key, true);
        $jwt->sign = JwtFunctions::base64url_encode($sign);

        return $jwt;
    }

    /**
     * @param string $jwt
     * @return bool
     */
    public function verifyJwt(string $jwt):bool {

        if (empty($jwt)){
            $this->error = new JwtException(JwtException::ERROR_CODE_3,3);
            return false;
        }

        $validAlgorithms = hash_algos();

        if (empty($hashingAlgorithm) || !in_array($hashingAlgorithm, $validAlgorithms, true)){
            $this->error = new JwtException(JwtException::ERROR_CODE_4,4);
            return false;
        }

        $valid = hash_hmac('sha256', "{$this->header}.{$this->payload->getPayloadString()}", $jwt, true);
        $valid = JwtFunctions::base64url_encode($valid);

        if ($this->sign == $valid){
            try{
                return $this->payload->verifyTokenExpiration();
            }catch (JwtException $exception){
                $this->error = $exception;
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getJwt(): string
    {
        return "{$this->header}.{$this->payload->getPayloadString()}.{$this->sign}";
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return (array) json_decode(JwtFunctions::base64url_decode($this->header),true);
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload->getPayloadArray();
    }

    public function error():?JwtException{
        return $this->error;
    }
}
