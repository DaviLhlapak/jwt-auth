<?php

require __DIR__ . "./../vendor/autoload.php";

//Creating a JWT

use PakPak\JwtAuth\JwtAuth;
use PakPak\JwtAuth\JwtException;

$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];

$payload = [
    'iss' => "localhost",
    'sub' => 'User Name Yoshi'
];

$key = "My-Secret-Key";

try {
    $jwtAuth = new JwtAuth($header, $payload, $key);
} catch (JwtException $e) {
    var_dump($e->getMessage());
    die();
}

//Specifying the hash algorithm for JWT creation

$hashingAlgorithm = "sha256";

try {
    $jwtAuth = new JwtAuth($header, $payload, $key, $hashingAlgorithm);
} catch (JwtException $e) {
    var_dump($e->getMessage());
    die();
}

//Creating a JWT from a token

$jwtToken = "header.payload.sign";

//Algorithm used for the JWT hash
$hashingAlgorithm = "sha256";

try {
    $jwtAuth2 = JwtAuth::byToken($jwtToken, $hashingAlgorithm);
} catch (JwtException $e) {
    var_dump($e->getMessage());
    die();
}

//Recovering data:

// - Returns a String containing the JWT Token
$jwtAuth->getToken();

// - Validates the token created using the access key
$jwtAuth->verifyJwt("My-Secret-Key");

// - Returns an array containing the Header
$jwtAuth->getHeader();

// - Returns an array containing the Payload
$jwtAuth->getPayload();

