<?php


namespace PakPak\JwtAuth;

use Exception;

class JwtException extends Exception
{

    const ERROR_CODE_1 = "Header cannot be empty";
    const ERROR_CODE_2 = "Payload cannot be empty";
    const ERROR_CODE_3 = "Secret Key cannot be empty";
    const ERROR_CODE_4 = "Choose a valid hash algorithm";
    const ERROR_CODE_5 = "Sign cannot be empty";
    const ERROR_CODE_6 = "Invalid Token";

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
