<?php

class Validator
{
    // Méthode qui vérifie qu'un nom ne contient que des lettres (accents compris), des espaces ou des tirets
    public static function nomValide($valeur)
    {
        return preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $valeur) === 1;
    }

    // Méthode qui vérifie que l'adresse email a un format valide
    public static function emailValide($valeur)
    {
        return filter_var($valeur, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Méthode qui vérifie que le code postal contient exactement 5 chiffres
    public static function codePostalValide($valeur)
    {
        return preg_match('/^[0-9]{5}$/', $valeur) === 1;
    }

    // Méthode qui vérifie que le numéro de téléphone contient exactement 10 chiffres
    public static function telephoneValide($valeur)
    {
        return preg_match('/^[0-9]{10}$/', $valeur) === 1;
    }

    // Méthode qui vérifie que le mot de passe fait au moins 10 caractères, avec une majuscule, une minuscule, un chiffre et un caractère spécial
    public static function motDePasseValide($valeur)
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $valeur) === 1;
    }
}