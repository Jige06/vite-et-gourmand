<?php

class MenuController
{
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

    public function showDetails()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "L'URL n'est pas valide.";
            Auth::redirect('/menus');
            return;
        }
        $idMenu = $_GET['id'];
        $details = MenuModel::getById($idMenu);
        if (!$details) {
            $_SESSION['error'] = "L'URL n'est pas valide.";
            Auth::redirect('/menus');
            return;
        }
        $plats = MenuModel::getPlatsByMenu($idMenu);
        foreach ($plats as &$plat) {
            $allergenes = MenuModel::getAllergenesByPlat($plat['Id_plat']);
            $plat['allergenes'] = $allergenes;
        }
        unset($plat);
        require_once(__DIR__ . '/../views/menus/detail.php');
    }

    public function showCreateMenu()
    {
        require_once(__DIR__ . '/../views/employe/nouveau-menu.php');
    }

    public function create() {}

    public function handleCreate() {}

    public function showUpdateMenu()
    {
        require_once(__DIR__ . '/../views/employe/maj-menu.php');
    }

    public function update() {}

    public function handleUpdate() {}

    public function delete() {}

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
