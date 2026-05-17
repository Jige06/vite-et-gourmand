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

    public function handleReviews()
    {
        if (
            !isset($_SESSION['role']) ||
            ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')
        ) {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // traitement du changement de statut
            $idAvis = $_POST['id_avis'];
            $statut = $_POST['statut'];
            ReviewModel::updateReviewStatus($idAvis, $statut);
            $_SESSION['success'] = "L'avis a bien été mis à jour";
            Auth::redirect('/employe/avis');
        } else {

            // affichage de la liste des avis
            $avis = ReviewModel::getPendingReviews();
            require_once(__DIR__ . '/../views/employe/avis.php');
        }
    }

    public function handleMenus()
    {
        // Vérification du rôle pour acceder à l'espace employé
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];

            if ($action === 'creer') {

                // appel handleCreate()
                $titre = trim($_POST['titre']);
                $descriptionMenu = trim($_POST['description_menu']);
                $prixParPers = intval($_POST['prix_par_pers']);
                $nbrePersMin = intval($_POST['nombre_pers_min']);
                $quantiteRestante = intval($_POST['quantite_restante']);
                $conditions = trim($_POST['conditions']);
                $regime = trim($_POST['regime']);
                $idTheme = intval($_POST['Id_theme']);
                $photo = null;
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                    $nomFichier = basename($_FILES['photo']['name']);
                    $destination = __DIR__ . '/../../public/assets/images/menus/' . $nomFichier;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
                    $photo = $nomFichier; // on stocke juste le nom en BDD
                }
                MenuModel::createMenu($titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme);
                $_SESSION['success'] = "Le menu a bien été créé.";
            } elseif ($action === 'modifier') {

                // appel handleUpdate()
                $idMenu = $_POST['Id_menu'];
                $titre = trim($_POST['titre']);
                $descriptionMenu = trim($_POST['description_menu']);
                $prixParPers = intval($_POST['prix_par_pers']);
                $nbrePersMin = intval($_POST['nombre_pers_min']);
                $quantiteRestante = intval($_POST['quantite_restante']);
                $conditions = trim($_POST['conditions']);
                $regime = trim($_POST['regime']);
                $idTheme = intval($_POST['Id_theme']);
                $photo = null;
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                    $nomFichier = basename($_FILES['photo']['name']);
                    $destination = __DIR__ . '/../../public/assets/images/menus/' . $nomFichier;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $destination);
                    $photo = $nomFichier; // on stocke juste le nom en BDD


                } else {

                    // récupérer l'ancienne photo depuis la BDD
                    $menuActuel = MenuModel::getById($idMenu);
                    $photo = $menuActuel['photo'];
                }

                MenuModel::updateMenu($idMenu, $titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme);
                $_SESSION['success'] = "Le menu a bien été modifié.";
            } elseif ($action === 'supprimer') {

                // appel delete()
                $idMenu = $_POST['Id_menu'];
                MenuModel::deleteMenu($idMenu);
                $_SESSION['success'] = "Le menu a bien été supprimé.";
            }
            Auth::redirect('/employe/menus');
        } else {
            $menus = MenuModel::getAllMenu();
            $themes = MenuModel::getAllThemes();
            require_once(__DIR__ . '/../views/employe/menus.php');
        }
    }
}
