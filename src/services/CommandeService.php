<?php

class CommandeService
{
    // Méthode qui calcule le prix total du menu pour une commande, en appliquant la réduction si applicable
    public static function calculerPrixMenu($idMenu, $nbrePers)
    {
        $menu = MenuRepository::getById($idMenu);

        if ($menu === false) {
            return null; // le menu n'existe pas
        }

        $prixParPers = (float) $menu['prix_par_pers'];
        $nbreMinPers = (int) $menu['nombre_pers_min'];

        if ($nbrePers < $nbreMinPers) {
            return null; // règle métier non respectée
        }

        $totalSansReduction = $prixParPers * $nbrePers;

        if ($nbrePers - $nbreMinPers >= 5) {
            $reduction = $totalSansReduction * 0.1;
            $totalMenu = $totalSansReduction - $reduction;
        } else {
            $totalMenu = $totalSansReduction;
        }

        return round($totalMenu, 2);
    }
}