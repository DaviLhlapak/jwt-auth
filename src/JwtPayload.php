<?php


namespace PakPak\JwtAuth;

use DateTime;

class JwtPayload
{
    /** Identifies the principal that issued the JWT. @var String */
    private $issuer;

    /** Identifies the principal that is the subject of the JWT. @var String */
    private $subject;

    /** Identifies the expiration time on or after which the JWT MUST NOT be accepted for processing. @var int */
    private $expirationTime;

    /** Identifies the time at which the JWT was issued. @var int */
    private $issuedAt;

    /** Another claims array. @var array */
    private $privateClaims;

    /**
     * JwtPayload constructor.
     * If $ expirationTime or $ issueAt is not provided, by default, the Payload will contain the expiration date of 1 day.
     *
     * @param String $issuer
     * @param String $subject
     * @param int $expirationTime
     * @param int $issuedAt
     */
    public function __construct(string $issuer, string $subject, int $expirationTime = 0, int $issuedAt = 0)
    {

        if (empty($issuedAt)) {
            $this->issuedAt = (new DateTime("now"))->getTimestamp();
        } else {
            $this->issuedAt = $issuedAt;
        }

        if (empty($issuedAt)) {
            $this->expirationTime = (new DateTime("now"))->add(\DateInterval::createFromDateString("1 day"))->getTimestamp();
        } else {
            $this->expirationTime = $expirationTime;
        }

        $this->issuer = $issuer;
        $this->subject = $subject;
    }

    public static function createByArray(array $payload): JwtPayload
    {
        $payload = new JwtPayload($payload["iss"], $payload["sub"], $payload["exp"], $payload["iss"]);
    }

    public function getPayload(): array
    {
        return [
            'iss' => $this->issuer,
            'iat' => $this->issuedAt,
            'exp' => $this->expirationTime,
            'sub' => $this->subject
        ];
    }

}
