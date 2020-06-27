<?php


namespace PakPak\JwtAuth;

class JwtFunctions{

    /**
     * @return array|string[]
     */
    public static function createHeader():array{
        return [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
    }


    /**
     * @param $data
     * @return bool|string
     */
    public static function base64url_encode($data)
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
    public static function base64url_decode($data, $strict = false)
    {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }
}
