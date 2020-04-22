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
     * @param string $subject
     * @return array|string[]
     */
    public static function createPayload(string $subject):array{
        return [
            'iss' => "localhost",
            'sub' => $subject
        ];
    }
}
