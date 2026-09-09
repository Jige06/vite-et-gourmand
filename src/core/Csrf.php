<?php

class Csrf
{
    // Génère un token CSRF s'il n'existe pas encore en session, et le retourne
    public static function genererToken()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Vérifie qu'un token reçu correspond à celui stocké en session
    public static function verifierToken($token)
    {
        if (!isset($_SESSION['csrf_token']) || !is_string($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}