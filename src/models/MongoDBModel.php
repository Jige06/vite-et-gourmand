<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;

class MongoDBModel
{

    // Variable statique qui va stocker la connexion MongoDB 
    private static $instance = null;

    // Méthode statique appelable sans instancier la classe
    public static function getInstance()
    {
        try {
            if (self::$instance === null) {
                $host = $_ENV['MONGO_HOST'];
                $port = $_ENV['MONGO_PORT'];

                self::$instance = new Client("mongodb://$host:$port");
            }
        } catch (\Throwable $th) {
            die("Erreur de connexion MongoDB: " . $th->getMessage());
        }
        return self::$instance;
    }

    public static function syncStats()
    {
        // Connexion à la BDD MySQL
        $pdo = DatabaseConnection::getInstance();

        // Requete qui récupère les statistiques
        $stmt= $pdo->prepare("SELECT m.titre, COUNT(commande.Id_commande) AS nbre_commandes, SUM(commande.montant_total) AS ca_total
        FROM commande
        JOIN menu ON commande.Id_menu = menu.Id_menu
        WHERE commande.Id_commande NOT IN (
        SELECT commande_statut_commande.Id_commande
        FROM commande_statut_commande
        JOIN statut_commande ON commande_statut_commande.Id_statut_commande = statut_commande.Id_statut_commande
        WHERE statut_commande.libelle = 'Annulé')
        GROUP BY menu.Id_menu, menu.titre");
        $stmt->execute();
        $stats = $stmt->fetchAll();

        // Connexion à MongoDB
        $collection = self::getInstance()->vite_gourmand->stats_commandes;

        // On vide la collection pour actualiser avec les nouvelles stats
        $collection->deleteMany([]);

        // Insertion des nouvelles stats
        $collection->insertMany($stats);
    }

    public static function getStats()
    {
        $collection = self::getInstance()->vite_gourmand->stats_commandes;

        $cursor = $collection->find([]);
        return iterator_to_array($cursor);
    }
}
