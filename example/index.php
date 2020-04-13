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

//Especificando o Algoritmo de hash para a criação do JWT:

$hashingAlgorithm = "sha256";

$jwtAuth = new JwtAuth($header,$payload,$key,$hashingAlgorithm);

//Criando um JWT a partir de um token:

$jwtToken = "header.payload.sign";

//Algoritmo usado para o hash do JWT
$hashingAlgorithm = "sha256";

$jwtAuth2 = JwtAuth::byToken($jwtToken,$hashingAlgorithm);

//Recuperando Informações:

// - Retorna uma String contendo o token JWT
$jwtAuth->getToken();

// - Faz a validação do token criado utilizando da chave de acesso
$jwtAuth->verifyJwt("My-Secret-Key");

// - Retorna um array contendo o Header
$jwtAuth->getHeader();

// - Retorna um array contendo o Payload
$jwtAuth->getPayload();

