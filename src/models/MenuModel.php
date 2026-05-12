<?php

class MenuModel
{
    public static function createMenu($titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO menu (titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
        VALUES (:titre, :description_menu, :prix_par_pers, :nombre_pers_min, :quantite_restante, :conditions, :regime, :photo, :Id_theme)");
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

    public static function updateMenu($idMenu, $titre, $descriptionMenu, $prixParPers, $nbrePersMin, $quantiteRestante, $conditions, $regime, $photo, $idTheme)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("UPDATE menu
        SET titre = :titre, description_menu = :description_menu, prix_par_pers = :prix_par_pers, nombre_pers_min = :nombre_pers_min, quantite_restante = :quantite_restante, conditions = :conditions, regime = :regime, photo = :photo, Id_theme = :Id_theme
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

    public static function deleteMenu($idMenu)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("DELETE FROM menu where Id_menu = ?");
        $stmt->execute([$idMenu]);
    }

    public static function getAllMenu()
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getById($id)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme
        WHERE menu.Id_menu = ?");

        $stmt->execute([$id]);
        $menu =  $stmt->fetch();
        return $menu ?: null;
    }

    public static function getByFilters($filters)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $sql = "SELECT menu.*, theme.libelle AS theme_libelle
        FROM menu
        JOIN theme ON menu.Id_theme = theme.Id_theme
        WHERE 1=1";

        $params = [];

        if (!empty($filters['prix_min']) && !empty($filters['prix_max'])) {
            $sql .= " AND menu.prix_par_pers BETWEEN ? AND ?";
            $params[] = $filters['prix_min'];
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
}
