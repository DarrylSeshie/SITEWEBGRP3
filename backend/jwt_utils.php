<?php


$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE, PUT');
header('Content-Type: application/json');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('./vendor/autoload.php');

global $jwt_secretKey;
global $jwt_serverName;
global $jwt_algorithm;

$jwt_secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
$jwt_serverName = "localhost";
$jwt_algorithm = "HS512";


function generateJWT($username, $userId)
{
  global $jwt_secretKey;
  global $jwt_serverName;
  global $jwt_algorithm;
  $issuedAt   = new DateTimeImmutable();
  $expire     = $issuedAt->modify('+5 minutes')->getTimestamp();

    $data = [
        'iat' => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
        'iss' => $jwt_serverName,              // Issuer
        'nbf' => $issuedAt->getTimestamp(),    // Not before
        'exp' => $expire,                      // Expire
        'userId' => $userId,
        'email' => $username,                  // User name
    ];

    // Encode the array to a JWT string.
    return JWT::encode(
        $data,
        $jwt_secretKey,
        $jwt_algorithm
    );
}


function validateJWT()
{
  global $jwt_serverName;
  global $jwt_secretKey;
  global $jwt_algorithm;

  if (!preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Token not provided';
    exit;
  }

  $jwt = $matches[1];
  if (!$jwt) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Token is missing';
    exit;
  }

  try {
    $token = JWT::decode($jwt, new Key($jwt_secretKey, $jwt_algorithm));
    $now = new DateTimeImmutable();
    if (
      $token->iss !== $jwt_serverName ||
      $token->nbf > $now->getTimestamp() ||
      $token->exp < $now->getTimestamp()
    ) {
      header('HTTP/1.1 401 Unauthorized');
      echo 'Token is not valid !';
      exit;
    }
  } catch (Exception $e) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Token is not a JWT';
    exit;
  }
  return $token;
}
