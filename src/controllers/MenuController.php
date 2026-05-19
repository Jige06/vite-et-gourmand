<?php

class MenuController
{

    // Affiche la page liste des menus selon les données des filtres
    // Récupère les menus, thèmes, régimes et fourchettes de prix depuis le MenuModel
    public function index()
    {
        $menus = MenuModel::getAllMenu();
        $themes = MenuModel::getAllThemes();
        $regimes = MenuModel::getAllRegimes();
        $minPersonnes = MenuModel::getMinPersonnes();
        $minPrix = MenuModel::getMinPrix();
        $maxPrix = MenuModel::getMaxPrix();

        require_once(__DIR__ . '/../views/menus/index.php');
    }

    // Filtre les menus selon les critères passés en GET et retourne le résultat en JSON.
    // Utilisé par le fetch JavaScript pour le filtrage dynamique sans rechargement de page.
    public function filter()
    {
        $filters = [
            'prix_min' => $_GET['prix_min'] ?? null,
            'prix_max' => $_GET['prix_max'] ?? null,
            'theme' => $_GET['theme'] ?? null,
            'regime' => $_GET['regime'] ?? null,
            'nb_personnes' => $_GET['nb_personnes'] ?? null,
        ];

        $menus = MenuModel::getByFilters($filters);
        header('Content-Type: application/json');
        echo json_encode($menus);
    }
}
