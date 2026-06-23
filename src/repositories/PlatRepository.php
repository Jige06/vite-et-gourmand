<?php
class PlatRepository
{

    // Méthode qui récupère tous les plats
    public static function getAllPlats()
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("SELECT plat.* FROM plat");

        $stmt->execute();
        return $stmt->fetchAll();
    }

     // Méthode qui permet de récupérer un plat par son Id
    public static function getById($idPlat)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("SELECT plat.* FROM plat WHERE plat.Id_plat = ?");

        $stmt->execute([$idPlat]);
        $plat =  $stmt->fetch();
        return $plat ?: null;
    }

    // Méthode qui permet de créer un nouveau plat
    public static function createPlat($titre, $typePlat, $photo)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO plat (titre, type_plat, photo)
        VALUES (:titre, :type_plat, :photo)");
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':type_plat', $typePlat);
        $stmt->bindValue(':photo', $photo);

        $stmt->execute();
    }

    // Méthode qui permet de modifier un plat existant
    public static function updatePlat($idPlat, $titre, $typePlat, $photo)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("UPDATE plat SET titre = :titre, type_plat = :type_plat, photo = :photo WHERE Id_plat = :idPlat");
        $stmt->bindValue(':idPlat', $idPlat);
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':type_plat', $typePlat);
        $stmt->bindValue(':photo', $photo);

        $stmt->execute();
    }

    // Méthode qui permet de supprimer un plat existant
    public static function deletePlat($idPlat)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("DELETE FROM plat where Id_plat = ?");
        $stmt->execute([$idPlat]);
    }
}
