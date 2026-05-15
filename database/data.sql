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
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Lundi', '9:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Mardi', '9:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Mercredi', '9:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Jeudi', '9:00', '19:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Vendredi', '9:00', '16:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Samedi', '9:00', '16:00');
INSERT INTO horaire(jour, heure_ouverture, heure_fermeture) VALUES('Dimanche', '9:00', '12:00');

-- Table utilisateur
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Dupont', 'José', 'jose@viteetgourmand.fr', 'Admin1234!', '0557841234', '19 rue Bouffard', '33000', 'Bordeaux', 1, 3);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Martin', 'Julie', 'julie@viteetgourmand.fr', 'Employe1234!', '0557841235', '5 rue des Fleurs', '33000', 'Bordeaux', 1, 2);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Durand', 'Pierre', 'pierre.durand@exemple.com', 'User1234!', '0612345678', '15 rue Sainte Catherine', '33000', 'Bordeaux', 1, 1);
INSERT INTO utilisateur(nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
    VALUES('Hebert', 'Jean-Guy', 'jghebert06@exemple.com', 'User1234!', '0612345678', '3 avenue du Marechal Juin', '33700', 'Mérignac', 1, 1);

-- Table plat
INSERT INTO plat(titre, type_plat) VALUES('Velouté de châtaignes au foie gras', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Asperges sauce mousseline', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Cassolette de Saint-Jacques au Noilly Prat', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Carpaccio de saumon à l\'aneth et baies roses', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Buffet d\'entrées maraîchères', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Tartare de thon rouge au citron vert', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Pressé de légumes grillés et pesto basilic', 'Entrée');
INSERT INTO plat(titre, type_plat) VALUES('Épaule d\'agneau confite aux herbes', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Filet de bœuf en croûte et son jus corsé', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Ballotine de volaille farcie aux morilles', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Cochon de lait rôti à la broche', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Dos de cabillaud rôti, émulsion de crustacés', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Magret de canard, réduction au vin de Bordeaux', 'Plat');
INSERT INTO plat(titre, type_plat) VALUES('Entremet aux fruits de saison', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Trio de gourmandises chocolatées', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Pièce montée traditionnelle', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Wedding cake', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Buffet de mignardises et macarons', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Café gourmand revisité', 'Dessert');
INSERT INTO plat(titre, type_plat) VALUES('Cannelé bordelais façon profiterole', 'Dessert');

-- Table menu
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Tradition de saison', 'Des saveurs authentiques qui célèbrent le meilleur de chaque saison.', 45.00, 10, 20, 'Commander au minimum 1 semaine avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 1);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Prestige Régional', 'Une escapade gastronomique au cœur des terroirs français.', 55.00, 10, 20, 'Commander au minimum 2 semaines avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 1);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Noces d\'Argent', 'Un repas d\'exception pour célébrer vos moments les plus précieux.', 65.00, 20, 35, 'Commander au minimum 1 mois avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 2);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Héritage & Partage', 'La générosité à table, sublimée par notre savoir-faire artisanal.', 55.00, 20, 30, 'Commander au minimum 1 semaine avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 2);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('L\'Exécutif', 'Une cuisine raffinée pour vos rendez-vous professionnels les plus importants.', 60.00, 6, 12, 'Commander au minimum 48 heures avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 3);
INSERT INTO menu(titre, description_menu, prix_par_pers, nombre_pers_min, quantite_restante, conditions, regime, photo, Id_theme)
    VALUES('Le Gourmet Rapide', 'L\'élégance gastronomique au service de vos déjeuners d\'affaires.', 30.00, 8, 15, 'Commander au minimum 24 heures avant la prestation.', 'Classique', 'uploads/menus/default.jpg', 3);

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