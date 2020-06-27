<?php

namespace PakPak\JwtAuth;

/**
 * Class JwtAuth
 *
 * A PHP Class for JWT manipulation using native PHP.
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
     * @throws JwtException
     */
    public static function byJwt(string $token):JwtAuth{

        if (empty($token)){
            throw new JwtException(JwtException::ERROR_CODE_6,6);
        }

        $part = explode(".",$token);

        $header = $part[0];
        $payload = $part[1];
        $sign = $part[2];

        if (empty($header)){
            throw new JwtException(JwtException::ERROR_CODE_1,1);
        }
        if (empty($payload)){
            throw new JwtException(JwtException::ERROR_CODE_2,2);
        }
        if (empty($sign)){
            throw new JwtException(JwtException::ERROR_CODE_5,5);
        }

        $jwt = new JwtAuth();

        $jwt->header = $header;
        $jwt->payload = $payload;
        $jwt->sign = $sign;

        return $jwt;
    }

    /**
     * Função que cria um novo JwtAuth
     * @param array $header
     * @param JwtPayload $payload
     * @param string $key
     * @return JwtAuth
     * @throws JwtException
     */
    public static function createJwt(JwtPayload $payload, string $key, array $header = []):JwtAuth{

        if (empty($payload)){
            throw new JwtException(JwtException::ERROR_CODE_2,2);
        }
        if (empty($key)){
            throw new JwtException(JwtException::ERROR_CODE_3,3);
        }

        $validAlgorithms = hash_algos();

        if (empty($hashingAlgorithm) || !in_array($hashingAlgorithm, $validAlgorithms, true)){
            throw new JwtException(JwtException::ERROR_CODE_4,4);
        }

        $jwt = new JwtAuth();

        if (empty($header)){
            $jwt->header = JwtFunctions::base64url_encode(json_encode(JwtFunctions::createHeader()));
        }else{
            $jwt->header = JwtFunctions::base64url_encode(json_encode($header));
        }

        $jwt->payload = JwtFunctions::base64url_encode(json_encode($payload));

        $sign = hash_hmac('sha256', "{$jwt->header}.{$jwt->payload}", $key, true);
        $jwt->sign = JwtFunctions::base64url_encode($sign);

        return $jwt;
    }

    /**
     * @param string $jwt
     * @return bool
     * @throws JwtException
     */
    public function verifyJwt(string $jwt):bool {

        if (empty($jwt)){
            throw new JwtException(JwtException::ERROR_CODE_3,3);
        }

        $validAlgorithms = hash_algos();

        if (empty($hashingAlgorithm) || !in_array($hashingAlgorithm, $validAlgorithms, true)){
            throw new JwtException(JwtException::ERROR_CODE_4,4);
        }

        $valid = hash_hmac('sha256', "{$this->header}.{$this->payload}", $jwt, true);
        $valid = JwtFunctions::base64url_encode($valid);

        if ($this->sign == $valid){
            try{
                return JwtFunctions::verifyTokenExpiration($this->payload);
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
        return "{$this->header}.{$this->payload}.{$this->sign}";
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
        return (array) json_decode(JwtFunctions::base64url_decode($this->payload),true);
    }

    public function error():?JwtException{
        return $this->error;
    }
}
