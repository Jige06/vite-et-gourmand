<?php

class ContactController
{

    // Méthode qui gère le formulaire de contact
    public function handleContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifierToken($_POST['csrf_token'] ?? null)) {
                $_SESSION['error'] = "Une erreur de sécurité s'est produite, veuillez réessayer.";
                Auth::redirect('/contact');
                return;
            }
            $titre = trim(htmlspecialchars($_POST['titre']));
            $description = trim(htmlspecialchars($_POST['description']));
            $email = trim(htmlspecialchars($_POST['email']));

            if (!Validator::emailValide($email)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/contact');
                return;
            }

            ContactRepository::sendContactMail($titre, $description, $email);
            $_SESSION['success'] = "Votre message a bien été envoyé !";
            Auth::redirect('/contact');
        } else {
            $this->showContact();
        }
    }

    //Méthode qui affiche la vue de contact
    public function showContact()
    {
        require_once(__DIR__ . '/../views/contact/index.php');
    }
}
