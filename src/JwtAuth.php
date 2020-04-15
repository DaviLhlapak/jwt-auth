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
     * @throws JwtException
     */
    public function __construct(array $header, array $payload, string $key, string $hashingAlgorithm = 'sha256')
    {

        if (empty($header)){
            throw new JwtException("Header cannot be empty",1);
        }

        if (empty($payload)){
            throw new JwtException("Payload cannot be empty",2);
        }

        $this->header = $this->base64url_encode(json_encode($header));
        $this->payload = $this->base64url_encode(json_encode($payload));
        $this->hashingAlgorithm = $hashingAlgorithm??'sha256';

        if($key != "" && $key != null){$this->generateJwt($key);}
    }

    /**
     * @param string $token
     * @param string $hashingAlgorithm
     * @return JwtAuth|null
     * @throws JwtException
     */
    public static function byToken(string $token, string $hashingAlgorithm):JwtAuth{
        $part = explode(".",$token);
        $header = (array) json_decode(self::base64url_decode($part[0]));
        $payload = (array) json_decode(self::base64url_decode($part[1]));

        try{
            $jwt = new JwtAuth($header,$payload,"",$hashingAlgorithm);
        }catch (JwtException $e){
            throw $e;
        }

        $jwt->token = $token;

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
        $sign = $this->base64url_encode($sign);

        $this->token = "{$this->header}.{$this->payload}.{$sign}";
    }


    /**
     * @param string $key
     * @return bool
     */
    public function verifyJwt(string $key):bool {
        $part = explode(".",$this->token);
        $sign = $part[2];

        $valid = hash_hmac($this->hashingAlgorithm, "{$this->header}.{$this->payload}", $key, true);
        $valid = $this->base64url_encode($valid);

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
        return (array) json_decode($this->base64url_decode($this->header));
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return (array) json_decode($this->base64url_decode($this->payload));
    }


    /**
     * @param $data
     * @return bool|string
     */
    private static function base64url_encode($data)
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
    private static function base64url_decode($data, $strict = false)
    {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }
}
