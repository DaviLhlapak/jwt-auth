<?php

require __DIR__ . "./../vendor/autoload.php";

use PakPak\JwtAuth\JwtAuth;

//Creating a JWT
$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];
$payload = [
    'iss' => "localhost",
    'sub' => 'User Name Yoshi'
];
$key = "My-Secret-Key";

$jwtAuth = JwtAuth::createJwt($header, $payload, $key);

//Specifying the hash algorithm for JWT creation
$hashingAlgorithm = "sha256";

$jwtAuth = JwtAuth::createJwt($header, $payload, $key, $hashingAlgorithm);

//Creating a JWT from a token
$jwtToken = "header.payload.sign";

$jwtAuth2 = JwtAuth::byJwt($jwtToken);

//Recovering data:

// - Validates the token created using the access key
$hashingAlgorithm = "sha256";
$jwtAuth->verifyJwt("My-Secret-Key",$hashingAlgorithm);

// - Returns a String containing the JWT Token
$jwtAuth->getJwt();

// - Returns an array containing the Header
$jwtAuth->getHeader();

// - Returns an array containing the Payload
$jwtAuth->getPayload();

