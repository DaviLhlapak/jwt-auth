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

    /** @var string */
    private $payload;

    /** @var string */
    private $sign;

    /**
     * @param string $token
     * @return JwtAuth
     * @throws JwtException
     */
    public static function byJwt(string $token):JwtAuth{
        $part = explode(".",$token);

        $header = $part[0];
        $payload = $part[1];
        $sign = $part[2];

        if (empty($header)){
            throw new JwtException("Header cannot be empty",1);
        }
        if (empty($payload)){
            throw new JwtException("Payload cannot be empty",2);
        }
        if (empty($sign)){
            throw new JwtException("Sign cannot be empty",5);
        }

        $jwt = new JwtAuth();

        $jwt->header = $header;
        $jwt->payload = $payload;
        $jwt->sign = $sign;

        return $jwt;
    }

    /**
     * @param array $header
     * @param array $payload
     * @param string $key
     * @param string $hashingAlgorithm
     * @return JwtAuth
     * @throws JwtException
     */
    public static function createJwt(array $header, array $payload, string $key, string $hashingAlgorithm = 'sha256'):JwtAuth{

        if (empty($header)){
            throw new JwtException("Header cannot be empty",1);
        }
        if (empty($payload)){
            throw new JwtException("Payload cannot be empty",2);
        }
        if (empty($key)){
            throw new JwtException("Secret Key cannot be empty",3);
        }

        $validAlgorithms = hash_algos();

        if (empty($hashingAlgorithm) || !in_array($hashingAlgorithm, $validAlgorithms, true)){
            throw new JwtException("Choose a valid hash algorithm",4);
        }

        $jwt = new JwtAuth();

        $jwt->header = JwtFunctions::base64url_encode(json_encode($header));
        $jwt->payload = JwtFunctions::base64url_encode(json_encode($payload));

        $sign = hash_hmac($hashingAlgorithm, "{$jwt->header}.{$jwt->payload}", $key, true);
        $jwt->sign = JwtFunctions::base64url_encode($sign);

        return $jwt;
    }

    /**
     * @param string $key
     * @param string $hashingAlgorithm
     * @return bool
     * @throws JwtException
     */
    public function verifyJwt(string $key, string $hashingAlgorithm = 'sha256'):bool {

        if (empty($key)){
            throw new JwtException("Secret Key cannot be empty",3);
        }

        $validAlgorithms = hash_algos();

        if (empty($hashingAlgorithm) || !in_array($hashingAlgorithm, $validAlgorithms, true)){
            throw new JwtException("Choose a valid hash algorithm",4);
        }

        $valid = hash_hmac($hashingAlgorithm, "{$this->header}.{$this->payload}", $key, true);
        $valid = JwtFunctions::base64url_encode($valid);

        if ($this->sign == $valid){

            try{
                $verify = JwtFunctions::verifyTokenExpiration($this->payload);
            }catch (JwtException $e){
                throw $e;
            }

            return $verify;
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
        return (array) json_decode(JwtFunctions::base64url_decode($this->header));
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return (array) json_decode(JwtFunctions::base64url_decode($this->payload));
    }
}
