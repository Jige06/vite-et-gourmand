<?php

class LegalController
{

    // Méthode qui affiche la page des conditions générales de vente
    public function showCgv()
    {
        require_once(__DIR__ . '/../views/legal/cgv.php');
    }

    // Méthode qui affiche la page des mentions légales
    public function showMentionsLegales()
    {
        require_once(__DIR__ . '/../views/legal/mentions-legales.php');

    }
}