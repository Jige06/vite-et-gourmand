<?php

class HoraireRepository
{
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

    public static function getAllHoraire()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT horaire.* FROM horaire");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}