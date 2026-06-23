<?php

class ReviewRepository
{
    // Méthode de création d'un avis client
    public static function createReview($note, $descriptionAvis, $idCommande)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("INSERT INTO avis (note, description_avis, statut, Id_commande)
        VALUES (:note, :description_avis, 'En attente', :Id_commande)");

        $stmt->bindValue(':note', $note);
        $stmt->bindValue(':description_avis', $descriptionAvis);
        $stmt->bindValue(':Id_commande', $idCommande);

        $stmt->execute();
    }

    // Méthode qui récupère les avis en attente de validation
    public static function getPendingReviews()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT avis.*, utilisateur.nom, utilisateur.prenom, commande.date_commande
        FROM avis
        JOIN commande ON avis.Id_commande = commande.Id_commande
        JOIN utilisateur ON commande.Id_Utilisateur = utilisateur.Id_Utilisateur
        WHERE avis.statut = 'En attente' ");

        $stmt->execute();
        $avis = $stmt->fetchAll();
        return $avis;
    }

    // Méthode qui met à jour le statut des avis
    public static function updateReviewStatus($idAvis, $statut)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("UPDATE avis SET statut = ?, date_validation = NOW() WHERE Id_avis = ?");
        $stmt->execute([$statut, $idAvis]);
    }

    // Méthode qui récupère les 4 derniers avis validés
    public static function getValidatedReviews()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT avis.*, utilisateur.prenom
        FROM avis
        JOIN commande ON avis.Id_commande = commande.Id_commande
        JOIN utilisateur ON commande.Id_Utilisateur = utilisateur.Id_Utilisateur
        WHERE avis.statut = 'Validé'
        ORDER BY avis.date_validation DESC
        LIMIT 4");

        $stmt->execute();
        $validatedReviews = $stmt->fetchAll();
        return $validatedReviews;
    }

    //Méthode qui récupère tous les avis validés (sans limite)
    public static function getAllValidatedReviews()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT avis.*, utilisateur.prenom, menu.titre, menu.photo
        FROM avis
        JOIN commande ON avis.Id_commande = commande.Id_commande
        JOIN utilisateur ON commande.Id_Utilisateur = utilisateur.Id_Utilisateur
        JOIN menu ON commande.Id_menu = menu.Id_menu
        WHERE avis.statut = 'Validé'
        ORDER BY avis.date_validation DESC");

        $stmt->execute();
        $allValidatedReviews = $stmt->fetchAll();
        return $allValidatedReviews;
    }
}


