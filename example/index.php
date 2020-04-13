<?php

require __DIR__ . "./../vendor/autoload.php";

//Criando um JWT:

use PakPak\JwtAuth\JwtAuth;

$header = [
    'typ' => 'JWT',
    'alg' => 'HS256'
];

$payload = [
    'iss' => "localhost",
    'sub' => 'User Name Yoshi'
];

$key = "My-Secret-Key";

$jwtAuth = new JwtAuth($header,$payload,$key);

//Recuperando Informações:

//-Retorna uma String contendo o token JWT
$jwtAuth->getToken();

//-Faz a validação do token criado utilizando da chave de acesso
$jwtAuth->verifyJwt("My-Secret-Key");

//-Retorna um array contendo o Header
$jwtAuth->getHeader();

//-Retorna um array contendo o Payload
$jwtAuth->getPayload();

$jwtAuth2 = JwtAuth::byToken("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJsb2NhbGhvc3QiLCJzdWIiOiJVc2VyIE5hbWUgWW9zaGkifQ.2odzoYvJRfeYkUid5j8tssWL67QFOMSFgqzJDfOvcEE", "sha256");

