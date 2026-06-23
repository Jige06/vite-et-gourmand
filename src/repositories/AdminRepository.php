<?php

class AdminRepository
{
    public static function getEmployes()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE Id_role = 2");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}