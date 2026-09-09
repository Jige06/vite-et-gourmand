SET NAMES utf8mb4;
-- Insertion des données dans la base de données

-- Table roles
INSERT INTO roles(libelle) VALUES('Utilisateur');
INSERT INTO roles(libelle) VALUES('Employé');
INSERT INTO roles(libelle) VALUES('Administrateur');

-- Table theme
INSERT INTO theme(libelle) VALUES('Festivités');
INSERT INTO theme(libelle) VALUES('Cérémonies et Réceptions');
INSERT INTO theme(libelle) VALUES('Affaires et Séminaires');

-- Table statut_commande
INSERT INTO statut_commande(libelle) VALUES('En attente de validation');
INSERT INTO statut_commande(libelle) VALUES('Accepté');
INSERT INTO statut_commande(libelle) VALUES('En préparation');
INSERT INTO statut_commande(libelle) VALUES('En cours de livraison');
INSERT INTO statut_commande(libelle) VALUES('Livré');
INSERT INTO statut_commande(libelle) VALUES('En attente du retour matériel');
INSERT INTO statut_commande(libelle) VALUES('Terminé');
INSERT INTO statut_commande(libelle) VALUES('Annulé');

-- Table allergene
INSERT INTO allergene(nom) VALUES('Gluten');
INSERT INTO allergene(nom) VALUES('Lait');
INSERT INTO allergene(nom) VALUES('Oeufs');
INSERT INTO allergene(nom) VALUES('Poissons');
INSERT INTO allergene(nom) VALUES('Mollusques');
INSERT INTO allergene(nom) VALUES('Crustacés');
INSERT INTO allergene(nom) VALUES('Fruits à coques');

-- Table horaire
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Lundi', '09:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Mardi', '09:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Mercredi', '09:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Jeudi', '09:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Vendredi', '09:00', '16:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Samedi', '09:00', '16:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Dimanche', '09:00', '12:00');

-- Table utilisateur
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Dupont', 'José', 'jose@viteetgourmand.fr', '$2y$10$Jro8DlwZmbBYYW1ovXXuUOl/WkSbtg88XhgGI.82diE5hFfo2ww0y', '0557841234', '19 rue Bouffard', '33000', 'Bordeaux', 1, 3);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Martin', 'Julie', 'julie@viteetgourmand.fr', '$2y$10$PepVpgMkyuibjOSOXNbwFeNif2k5s6Nmls6ko.Ku0ggXvdUF2bVnC', '0557841235', '5 rue des Fleurs', '33000', 'Bordeaux', 1, 2);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Durand', 'Pierre', 'pierre.durand@exemple.com', '$2y$10$to.i6KN5SxeOrlKEGRVuX.BcIt/x5YkEH76QHgimLJ0pGcJzSglT.', '0612345678', '15 rue Sainte Catherine', '33000', 'Bordeaux', 1, 1);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Hebert', 'Jean-Guy', 'jghebert06@exemple.com', '$2y$10$XT8hVUjtB7XpGXvgKahanOYM.EGqwQ0k2M4LvQgN2CdUHQMjShTZ6', '0612345678', '3 avenue du Marechal Juin', '33700', 'Mérignac', 1, 1);

