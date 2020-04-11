<?php

require __DIR__ . "./../vendor/autoload.php";

use PakPak\JwtAuth\JwtAuth;

$jwtAuth = new JwtAuth(['typ' => 'JWT', 'alg' => 'HS256'], ['iss' => "localhost", 'sub' => 'User Name Yoshi',], "My-Key");

var_dump($jwtAuth);

var_dump($jwtAuth->getToken());

var_dump($jwtAuth->verifyJwt("My-Key"));

var_dump($jwtAuth->getHeader());

var_dump($jwtAuth->getPayload());

$jwtAuth2 = JwtAuth::byToken("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJzdWIiOiJVc2VyIE5hbWUgWW9zaGkifQ.2odzoYvJRfeYkUid5j8tssWL67QFOMSFgqzJDfOvcEE", "My-Key");

var_dump($jwtAuth2);
