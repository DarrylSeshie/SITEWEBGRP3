<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('./vendor/autoload.php');

// Définition des variables globales pour la clé secrète, le serveur et l'algorithme
$jwt_secretKey = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
$jwt_serverName = "localhost";
$jwt_algorithm = "HS512";

/**
 * Génère un JWT pour un utilisateur donné.
 * 
 * @param string $username Le nom d'utilisateur pour lequel le JWT est généré.
 * @return string Le token JWT encodé.
 */
function generateJWT($username)
{
    global $jwt_secretKey, $jwt_serverName, $jwt_algorithm;
    $issuedAt = new DateTimeImmutable();
    $expire = $issuedAt->modify('+1 minutes')->getTimestamp();

    $data = [
        'iat' => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
        'iss' => $jwt_serverName,              // Issuer
        'nbf' => $issuedAt->getTimestamp(),    // Not before
        'exp' => $expire,                      // Expire
        'email' => $username,                  // User name
    ];

    // Encode the array to a JWT string.
    return JWT::encode(
        $data,
        $jwt_secretKey,
        $jwt_algorithm
    );
}

/**
 * Valide un JWT reçu via le header Authorization.
 * 
 * @return object|void Le JWT décodé si valide, sinon termine la requête avec une erreur.
 */
function validateJWT()
{
    global $jwt_secretKey, $jwt_algorithm;
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No authorization header sent']);
        exit;
    }

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    $token = null;
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    if (!$token) {
        http_response_code(401);
        echo json_encode(['error' => 'Bearer token not found']);
        exit;
    }

    try {
        return JWT::decode($token, new Key($jwt_secretKey, $jwt_algorithm));
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid or expired token: ' . $e->getMessage()]);
        exit;
    }
}
