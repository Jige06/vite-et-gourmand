<?php

class AdminController
{
    // Méthode qui gère la création d'un compte employé avec l'envoi du mot de passe par mail et la desactivation d'un compte
    public function handleNewEmploye()
    {
        // Vérification du rôle pour acceder à l'espace employé
        if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Administrateur')) {
            header('Location: /connexion');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];

            if ($action === 'creer') {

                $nom = trim(htmlspecialchars($_POST['nom']));
                $prenom = trim(htmlspecialchars($_POST['prenom']));
                $email = trim(htmlspecialchars($_POST['email']));
                $password = trim($_POST['password']);

                if (
                    !preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $nom) ||
                    !preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $prenom)
                ) {
                    $_SESSION['error'] = "Le nom et prénom ne doivent contenir que des lettres.";
                    Auth::redirect('/admin');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = "L'adresse email n'est pas valide.";
                    Auth::redirect('/admin');
                }

                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $password)) {
                    $_SESSION['error'] = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                    Auth::redirect('/admin');
                }

                if ($_POST['password'] !== $_POST['confirm_password']) {
                    $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                    Auth::redirect('/admin');
                }

                $result = UserModel::createEmploye($nom, $prenom, $email, $password);

                // Si l'email saisi existe deja en bdd --> message de refus
                if ($result === false) {
                    $_SESSION['error'] = "Cet email n'est pas disponible, veuillez en choisir un autre.";
                    Auth::redirect('/admin');
                    return;
                }

                UserModel::sendNewEmployeMail($nom, $prenom, $email);

                $_SESSION['success'] = "Le compte employé a bien été créé.";
            } elseif ($action === 'desactiver') {
                $idUser = $_POST['id_user'];
                UserModel::deactivateUser($idUser);
                $_SESSION['success'] = "Le compte employé a bien été desactivé.";
            }
            Auth::redirect('/admin');
        } else {
            $employes = AdminModel::getEmployes();
            require_once(__DIR__ . '/../views/admin/index.php');
        }
    }

    // Méthode qui gère la synchronisation, la récuperation et l'affichage des stats
    public function handleStats()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Administrateur') {
            Auth::redirect('/connexion');
            return;
        }
        MongoDBModel::syncStats();

        // Récupération des filtres depuis l'url (GET)
        $menuFiltre = isset($_GET['menu']) && $_GET['menu'] !== '' ? trim($_GET['menu']) : null;
        $dateDebut = isset($_GET['date_debut']) && $_GET['date_debut'] !== '' ? trim($_GET['date_debut']) : null;
        $dateFin = isset($_GET['date_fin']) && $_GET['date_fin'] !== '' ? trim($_GET['date_fin']) : null;

        // Récupération de tous les menus distincts pour le select
        $collection = MongoDBModel::getInstance()->vite_gourmand->stats_commandes;
        $menus = $collection->distinct('titre');
        sort($menus);

        $stats = MongoDBModel::getStats($menuFiltre, $dateDebut, $dateFin);

        require_once(__DIR__ . '/../views/admin/stats.php');
    }
}
