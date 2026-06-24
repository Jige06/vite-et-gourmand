<?php

class EmployeController
{
    // Méthode qui appelle le model pour récuperer toutes les commandes
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
        $orders = EmployeRepository::getAllOrders($filters);

        require_once(__DIR__ . '/../views/employe/commandes.php');
    }

    // Méthode qui appelle le modele pour mettre a jour le statut d'une commande
    public static function handleUpdateStatus()
    {
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }

        $idCommande = $_POST['Id_Commande'];
        $nouveauStatut = $_POST['nouveau_statut'];

        $result = EmployeRepository::updateStatus($idCommande, $nouveauStatut);

        // Si nouveau statut saisi a deja été passé --> message de refus de ce statut
        if ($result === false) {
            $_SESSION['error'] = "Ce statut de commande a deja été validé.";
            Auth::redirect('/employe');
            return;
        }

        $_SESSION['success'] = "Le statut de la commande a bien été mis à jour";
        Auth::redirect('/employe');
    }

    // Méthode qui appelle le model pour changer le statut d'un avis client (validé/refusé)
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
            ReviewRepository::updateReviewStatus($idAvis, $statut);
            $_SESSION['success'] = "L'avis a bien été mis à jour";
            Auth::redirect('/employe/avis');
        } else {

            // affichage de la liste des avis
            $avis = ReviewRepository::getPendingReviews();
            require_once(__DIR__ . '/../views/employe/avis.php');
        }
    }

    // Méthode CRUD pour gérer les menus (creation, modification, suppression) depuis l'espace employe
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

                $titre = trim($_POST['titre']);
                $descriptionMenu = trim($_POST['description_menu']);
                $prixParPers = intval($_POST['prix_par_pers']);
                $nbrePersMin = intval($_POST['nombre_pers_min']);
                $quantiteRestante = intval($_POST['quantite_restante']);
                $conditions = trim($_POST['conditions']);
                $regime = trim($_POST['regime']);
                $idTheme = intval($_POST['Id_theme']);

                $fichier = $_FILES['photo'] ?? null;
                $dossierDestination = __DIR__ . '/../../public/assets/images/menus/uploads/';
                $nomFichier = FileUploadHandler::uploadImage($fichier, $dossierDestination);

                if ($nomFichier === null) {
                    $_SESSION['error'] = "La photo est obligatoire et doit être une image valide (jpg, png, webp, max 6 Mo).";
                    Auth::redirect('/employe/menus');
                    return;
                }

                $photo = 'uploads/' . $nomFichier;

                MenuRepository::createMenu($titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme);
                $_SESSION['success'] = "Le menu a bien été créé.";

            } elseif ($action === 'modifier') {

                $idMenu = $_POST['Id_menu'];
                $titre = trim($_POST['titre']);
                $descriptionMenu = trim($_POST['description_menu']);
                $prixParPers = intval($_POST['prix_par_pers']);
                $nbrePersMin = intval($_POST['nombre_pers_min']);
                $quantiteRestante = intval($_POST['quantite_restante']);
                $conditions = trim($_POST['conditions']);
                $regime = trim($_POST['regime']);
                $idTheme = intval($_POST['Id_theme']);

                $fichier = $_FILES['photo'] ?? null;
                $dossierDestination = __DIR__ . '/../../public/assets/images/menus/uploads/';
                $nouvellePhoto = FileUploadHandler::uploadImage($fichier, $dossierDestination);

                if ($nouvellePhoto !== null) {
                    $photo = 'uploads/' . $nouvellePhoto;
                    
                } else {
                    // pas de nouveau fichier valide : on garde l'ancienne photo
                    $menuActuel = MenuRepository::getById($idMenu);
                    $photo = $menuActuel['photo'];
                }

                MenuRepository::updateMenu($idMenu, $titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme);
                $_SESSION['success'] = "Le menu a bien été modifié.";
            } elseif ($action === 'supprimer') {

                $idMenu = $_POST['Id_menu'];
                MenuRepository::deleteMenu($idMenu);
                $_SESSION['success'] = "Le menu a bien été supprimé.";
            }
            Auth::redirect('/employe/menus');
        } else {
            $menus = MenuRepository::getAllMenu();
            $themes = MenuRepository::getAllThemes();
            require_once(__DIR__ . '/../views/employe/menus.php');
        }
    }

    // Méthode CRUD pour gérer les plats (creation, modification, suppression) depuis l'espace employe
    public function handlePlats()
    {
        // Vérification du rôle pour acceder à l'espace employé
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Employé' && $_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];

            if ($action === 'creer') {

                $titre = trim($_POST['titre']);
                $typePlat = trim($_POST['type_plat']);

                $fichier = $_FILES['photo'] ?? null;
                $dossierDestination = __DIR__ . '/../../public/assets/images/plats/uploads/';
                $nomFichier = FileUploadHandler::uploadImage($fichier, $dossierDestination);

                if ($nomFichier === null) {
                    $_SESSION['error'] = "La photo est obligatoire et doit être une image valide (jpg, png, webp, max 6 Mo).";
                    Auth::redirect('/employe/plats');
                    return;
                }

                $photo = 'uploads/' . $nomFichier;

                PlatRepository::createPlat($titre, $typePlat, $photo);
                $_SESSION['success'] = "Le plat a bien été créé.";
            } elseif ($action === 'modifier') {

                $idPlat = $_POST['Id_plat'];
                $titre = trim($_POST['titre']);
                $typePlat = trim($_POST['type_plat']);

                $fichier = $_FILES['photo'] ?? null;
                $dossierDestination = __DIR__ . '/../../public/assets/images/plats/uploads/';
                $nouvellePhoto = FileUploadHandler::uploadImage($fichier, $dossierDestination);

                if ($nouvellePhoto !== null) {
                    $photo = 'uploads/' . $nouvellePhoto;
                } else {

                    // récupérer l'ancienne photo depuis la BDD
                    $platActuel = PlatRepository::getById($idPlat);
                    $photo = $platActuel['photo'];
                }

                PlatRepository::updatePlat($idPlat, $titre, $typePlat, $photo);
                $_SESSION['success'] = "Le plat a bien été modifié.";
            } elseif ($action === 'supprimer') {

                $idPlat = $_POST['Id_plat'];
                PlatRepository::deletePlat($idPlat);
                $_SESSION['success'] = "Le plat a bien été supprimé.";
            }
            Auth::redirect('/employe/plats');
        } else {
            $plats = PlatRepository::getAllPlats();
            require_once(__DIR__ . '/../views/employe/plats.php');
        }
    }
}
