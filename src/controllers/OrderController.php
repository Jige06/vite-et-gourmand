<?php

class OrderController
{
    /**
     * Affiche la vue du formulaire de commande
     * Récupère l'ensemble des menus
     * Récupère les informations de l'utilisateur
     * Récupère l'id du menu du menu choisi
     */
    public function showOrder()
    {
        // Récupération de la liste des menus
        $menus = MenuModel::getAllMenu();
        // Récupération des infos de l'utilisateur
        $user = UserModel::findByEmail($_SESSION['email']);
        // Récupération de l'id du menu choisi
        $idMenu = isset($_GET['id_menu']) ? $_GET['id_menu'] : null;
        // Affichage de la vue order
        require_once(__DIR__ . '/../views/commande/order.php');
    }

    /**
     * Point d'entrée de la page commande.
     * Vérifie que l'utilisateur est connecté, puis
     * affiche le formulaire (GET) ou traite la commande (POST).
     */
    public function handleOrder()
    {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la connexion

        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }
        // Si le formulaire est soumis, on traite la commande
        // Sinon on affiche le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // traiter la commande
        } else {
            $this->showOrder();
        }
    }
}
