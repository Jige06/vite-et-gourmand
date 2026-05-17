<?php

class UserController
{
    // Methode qui appelle le model pour mettre a jour le profil de l'utilisateur
    public function updateProfil()
    {
        // Vérification si un utilisateur est connecté
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        // Récupération des données de l'utilisateur saisies dans le formulaire de modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim(htmlspecialchars($_POST['nom']));
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $email = trim(htmlspecialchars($_POST['email']));
            $telephone = trim(htmlspecialchars($_POST['telephone']));
            $adresse = trim(htmlspecialchars($_POST['adresse']));
            $codePostal = trim(htmlspecialchars($_POST['code_postal']));
            $ville = trim(htmlspecialchars($_POST['ville']));
            $idUser = $_SESSION['id_user'];

            // Appel de la methode de mise à jour en BDD
            $result = UserModel::updateProfil($idUser, $nom, $prenom, $email, $telephone, $adresse, $codePostal, $ville);

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
