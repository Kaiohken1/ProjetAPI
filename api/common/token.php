<?php

require 'vendor/autoload.php';


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validateJWT($authHeader) {
    if (!$authHeader) {
        throw new Exception('Accès non autorisé. Token manquant.', 401);
    }

    $token = str_replace('Bearer ', '', $authHeader);
    $decodedToken = JWT::decode($token, new Key('cleSuperSecrete', 'HS256'));

    if ($decodedToken->role !== 'admin') {
        throw new Exception('Accès non autorisé.', 403);
    }

    return $decodedToken;
}

function generateToken($userId, $username, $role) {
    $token = JWT::encode([
        'userId' => $userId,
        'username' => $username,
        'role' => $role,
        'exp' => time() + (60 * 60) 
    ], 'cleSuperSecrete');

    return $token;
}
?>