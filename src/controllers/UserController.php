<?php

class UserController
{
    // Methode qui appelle le repository pour mettre a jour le profil de l'utilisateur
    public function updateProfil()
    {
        // Vérification si un utilisateur est connecté
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        // Récupération des données de l'utilisateur saisies dans le formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifierToken($_POST['csrf_token'] ?? null)) {
                $_SESSION['error'] = "Une erreur de sécurité s'est produite, veuillez réessayer.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            $nom = trim(htmlspecialchars($_POST['nom']));
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $email = trim(htmlspecialchars($_POST['email']));
            $telephone = trim(htmlspecialchars($_POST['telephone']));
            $adresse = trim(htmlspecialchars($_POST['adresse']));
            $codePostal = trim(htmlspecialchars($_POST['code_postal']));
            $ville = trim(htmlspecialchars($_POST['ville']));
            $idUser = $_SESSION['id_user'];

            // Vérification que les champs ne contiennent que des lettres
            if (
                !Validator::nomValide($nom) ||
                !Validator::nomValide($prenom) ||
                !Validator::nomValide($ville)
            ) {
                $_SESSION['error'] = "Le nom, prénom et ville ne doivent contenir que des lettres.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            // Vérification du format de l'email
            if (!Validator::emailValide($email)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }
            // Vérification que le code postal ne contient que 5 chiffres
            if (!Validator::codePostalValide($codePostal)) {
                $_SESSION['error'] = "Le code postal doit contenir 5 chiffres.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }
            // Vérification que le téléphone ne contient que 10 chiffres
            if (!Validator::telephoneValide($telephone)) {
                $_SESSION['error'] = "Le numéro de téléphone doit contenir 10 chiffres.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            // Appel de la methode de mise à jour en BDD
            $result = UserRepository::updateProfil($idUser, $nom, $prenom, $email, $telephone, $adresse, $codePostal, $ville);

            // Si nouveau email saisi deja saisi en bdd --> message de refus de mis a jour
            if ($result === false) {
                $_SESSION['error'] = "Cet email n'est pas disponible, veuillez en choisir un autre.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            // Mise à jour de la session avec message de succès
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['email'] = $email;

            $_SESSION['success'] = "Votre profil a bien été mis à jour !";
            Auth::redirect('/mon-espace/commandes');
        } else {
            Auth::redirect('/mon-espace/commandes');
        }
    }
}
