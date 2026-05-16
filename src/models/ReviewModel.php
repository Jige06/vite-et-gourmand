<?php

class ReviewModel
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

    public static function updateReviewStatus($idAvis, $statut)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("UPDATE avis SET statut = ?, date_validation = NOW() WHERE Id_avis = ?");
        $stmt->execute([$statut, $idAvis]);

    }
}


