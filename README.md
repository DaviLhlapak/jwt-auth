# Jwt-Auth
A PHP library for JWT manipulation using native PHP.

## Installation

Jwt-Auth is avaliable via Composer

```bash
"pakpak/jwt-auth": "^1.5.2"
```

or via terminal:

```bash
composer require pakpak/jwt-auth
```

## Documentation

- To use JwtAuth in your code

```php
use PakPak\JwtAuth\JwtAuth;
```

- Creating a JWT:

```php
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
```

- Specifying the hash algorithm for JWT creation

```php
$hashingAlgorithm = "sha256";

$jwtAuth = JwtAuth::createJwt($header, $payload, $key, $hashingAlgorithm);
```

- Creating a JWT from a token

```php
$jwtToken = "header.payload.sign";

$jwtAuth = JwtAuth::byJwt($jwtToken);
```

- Recovering data:
```php
// - Validates the token created using the access key
$hashingAlgorithm = "sha256";
$jwtAuth->verifyJwt("My-Secret-Key",$hashingAlgorithm);

// - Returns a String containing the JWT Token
$jwtAuth->getJwt();

// - Returns an array containing the Header
$jwtAuth->getHeader();

// - Returns an array containing the Payload
$jwtAuth->getPayload();
```

- Creating a header using JwtFunctions:
````php
$header = \PakPak\JwtAuth\JwtFunctions::createHeader();
````

- Creating a Payload using JwtFunctions:
````php
$date = new DateTime("now");

//Token’s origin
$issuer = "www.meudominio.com";
//Token’s subject
$subject = "user";
//Expires in 1 day
$expiration = $date->add(\DateInterval::createFromDateString("1 day"))->getTimestamp();

$payload = \PakPak\JwtAuth\JwtFunctions::createPayload($issuer,$subject,$expiration);
````
## JwtException

- Error codes:

```text
Code 1: "Header cannot be empty"
Code 2: "Payload cannot be empty"
Code 3: "Secret Key cannot be empty"
Code 4: "Choose a valid hash algorithm"
Code 5: "Sign cannot be empty"
Code 6: "Invalid Token"
```
