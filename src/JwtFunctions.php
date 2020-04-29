<?php


namespace PakPak\JwtAuth;


use DateTime;

class JwtFunctions{

    /**
     * @param string $algo
     * @return array|string[]
     */
    public static function createHeader(string $algo):array{
        return [
            'typ' => 'JWT',
            'alg' => $algo
        ];
    }

    /**
     * @param string $issuer Token's origin
     * @param string $subject Entity to which the token belongs
     * @param int $expiration Timestamp of when the token expires
     * @return array|string[]
     */
    public static function createPayload(string $issuer, string $subject, int $expiration):array{
        return [
            'iss' => $issuer,
            'iat' => (new DateTime("now"))->getTimestamp(),
            'exp' => $expiration,
            'sub' => $subject
        ];
    }
}
