<?php

/* Implémentation de la classe permettant la connexion à la base de données
en utilisant le design pattern Singleton */

class DatabaseConnection
{
    private static $instance = null;

    // Constructeur privé : empêche l'instanciation directe (Singleton)
    private function __construct() {}

    // Méthode qui retourne l'unique connexion PDO, en la créant au premier appel à partir des variables d'environnement
    public static function getInstance()
    {
        try {
            if (self::$instance === null) {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];

                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            }
        } catch (Exception $e) {
            die("Erreur de connexion: " . $e->getMessage());
        }

        return self::$instance;
    }
}
