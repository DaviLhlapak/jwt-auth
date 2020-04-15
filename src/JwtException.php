<?php


namespace PakPak\JwtAuth;

use Exception;

class JwtException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
