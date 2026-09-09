<?php

class MenuRepository
{

    // Méthode qui permet de créer un nouveau menu
    public static function createMenu($titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO menu (titre, description_menu, prix_par_pers,
        nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
        VALUES (:titre, :description_menu, :prix_par_pers,
        :nombre_pers_min, :quantite_restante, :conditions, :regime, :photo, :Id_theme)");
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':description_menu', $descriptionMenu);
        $stmt->bindValue(':prix_par_pers', $prixParPers);
        $stmt->bindValue(':nombre_pers_min', $nbrePersMin);
        $stmt->bindValue(':quantite_restante', $quantiteRestante);
        $stmt->bindValue(':conditions', $conditions);
        $stmt->bindValue(':regime', $regime);
        $stmt->bindValue(':photo', $photo);
        $stmt->bindValue(':Id_theme', $idTheme);

        $stmt->execute();
        $idMenu = $pdo->lastInsertId();
        return $idMenu;
    }

    // Méthode qui permet de modifier un menu existant
    public static function updateMenu($idMenu, $titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("UPDATE menu
        SET titre = :titre, description_menu = :description_menu, prix_par_pers = :prix_par_pers,
        nombre_pers_min = :nombre_pers_min, quantite_restante = :quantite_restante,
        conditions = :conditions, regime = :regime, photo = :photo, Id_theme = :Id_theme
        WHERE Id_menu = :idMenu");
        $stmt->bindValue(':idMenu', $idMenu);
        $stmt->bindValue(':titre', $titre);
        $stmt->bindValue(':description_menu', $descriptionMenu);
        $stmt->bindValue(':prix_par_pers', $prixParPers);
        $stmt->bindValue(':nombre_pers_min', $nbrePersMin);
        $stmt->bindValue(':quantite_restante', $quantiteRestante);
        $stmt->bindValue(':conditions', $conditions);
        $stmt->bindValue(':regime', $regime);
        $stmt->bindValue(':photo', $photo);
        $stmt->bindValue(':Id_theme', $idTheme);

        $stmt->execute();
    }

    // Méthode qui permet de supprimer un menu
    public static function deleteMenu($idMenu)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("DELETE FROM menu WHERE Id_menu = ?");
        $stmt->execute([$idMenu]);
    }

    // Méthode qui permet de récupérer tous les menus
    public static function getAllMenu()
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée qui récupère tous les menus en joignant leur theme respectif
        $stmt = $pdo->prepare("SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Méthode qui permet de récupérer un menu par son Id
    public static function getById($id)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée que récupère un menu par son Id_menu en joignant son theme respectif 
        $stmt = $pdo->prepare("SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme
        WHERE menu.Id_menu = ?");

        // On exécute la requete
        $stmt->execute([$id]);
        // On recupere un tableau associatif
        $menu =  $stmt->fetch();
        return $menu ?: null;
    }

    // Méthode qui permet de récupérer les menus en fonction des filtres
    public static function getByFilters($filters)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée pour récupérer les menus  en fonction des filtres et en joignant leur theme respectif
        $sql = "SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme
        WHERE 1=1";

        $params = [];

        if (!empty($filters['prix_min'])) {
            $sql .= " AND menu.prix_par_pers >= ?";
            $params[] = $filters['prix_min'];
        }
        if (!empty($filters['prix_max'])) {
            $sql .= " AND menu.prix_par_pers <= ?";
            $params[] = $filters['prix_max'];
        }
        if (!empty($filters['theme'])) {
            $sql .= " AND menu.Id_theme = ?";
            $params[] = $filters['theme'];
        }
        if (!empty($filters['regime'])) {
            $sql .= " AND menu.regime = ?";
            $params[] = $filters['regime'];
        }
        if (!empty($filters['nb_personnes'])) {
            $sql .= " AND menu.nombre_pers_min <= ?";
            $params[] = $filters['nb_personnes'];
        }
        $stmt = $pdo->prepare($sql);

        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Méthodes qui permet de récupérer tous les thèmes
    public static function getAllThemes()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT * FROM theme");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Méthode qui permet de récupérer tous les régimes
    public static function getAllRegimes()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT DISTINCT regime FROM menu");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Méthode qui permet de récupérer le nombre min de personne des menus
    public static function getMinPersonnes()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT MIN(nombre_pers_min) as min_pers FROM menu");
        $stmt->execute();
        return $stmt->fetch()['min_pers'];
    }

    // Méthode qui eprmet de récuperer le prix min des menus
    public static function getMinPrix()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT MIN(prix_par_pers) as min_prix FROM menu");
        $stmt->execute();
        return $stmt->fetch()['min_prix'];
    }

    // Méthode qui eprmet de récuperer le prix max des menus
    public static function getMaxPrix()
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT MAX(prix_par_pers) as max_prix FROM menu");
        $stmt->execute();
        return $stmt->fetch()['max_prix'];
    }

    // Méthode qui récupère les différents plats d'un menu
    public static function getPlatsByMenu($idMenu)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT plat.* FROM plat JOIN menu_plat
        ON plat.Id_plat = menu_plat.Id_plat WHERE menu_plat.Id_menu = ?");
        $stmt->execute([$idMenu]);
        return $stmt->fetchAll();
    }

    // Méthode qui récupère les différents allergènes d'un plat
    public static function getAllergenesByPlat($idPlat)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("SELECT allergene.* FROM allergene JOIN plat_allergene
        ON allergene.Id_allergene = plat_allergene.Id_allergene
        WHERE plat_allergene.Id_plat = ?");
        $stmt->execute([$idPlat]);
        return $stmt->fetchAll();
    }

    // Méthode qui  insère les associations dans menu_plat
    public static function associerPlats($idMenu, $idPlats)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("INSERT INTO menu_plat (Id_menu, Id_plat) VALUES (:Id_menu, :Id_plat)");
        foreach ($idPlats as $idPlat) {
            $stmt->bindValue(':Id_menu', $idMenu);
            $stmt->bindValue(':Id_plat', $idPlat);
            $stmt->execute();
        }
    }

    // Méthode qui supprime les associations avant modification/suppression
    public static function supprimerPlats($idMenu)
    {

        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("DELETE FROM menu_plat WHERE Id_menu = ?");
        $stmt->execute([$idMenu]);
    }
}
