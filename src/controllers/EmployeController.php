<?php

class EmployeController
{
    public function showOrders()
    {
        // Vérification du rôle pour acceder à l'espace employé
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }

        $filters = [
            'statut' => $_GET['statut'] ?? null,
            'client' => $_GET['client'] ?? null,
        ];
        $orders = EmployeModel::getAllOrders($filters);

        require_once(__DIR__ . '/../views/employe/commandes.php');
    }

    public function updateStatus() {}

    public static function handleUpdateStatus()
    {
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }

        $idCommande = $_POST['Id_Commande'];
        $nouveauStatut = $_POST['nouveau_statut'];

        EmployeModel::updateStatus($idCommande, $nouveauStatut);
        $_SESSION['success'] = "Le statut de la commande a bien été mis à jour";
        Auth::redirect('/employe');
    }
}