-- Table plat
INSERT INTO plat(titre, type_plat, photo) VALUES('Velouté de châtaignes au foie gras', 'Entrée', 'veloute_chataignes_foiegras.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Asperges sauce mousseline', 'Entrée', 'asperges_sauce_mousseline.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Cassolette de Saint-Jacques au Noilly Prat', 'Entrée', 'cassolette_saintjacques.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Carpaccio de saumon à l\'aneth et baies roses', 'Entrée', 'carpaccio_saumon_baiesroses.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Buffet d\'entrées maraîchères', 'Entrée', 'buffet_entrees_maraicheres.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Tartare de thon rouge au citron vert', 'Entrée', 'tartare_thon_rouge_citronvert.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Pressé de légumes grillés et pesto basilic', 'Entrée', 'presse_legumes_grilles_basilic.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Épaule d\'agneau confite aux herbes', 'Plat', 'epaule_agneau_confite_herbes.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Filet de bœuf en croûte et son jus corsé', 'Plat', 'filet_boeuf_en_croute_juscorse.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Ballotine de volaille farcie aux morilles', 'Plat', 'ballotine_volaille_farcie_morille.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Cochon de lait rôti à la broche', 'Plat', 'cochon_lait_roti_broche.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Dos de cabillaud rôti, émulsion de crustacés', 'Plat', 'dos_cabillaud_roti.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Magret de canard, réduction au vin de Bordeaux', 'Plat', 'magret_canard_vin_bordeaux.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Entremet aux fruits de saison', 'Dessert', 'entremet_fruits_saisons.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Trio de gourmandises chocolatées', 'Dessert', 'trio_gourmandises_chocolatees.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Pièce montée traditionnelle', 'Dessert', 'piece_montee_traditionnelle.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Wedding cake', 'Dessert', 'weeding_cake.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Buffet de mignardises et macarons', 'Dessert', 'Buffet_mignardises_et_macarons.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Café gourmand revisité', 'Dessert', 'café_gourmand_revisite.png');
INSERT INTO plat(titre, type_plat, photo) VALUES('Cannelé bordelais façon profiterole', 'Dessert', 'cannele_bordelais_facon_profiterole.png');

-- Table menu
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Tradition de saison', 'Des saveurs authentiques qui célèbrent le meilleur de chaque saison.', 45.00, 10, 20, 'Commander au minimum 1 semaine avant la prestation.', 'Classique', 'menu_tradition_de_saison.png', 1);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Prestige Régional', 'Une escapade gastronomique au cœur des terroirs français.', 55.00, 10, 20, 'Commander au minimum 2 semaines avant la prestation.', 'Classique', 'menu_prestige_regional.png', 1);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Noces d\'Argent', 'Un repas d\'exception pour célébrer vos moments les plus précieux.', 65.00, 20, 35, 'Commander au minimum 1 mois avant la prestation.', 'Classique', 'menu_noces_argent.png', 2);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Héritage & Partage', 'La générosité à table, sublimée par notre savoir-faire artisanal.', 55.00, 20, 30, 'Commander au minimum 1 semaine avant la prestation.', 'Classique', 'menu_heritage_et_partage.png', 2);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('L\'Exécutif', 'Une cuisine raffinée pour vos rendez-vous professionnels les plus importants.', 60.00, 6, 12, 'Commander au minimum 48 heures avant la prestation.', 'Classique', 'menu_executif.png', 3);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Le Gourmet Rapide', 'L\'élégance gastronomique au service de vos déjeuners d\'affaires.', 30.00, 8, 15, 'Commander au minimum 24 heures avant la prestation.', 'Classique', 'menu_gourmet_rapide.png', 3);

-- Table menu_plat
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(1, 1);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(1, 2);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(1, 8);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(1, 14);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(2, 3);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(2, 9);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(2, 15);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(3, 4);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(3, 10);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(3, 16);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(3, 17);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(4, 5);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(4, 11);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(4, 18);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(5, 6);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(5, 12);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(5, 19);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(6, 7);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(6, 13);
INSERT INTO menu_plat(Id_menu, Id_plat) VALUES(6, 20);

