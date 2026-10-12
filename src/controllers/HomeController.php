<?php

class HomeController
{
    // Méthode qui affiche la page d'accueil avec les avis clients validés
    public function index()
    {
        // Récupération des avis validés pour les afficher
        $validatedReviews = ReviewRepository::getValidatedReviews();

        require_once(__DIR__ . '/../views/home/index.php');
    }
}