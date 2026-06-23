<?php

class MenuController
{

    // Affiche la page liste des menus selon les données des filtres
    // Récupère les menus, thèmes, régimes et fourchettes de prix depuis le MenuRepository
    public function index()
    {
        $menus = MenuRepository::getAllMenu();
        $themes = MenuRepository::getAllThemes();
        $regimes = MenuRepository::getAllRegimes();
        $minPersonnes = MenuRepository::getMinPersonnes();
        $minPrix = MenuRepository::getMinPrix();
        $maxPrix = MenuRepository::getMaxPrix();

        require_once(__DIR__ . '/../views/menus/index.php');
    }

    // Affiche la page détail d'un menu
    public function showDetails()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "L'URL n'est pas valide.";
            Auth::redirect('/menus');
            return;
        }
        $idMenu = $_GET['id'];
        $details = MenuRepository::getById($idMenu);
        if (!$details) {
            $_SESSION['error'] = "L'URL n'est pas valide.";
            Auth::redirect('/menus');
            return;
        }
        $plats = MenuRepository::getPlatsByMenu($idMenu);
        foreach ($plats as &$plat) {
            $allergenes = MenuRepository::getAllergenesByPlat($plat['Id_plat']);
            $plat['allergenes'] = $allergenes;
        }
        unset($plat);
        require_once(__DIR__ . '/../views/menus/detail.php');
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

        $menus = MenuRepository::getByFilters($filters);
        header('Content-Type: application/json');
        echo json_encode($menus);
    }
}