-- Table plat_allergene
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(1, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(1, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(2, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(2, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(3, 5);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(4, 4);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(6, 4);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(9, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(9, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(10, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(12, 4);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(12, 7);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(14, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(14, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(15, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(15, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(15, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(16, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(16, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(16, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(17, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(17, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(17, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(18, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(18, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(18, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(18, 6);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(19, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(19, 3);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(20, 1);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(20, 2);
INSERT INTO plat_allergene(Id_plat, Id_allergene) VALUES(20, 3);

-- Table commande
-- Commandes de Pierre (Id 3)
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-04-01', 10, 450.00, 0, 'Enlèvement', '12:00:00', '2025-04-15', 0, 1, 3);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, adresse_livraison, code_postal_livraison, ville_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-04-10', 12, 726.00, 26.00, 'Livraison', '10 rue de la Paix', 33100, 'Bordeaux', '19:00:00', '2025-04-25', 1, 2, 3);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-05-01', 8, 240.00, 0, 'Enlèvement', '13:00:00', '2025-05-20', 0, 6, 3);

-- Commandes de Jean-Guy (Id 4)
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-03-15', 20, 1300.00, 0, 'Enlèvement', '12:00:00', '2025-04-01', 0, 3, 4);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, adresse_livraison, code_postal_livraison, ville_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-04-20', 25, 1540.00, 35.00, 'Livraison', '5 allée des Roses', 33700, 'Mérignac', '20:00:00', '2025-05-10', 1, 4, 4);

INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-02-10', 10, 450.00, 0, 'Enlèvement', '12:00:00', '2025-02-20', 0, 3, 3);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-02-15', 15, 825.00, 0, 'Enlèvement', '12:00:00', '2025-03-01', 0, 2, 4);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-01-10', 6, 180.00, 0, 'Enlèvement', '12:00:00', '2025-01-20', 0, 6, 3);
INSERT INTO commande(date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, Id_Utilisateur)
    VALUES('2025-01-20', 20, 1300.00, 0, 'Enlèvement', '12:00:00', '2025-02-05', 0, 3, 4);

-- Table commande_statut_commande
-- Commande 1 (Pierre) : Terminée
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(1, 1, '2025-04-01 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(1, 2, '2025-04-02 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(1, 3, '2025-04-10 14:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(1, 7, '2025-04-15 13:00:00');

-- Commande 2 (Pierre) : En attente retour matériel
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 1, '2025-04-10 11:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 2, '2025-04-11 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 3, '2025-04-20 14:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 4, '2025-04-24 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 5, '2025-04-25 19:30:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(2, 6, '2025-04-25 20:00:00');

-- Commande 3 (Pierre) : En attente de validation
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(3, 1, '2025-05-01 09:00:00');

-- Commande 4 (Jean-Guy) : Terminée
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(4, 1, '2025-03-15 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(4, 2, '2025-03-16 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(4, 3, '2025-03-25 14:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(4, 7, '2025-04-01 13:00:00');

-- Commande 5 (Jean-Guy) : Acceptée
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(5, 1, '2025-04-20 11:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(5, 2, '2025-04-21 10:00:00');

INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(6, 1, '2025-02-10 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(6, 2, '2025-02-11 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(6, 7, '2025-02-20 14:00:00');

INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(7, 1, '2025-02-15 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(7, 2, '2025-02-16 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(7, 7, '2025-03-01 14:00:00');

INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(8, 1, '2025-01-10 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(8, 2, '2025-01-11 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(8, 7, '2025-01-20 14:00:00');

INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(9, 1, '2025-01-20 10:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(9, 2, '2025-01-21 09:00:00');
INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES(9, 7, '2025-02-05 14:00:00');

-- Table des avis
INSERT INTO avis(note, description_avis, statut, Id_commande)
    VALUES(5, 'Excellent service, repas délicieux !', 'Validé', 1);
INSERT INTO avis(note, description_avis, statut, Id_commande, date_validation)
    VALUES(4, 'Très bon repas, livraison ponctuelle.', 'Validé', 4, '2025-04-02 10:00:00');
INSERT INTO avis(note, description_avis, statut, Id_commande)
    VALUES(4, 'Satisfait dans l\'ensemble.', 'En attente', 3);
INSERT INTO avis(note, description_avis, statut, Id_commande, date_validation)
    VALUES(5, 'Parfait pour notre anniversaire de mariage, tout était impeccable !', 'Validé', 6, '2025-02-21 10:00:00');
INSERT INTO avis(note, description_avis, statut, Id_commande, date_validation)
    VALUES(4, 'Très bonne prestation, équipe professionnelle et plats savoureux.', 'Validé', 7, '2025-03-02 10:00:00');
INSERT INTO avis(note, description_avis, statut, Id_commande, date_validation)
    VALUES(5, 'Service irréprochable, nous recommandons vivement !', 'Validé', 8, '2025-01-21 10:00:00');
INSERT INTO avis(note, description_avis, statut, Id_commande, date_validation)
    VALUES(4, 'Bon repas, nous avons apprécié le prêt de matériel.', 'Validé', 9, '2025-02-06 10:00:00');
INSERT INTO avis(note, description_avis, statut, Id_commande)
    VALUES(2, 'Déçu par la qualité des plats, pas à la hauteur du prix.', 'Refusé', 2);
INSERT INTO avis(note, description_avis, statut, Id_commande)
    VALUES(4, 'Belle expérience gastronomique, à recommander.', 'En attente', 5);