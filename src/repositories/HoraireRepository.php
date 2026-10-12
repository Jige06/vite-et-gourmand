<?php

class HoraireRepository
{
    // Méthode qui modifie les heures d'ouverture et de fermeture d'un jour
    public static function updateHoraire($idHoraire, $heureOuverture, $heureFermeture)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("UPDATE horaire SET heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture
        WHERE Id_horaire = :id_horaire");
        $stmt->bindValue(':id_horaire', $idHoraire);
        $stmt->bindValue(':heure_ouverture', $heureOuverture);
        $stmt->bindValue(':heure_fermeture', $heureFermeture);

        $stmt->execute();
    }

    // Méthode qui récupère les horaires d'ouverture de tous les jours
    public static function getAllHoraire()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT horaire.* FROM horaire");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}