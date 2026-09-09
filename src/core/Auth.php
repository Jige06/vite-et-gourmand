<?php

// Implémentation de la classe d'authentification de l'utilisateur

class Auth
{
    // Vérifie si l'utilisateur est connecté
    public static function isConnected()
    {
        return isset($_SESSION['id_user']);
    }

    // Vérifie si le rôle est correct
    public static function checkRole(string $role)
    {
        if (!self::isConnected()) {
            self::redirect('/connexion');
        }
        if ($role != $_SESSION['role']) {
            self::redirect('/');
        }
    }

    // Redirige l'utilisateur
    public static function redirect(string $url)
    {
        header('Location: ' . $url);
        die();
    }
}