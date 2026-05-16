<?php

class UserController
{
    public function updateProfil()
    {
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim(htmlspecialchars($_POST['nom']));
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $email = trim(htmlspecialchars($_POST['email']));
            $telephone = trim(htmlspecialchars($_POST['telephone']));
            $adresse = trim(htmlspecialchars($_POST['adresse']));
            $codePostal = trim(htmlspecialchars($_POST['code_postal']));
            $ville = trim(htmlspecialchars($_POST['ville']));
            $idUser = $_SESSION['id_user'];

            UserModel::updateProfil($idUser, $nom, $prenom, $email, $telephone, $adresse, $codePostal, $ville);

            // Mise à jour de la session
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
