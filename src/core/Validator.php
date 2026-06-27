<?php

class Validator
{
    public static function nomValide($valeur)
    {
        return preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $valeur) === 1;
    }

    public static function emailValide($valeur)
    {
        return filter_var($valeur, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function codePostalValide($valeur)
    {
        return preg_match('/^[0-9]{5}$/', $valeur) === 1;
    }

    public static function telephoneValide($valeur)
    {
        return preg_match('/^[0-9]{10}$/', $valeur) === 1;
    }

    public static function motDePasseValide($valeur)
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $valeur) === 1;
    }
}