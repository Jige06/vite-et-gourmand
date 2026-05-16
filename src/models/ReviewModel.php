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
}
