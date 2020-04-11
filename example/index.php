<?php

require __DIR__ . "./../vendor/autoload.php";

use PakPak\JwtAuth\JwtAuth;

$jwtAuth = new JwtAuth([
    'typ' => 'JWT',
    'alg' => 'HS256'
],[
    'iss' => "localhost",
    'sub' => 'Davi Lhlapak Rosa',
],"Davi");

echo "Token: " . $jwtAuth->getToken() . "<br>";

$jwtAuth->verifyJwt();
