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
    private $key;

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
        $this->header = $this->base64url_encode(json_encode($header));
        $this->payload = $this->base64url_encode(json_encode($payload));
        $this->key = $key;
        $this->hashingAlgorithm = $hashingAlgorithm;

        $this->generateToken();
    }

    private function generateToken(){
        $sign = hash_hmac($this->hashingAlgorithm, "{$this->header}.{$this->payload}", $this->key, true);
        $sign = $this->base64url_encode($sign);

        $this->token = "{$this->header}.{$this->payload}.{$sign}";
    }

    public function verifyJwt(){
        $part = explode(".",$this->token);

        $sign = $part[2];

        var_dump($sign);
    }

    /**
     * @param $data
     * @return bool|string
     */
    private function base64url_encode($data)
    {
        $b64 = base64_encode($data);
        if ($b64 === false) {
            return false;
        }
        $url = strtr($b64, '+/', '-_');
        return rtrim($url, '=');
    }

    /**
     * @param $data
     * @param bool $strict
     * @return false|string
     */
    private function base64url_decode($data, $strict = false)
    {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

}
