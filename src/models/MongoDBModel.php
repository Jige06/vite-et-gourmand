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

    // Méthode qui permlet de mettre à jour les stats
    public static function syncStats()
    {
        // Connexion à la BDD MySQL
        $pdo = DatabaseConnection::getInstance();

        // Requete qui récupère une ligne par commande avec la date de commande
        $stmt = $pdo->prepare("SELECT menu.titre, commande.montant_total, commande.date_commande
        FROM commande
        JOIN menu ON commande.Id_menu = menu.Id_menu
        WHERE commande.Id_commande NOT IN (
        SELECT commande_statut_commande.Id_commande
        FROM commande_statut_commande
        JOIN statut_commande ON commande_statut_commande.Id_statut_commande = statut_commande.Id_statut_commande
        WHERE statut_commande.libelle = 'Annulé')
        ");
        $stmt->execute();
        $stats = $stmt->fetchAll();

        // Connexion à MongoDB
        $collection = self::getInstance()->vite_gourmand->stats_commandes;

        // On vide la collection pour actualiser avec les nouvelles stats
        $collection->deleteMany([]);

        // Insertion des nouvelles stats (une ligne par commande)
        if (!empty($stats)) {
            $collection->insertMany($stats);
        }
    }

    // Méthode qui récupère les stats
    public static function getStats($menuFiltre = null, $dateDebut = null, $dateFin = null)
    {
        // Connexion à la colelction
        $collection = self::getInstance()->vite_gourmand->stats_commandes;

        // Construction du filtre
        $filtre = [];

        if ($menuFiltre) {
            $filtre['titre'] = $menuFiltre;
        }

        if ($dateDebut && $dateFin) {
            $filtre['date_commande'] = [
                '$gte' => $dateDebut,
                '$lte' => $dateFin,
            ];
        }

        // Agrégation MongoDB
        $pipeline = [];

        if (!empty($filtre)) {
            $pipeline[] = ['$match' => $filtre];
        }

        $pipeline[] = ['$group' => [
            '_id' => '$titre',
            'titre' => ['$first' => '$titre'],
            'nbre_commandes' => ['$sum' => 1],
            'ca_total' => ['$sum' => ['$toDouble' => '$montant_total']],
        ]];

        $pipeline[] = ['$sort' => ['titre' => 1]];

        $cursor = $collection->aggregate($pipeline);
        return iterator_to_array($cursor);
    }
}
