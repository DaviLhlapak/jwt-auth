# Jwt-Auth
A PHP library for JWT manipulation using native PHP.

## Installation

Jwt-Auth is avaliable via Composer

```bash
"pakpak/jwt-auth": "^2.0.0"
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
use PakPak\JwtAuth\JwtAuth;
use PakPak\JwtAuth\JwtPayload;

$payload = new JwtPayload("localhost","user_id");
$key = "My-Secret-Key";

$jwtAuth = JwtAuth::createJwt($payload, $key);
```

- Creating a JWT from a token

```php
use PakPak\JwtAuth\JwtAuth;

$jwtToken = "header.payload.sign";

$jwtAuth = JwtAuth::byJwt($jwtToken);
```

- Recovering data:
```php
// - Validates the token created using the access key
$jwtAuth->verifyJwt("My-Secret-Key");

// - Returns a String containing the JWT Token
$jwtAuth->getJwt();

// - Returns an array containing the Header
$jwtAuth->getHeader();

// - Returns an array containing the Payload
$jwtAuth->getPayload();
```

- Creating a header using JwtFunctions:
````php
use PakPak\JwtAuth\JwtFunctions;

$header = JwtFunctions::createHeader();
````

- Creating a Payload:
````php
use PakPak\JwtAuth\JwtPayload;

//Token’s origin
$issuer = "www.meudominio.com";
//Token’s subject
$subject = "user_id";

$payload = new JwtPayload($issuer,$subject);
````
## JwtException

- Error codes:

| Code | Message          |
| :---- | :-------------: |
| 1 | "Header cannot be empty" |
| 2 | "Payload cannot be empty" |
| 3 | "Secret Key cannot be empty" |
| 4 | "Sign cannot be empty" |
| 5 | "Invalid Token" |
