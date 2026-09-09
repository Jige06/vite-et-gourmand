<?php
class AvisController
{

    // Méthode qui récupère tous les avis validés et les envoie à la vue
    public function index()
    {
        $allValidatedReviews = ReviewRepository::getAllValidatedReviews();

        require_once(__DIR__ . '/../views/avis/index.php');
    }
}