# Jwt-Auth
Biblioteca PHP para a manipulação de JWT em PHP nativo.

## Instalação

Jwt-Auth está disponível via Composer:

```bash
"pakpak/jwt-auth": "^1.0"
```

ou pelo terminal:

```bash
composer require pakpak/jwt-auth
```

## Documentação

Criando um JWT:

```php
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
```

Especificando o Algoritmo de hash para a criação do JWT:

```php
use PakPak\JwtAuth\JwtAuth;

$hashingAlgorithm = "sha256";

$jwtAuth = new JwtAuth($header,$payload,$key,$hashingAlgorithm);
```

Criando um JWT a partir de um token:

```php
use PakPak\JwtAuth\JwtAuth;

$jwtToken = "header.payload.sign";

$hashingAlgorithm = "sha256";

$jwtAuth2 = JwtAuth::byToken($jwtToken,$hashingAlgorithm);
```

Recuperando Informações:
```php
//Retorna uma String contendo o token JWT
$jwtAuth->getToken();

//Faz a validação do token criado utilizando da chave de acesso
$jwtAuth->verifyJwt("My-Secret-Key");

//Retorna um array contendo o Header
$jwtAuth->getHeader();

//Retorna um array contendo o Payload
$jwtAuth->getPayload();
```
