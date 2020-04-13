# Jwt-Auth
A PHP library for JWT manipulation using native PHP.

## Installation

Jwt-Auth is avaliable via Composer

```bash
"pakpak/jwt-auth": "^1.0"
```

or via terminal:

```bash
composer require pakpak/jwt-auth
```

## Documentation

- Creating a JWT:

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

- Specifying the hash algorithm for JWT creation

```php
use PakPak\JwtAuth\JwtAuth;

$hashingAlgorithm = "sha256";

$jwtAuth = new JwtAuth($header,$payload,$key,$hashingAlgorithm);
```

- Creating a JWT from a token

```php
use PakPak\JwtAuth\JwtAuth;

$jwtToken = "header.payload.sign";

//Algorithm used for the JWT hash
$hashingAlgorithm = "sha256";

$jwtAuth2 = JwtAuth::byToken($jwtToken,$hashingAlgorithm);
```

- Recovering data:
```php
//Returns a String containing the JWT Token
$jwtAuth->getToken();

//Validates the token created using the access key
$jwtAuth->verifyJwt("My-Secret-Key");

//Returns an array containing the Header
$jwtAuth->getHeader();

//Returns an array containing the Payload
$jwtAuth->getPayload();
```
