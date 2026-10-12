<?php

class AdminRepository
{
    // Méthode qui récupère tous les utilisateurs ayant le rôle Employé (Id_role = 2)
    public static function getEmployes()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE Id_role = 2");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}