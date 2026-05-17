-- Base de données de l'application Vite et Gourmand

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS vite_et_gourmand;
USE vite_et_gourmand;

-- Création de la table des rôles utilisateur
CREATE TABLE roles(
   Id_role INT AUTO_INCREMENT,
   libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(Id_role)
);

-- Création de la table des différents plats
CREATE TABLE plat(
   Id_plat INT AUTO_INCREMENT,
   titre VARCHAR(255) NOT NULL,
   type_plat VARCHAR(255) NOT NULL,
   photo VARCHAR(255),
   PRIMARY KEY(Id_plat)
);

-- Création de la table des allergenes
CREATE TABLE allergene(
   Id_allergene INT AUTO_INCREMENT,
   nom VARCHAR(255) NOT NULL,
   PRIMARY KEY(Id_allergene)
);

-- Création de la table des statuts de commande
CREATE TABLE statut_commande(
   Id_statut_commande INT AUTO_INCREMENT,
   libelle VARCHAR(50) NOT NULL,
   PRIMARY KEY(Id_statut_commande)
);

-- Création de la table des horaires
CREATE TABLE horaire(
   Id_horaire INT AUTO_INCREMENT,
   jour VARCHAR(50) NOT NULL,
   heure_ouverture VARCHAR(50) NOT NULL,
   heure_fermeture VARCHAR(50) NOT NULL,
   PRIMARY KEY(Id_horaire)
);

-- Création de la table des thèmes des menus
CREATE TABLE theme(
   Id_theme INT AUTO_INCREMENT,
   libelle VARCHAR(255) NOT NULL,
   PRIMARY KEY(Id_theme)
);

-- Création de la table des utilisateurs
CREATE TABLE utilisateur(
   Id_Utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(255) NOT NULL,
   prenom VARCHAR(255) NOT NULL,
   email VARCHAR(255) NOT NULL,
   mot_de_passe VARCHAR(255) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   adresse VARCHAR(255) NOT NULL,
   code_postal VARCHAR(50) NOT NULL,
   ville VARCHAR(255) NOT NULL,
   actif BOOLEAN NOT NULL DEFAULT 1,
   Id_role INT NOT NULL,
   -- Colonne ajoutée en cours de developpement
   must_change_password BOOLEAN NOT NULL DEFAULT 0,
   PRIMARY KEY(Id_Utilisateur),
   UNIQUE(email),
   FOREIGN KEY(Id_role) REFERENCES roles(Id_role)
);

-- Création de la table des menus
CREATE TABLE menu(
   Id_menu INT AUTO_INCREMENT,
   titre VARCHAR(255)  NOT NULL,
   description_menu TEXT NOT NULL,
   prix_par_pers DECIMAL(15,2) NOT NULL,
   nombre_pers_min INT NOT NULL,
   quantite_restante INT,
   conditions TEXT NOT NULL,
   regime VARCHAR(50) NOT NULL,
   photo VARCHAR(255) NOT NULL,
   Id_theme INT NOT NULL,
   PRIMARY KEY(Id_menu),
   FOREIGN KEY(Id_theme) REFERENCES theme(Id_theme)
);

-- Création de la table des commandes
CREATE TABLE commande(
   Id_commande INT AUTO_INCREMENT,
   date_commande DATE NOT NULL,
   nbre_pers INT NOT NULL,
   nbre_pers_vegetarien INT,
   montant_total DECIMAL(15,2) NOT NULL,
   prix_livraison DECIMAL(15,2),
   type_livraison VARCHAR(50) NOT NULL,
   adresse_livraison VARCHAR(255),
   code_postal_livraison INT,
   ville_livraison VARCHAR(255) ,
   heure_livraison TIME NOT NULL,
   date_livraison DATE NOT NULL,
   pret_materiel BOOLEAN DEFAULT 0,
   restitution_materiel BOOLEAN DEFAULT 0,
   Id_menu INT NOT NULL,
   Id_Utilisateur INT NOT NULL,
   PRIMARY KEY(Id_commande),
   FOREIGN KEY(Id_menu) REFERENCES menu(Id_menu),
   FOREIGN KEY(Id_Utilisateur) REFERENCES utilisateur(Id_Utilisateur)
);

-- Création de la table des avis clients
CREATE TABLE avis(
   Id_avis INT AUTO_INCREMENT,
   note INT NOT NULL,
   description_avis VARCHAR(255) NOT NULL,
   statut VARCHAR(255) NOT NULL,
   Id_commande INT NOT NULL,
   -- Colonne ajoutée en cours de developpement
   date_validation DATETIME,
   PRIMARY KEY(Id_avis),
   UNIQUE(Id_commande),
   FOREIGN KEY(Id_commande) REFERENCES commande(Id_commande)
);

-- Création de la table associative entre menu et plat
CREATE TABLE menu_plat(
   Id_menu INT,
   Id_plat INT,
   PRIMARY KEY(Id_menu, Id_plat),
   FOREIGN KEY(Id_menu) REFERENCES menu(Id_menu),
   FOREIGN KEY(Id_plat) REFERENCES plat(Id_plat)
);

-- Création de la table associative entre plat et allergene
CREATE TABLE plat_allergene(
   Id_plat INT,
   Id_allergene INT,
   PRIMARY KEY(Id_plat, Id_allergene),
   FOREIGN KEY(Id_plat) REFERENCES plat(Id_plat),
   FOREIGN KEY(Id_allergene) REFERENCES allergene(Id_allergene)
);

-- Création de la table associative commande_statut_commande
CREATE TABLE commande_statut_commande(
   Id_commande INT,
   Id_statut_commande INT,
   date_changement DATETIME NOT NULL,
   PRIMARY KEY(Id_commande, Id_statut_commande),
   FOREIGN KEY(Id_commande) REFERENCES commande(Id_commande),
   FOREIGN KEY(Id_statut_commande) REFERENCES statut_commande(Id_statut_commande)
);
