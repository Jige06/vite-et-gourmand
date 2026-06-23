<?php

class ContactController
{

    // Méthode qui gère le formulaire de contact
    public function handleContact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim(htmlspecialchars($_POST['titre']));
            $description = trim(htmlspecialchars($_POST['description']));
            $email = trim(htmlspecialchars($_POST['email']));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/contact');
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
