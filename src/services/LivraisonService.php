<?php

class LivraisonService
{
    // Coordonnées fixes de Vite & Gourmand - 19 Rue Bouffard, Bordeaux
    private const COORDS_VITE_GOURMAND = [-0.5763, 44.8404];

    // Méthode qui calcule les frais de livraison à partir d'une adresse complète
    public static function calculerFraisLivraison($adresseComplete)
    {
        $apiKey = $_ENV['ORS_API_KEY'];

        // Étape 1 : géocodage de l'adresse du client (texte -> coordonnées GPS)
        $coordsClient = self::geocoderAdresse($adresseComplete, $apiKey);
        if ($coordsClient === null) {
            return null; // adresse introuvable
        }

        // Étape 2 : calcul de la distance réelle par la route
        $distanceKm = self::calculerDistance($coordsClient, $apiKey);
        if ($distanceKm === null) {
            return null; // erreur lors du calcul de distance
        }

        // Étape 3 : calcul du prix selon la formule métier
        $prixLivraison = 5 + $distanceKm * 0.59;

        return [
            'prix' => round($prixLivraison, 2),
            'distance' => round($distanceKm, 1),
        ];
    }

    // Méthode privée qui géocode une adresse (texte -> coordonnées GPS)
    private static function geocoderAdresse($adresse, $apiKey)
    {
        $url = "https://api.openrouteservice.org/geocode/search?api_key=" . $apiKey . "&text=" . urlencode($adresse);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $reponse = curl_exec($ch);

        $data = json_decode($reponse, true);

        if (empty($data['features'])) {
            return null;
        }

        return $data['features'][0]['geometry']['coordinates'];
    }

    // Méthode privée qui calcule la distance réelle par la route entre deux coordonnées
    private static function calculerDistance($coordsClient, $apiKey)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: ' . $apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'coordinates' => [self::COORDS_VITE_GOURMAND, $coordsClient],
        ]));

        $reponse = curl_exec($ch);

        $data = json_decode($reponse, true);

        if (empty($data['routes'][0]['summary']['distance'])) {
            return null;
        }

        return $data['routes'][0]['summary']['distance'] / 1000; // conversion mètres -> km
    }
}