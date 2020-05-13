<?php


namespace PakPak\JwtAuth;


use DateTime;

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

    /**
     * @param string $payload
     * @return bool
     * @throws JwtException
     */
    public static function verifyTokenExpiration(string $payload):bool{

        if (empty($payload)){
            throw new JwtException(JwtException::ERROR_CODE_2,2);
        }

        $payloadArray = json_decode(self::base64url_decode($payload),true);

        $iat = $payloadArray["iat"];
        $exp = $payloadArray["exp"];

        if(empty($iat) || empty($exp)){
            throw new JwtException(JwtException::ERROR_CODE_6,6);
        }

        if ($iat > $exp){
            return false;
        }

        return true;
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
