<?php

class HomeController
{
    public function index()
    {
        // Récupération des avis validés pour les afficher
        $validatedReviews = ReviewRepository::getValidatedReviews();

        require_once(__DIR__ . '/../views/home/index.php');
    }
}