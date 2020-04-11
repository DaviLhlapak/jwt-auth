<?php

namespace PakPak\JwtAuth;

/**
 * Class JwtAuth
 * @package PakPak\JwtAuth
 */
class JwtAuth{

    /** @var array */
    private $header;

    /** @var array */
    private $payload;

    /** @var string */
    private $token;

    /** @var string */
    private $hashingAlgorithm;


    /**
     * JwtAuth constructor.
     * @param array $header
     * @param array $payload
     * @param string $key
     * @param string $hashingAlgorithm
     */
    public function __construct(array $header, array $payload, string $key, string $hashingAlgorithm = 'sha256')
    {
        $this->header = base64url_encode(json_encode($header));
        $this->payload = base64url_encode(json_encode($payload));
        $this->hashingAlgorithm = $hashingAlgorithm;

        $this->generateJwt($key);
    }

    /**
     * @param string $token
     * @param string $key
     * @param string $hashingAlgorithm
     * @return JwtAuth|null
     */
    public static function byToken(string $token, string $key, string $hashingAlgorithm = 'sha256'){
        $part = explode(".",$token);
        $header = (array) json_decode(base64url_decode($part[0]));
        $payload = (array) json_decode(base64url_decode($part[1]));

        $jwt = new JwtAuth($header,$payload,$key,$hashingAlgorithm);

        if ($jwt->getToken() == $token){
            return $jwt;
        }else{
            return null;
        }
    }

    /**
     * @param string $key
     */
    private function generateJwt(string $key){
        $sign = hash_hmac($this->hashingAlgorithm, "{$this->header}.{$this->payload}", $key, true);
        $sign = base64url_encode($sign);

        $this->token = "{$this->header}.{$this->payload}.{$sign}";
    }


    public function verifyJwt(string $key){
        $part = explode(".",$this->token);
        $sign = $part[2];

        $valid = hash_hmac($this->hashingAlgorithm, "{$this->header}.{$this->payload}", $key, true);
        $valid = base64url_encode($valid);

        if ($sign == $valid){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return (array) json_decode(base64url_decode($this->header));
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return (array) json_decode(base64url_decode($this->payload));
    }


}
