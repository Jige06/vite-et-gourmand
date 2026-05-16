<?php

use PHPMailer\PHPMailer\PHPMailer;

class OrderModel
{
    // Méthode de création d'une commande
    public static function createOrder($dateCommande, $nbrePers, $montantTotal, $prixLivraison, $typeLiv, $adresseLiv, $codePostalLiv, $villeLive, $heureLiv, $dateLiv, $pretMat, $idMenu, $idUser)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO commande (date_commande, nbre_pers, montant_total, prix_livraison, type_livraison, adresse_livraison, code_postal_livraison, ville_livraison, heure_livraison, date_livraison, pret_materiel, Id_menu, id_Utilisateur)
        VALUES (:date_commande, :nbre_pers, :montant_total, :prix_livraison, :type_livraison, :adresse_livraison, :code_postal_livraison, :ville_livraison, :heure_livraison, :date_livraison, :pret_materiel, :Id_menu, :id_Utilisateur)");
        $stmt->bindValue(':date_commande', $dateCommande);
        $stmt->bindValue(':nbre_pers', $nbrePers);
        $stmt->bindValue(':montant_total', $montantTotal);
        $stmt->bindValue(':prix_livraison', $prixLivraison);
        $stmt->bindValue(':type_livraison', $typeLiv);
        $stmt->bindValue(':adresse_livraison', $adresseLiv);
        $stmt->bindValue(':code_postal_livraison', $codePostalLiv);
        $stmt->bindValue(':ville_livraison', $villeLive);
        $stmt->bindValue(':heure_livraison', $heureLiv);
        $stmt->bindValue(':date_livraison', $dateLiv);
        $stmt->bindValue(':pret_materiel', $pretMat);
        $stmt->bindValue(':Id_menu', $idMenu);
        $stmt->bindValue(':id_Utilisateur', $idUser);

        $stmt->execute();
        $idCommande = $pdo->lastInsertId();
        $stmt2 = $pdo->prepare("INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES (?, 1, NOW())");
        $stmt2->execute([$idCommande]);
        return $idCommande;
    }

    // Méthode qui envoie le mail de confirmation de commande
    public static function sendConfirmationMail($nom, $prenom, $email, $idCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLive, $heureLiv, $dateLiv, $idMenu)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];
        $menu = MenuModel::getById($idMenu);

        $mail->setFrom($_ENV['MAIL_FROM'], 'Vite & Gourmand');
        $mail->addAddress($email, $nom . ' ' . $prenom);

        $mail->Subject = 'Confirmation de commande - Vite & Gourmand';
        $mail->isHTML(true);
        $adresseLivraison = '';
        if ($typeLiv === 'Livraison') {
            $adresseLivraison = "
            <p>- Adresse de livraison: $adresseLiv, $codePostalLiv $villeLive</p>";
        }
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Montserrat, sans-serif; color: #0f172a; }
                .header { background-color: #0f172a; padding: 20px; text-align: center; border-radius: 8px; }
                .header h1 { color: #e67e22; font-family: 'Playfair Display', serif; }
                .content { padding: 30px; }
                .recap { background-color: #1e293b; color: white; padding: 20px; border-radius: 8px; }
                .total { color: #e67e22; font-weight: bold; font-size: 1.2rem; }
            </style>
        </head>
        <body>
            <div class='header'>
            <h1>Vite & Gourmand</h1>
            </div>
            <div class='content'>
            <p>Bonjour $prenom $nom,</p>
            <p>Julie et José sont ravis de confirmer votre commande n°<strong>$idCommande</strong>.</p>
            <br>
            </div>
            <div class='recap'>
            <h2>Récapitulatif:</h2>
            <br>
            <p>- Menu choisi: {$menu['titre']}</p>
            <p>- Nombre de personnes: $nbrePers</p>
            <p>- Type de livraison: $typeLiv</p>
            <p>- Date de livraison: $dateLiv à $heureLiv</p>
            $adresseLivraison
            <p>- Frais de livraison: $prixLiv €</p>
            <p class='total'>- Montant total de la commande: $montantTotal €</p>
            <br>
            <br>
            <p>À bientôt,</p>
            <p>Vite et Gourmand</p>
            </div>
        </body>
        </html>";

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
        }
    }

    // Méthode qui récupère toutes les commandes d'un utilisateur
    public static function getOrdersByUser($idUser)
    {
        $pdo = DatabaseConnection::getInstance();

        // Requête avec sous requête qui s'execute pour chaque ligne de la requête principale
        // Premet d'obtenir le statut le plus recent grace au ORDER BY DESC et LIMIT 1
        $stmt = $pdo->prepare("SELECT commande.*, menu.titre AS menu_titre,
            (SELECT statut_commande.libelle 
                FROM commande_statut_commande 
                JOIN statut_commande ON commande_statut_commande.Id_statut_commande = statut_commande.Id_statut_commande
                WHERE commande_statut_commande.Id_commande = commande.Id_commande
                ORDER BY date_changement DESC 
                LIMIT 1) AS statut_actuel,
                (SELECT COUNT(*) 
        FROM avis 
        WHERE avis.Id_commande = commande.Id_commande) AS avis_depose
        FROM commande
        JOIN menu ON commande.Id_menu = menu.Id_menu
        WHERE commande.Id_Utilisateur = ?");
        $stmt->execute([$idUser]);
        $commande = $stmt->fetchAll();
        return $commande;
    }

    public static function cancelOrder($idCommande)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement) VALUES (:Id_commande, 8, NOW())");
        $stmt->bindValue(':Id_commande', $idCommande);

        $stmt->execute();
    }

    public static function updateOrder($idCommande, $nbrePers, $typeLiv, $adresseLiv, $codePostalLiv, $villeLiv, $heureLiv, $dateLiv, $pretMat)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("UPDATE commande
        SET nbre_pers = :nbre_pers, type_livraison = :type_livraison, adresse_livraison = :adresse_livraison,
        code_postal_livraison = :code_postal_livraison, ville_livraison = :ville_livraison, heure_livraison = :heure_livraison, date_livraison = :date_livraison, pret_materiel = :pret_materiel
        WHERE Id_commande = :Id_commande");

        $stmt->bindValue(':Id_commande', $idCommande);
        $stmt->bindValue(':nbre_pers', $nbrePers);
        $stmt->bindValue(':type_livraison', $typeLiv);
        $stmt->bindValue(':adresse_livraison', $adresseLiv);
        $stmt->bindValue(':code_postal_livraison', $codePostalLiv);
        $stmt->bindValue(':ville_livraison', $villeLiv);
        $stmt->bindValue(':heure_livraison', $heureLiv);
        $stmt->bindValue(':date_livraison', $dateLiv);
        $stmt->bindValue(':pret_materiel', $pretMat);

        $stmt->execute();
    }

    public static function getStatusByOrder($idCommande)
    {
        $pdo = DatabaseConnection::getInstance();

        // Requête 
        $stmt = $pdo->prepare("SELECT commande_statut_commande.*, statut_commande.libelle AS statut_libelle
        FROM commande_statut_commande
        JOIN statut_commande ON statut_commande.Id_statut_commande = commande_statut_commande.Id_statut_commande
        WHERE commande_statut_commande.Id_commande = ? ORDER BY date_changement ASC");
        $stmt->execute([$idCommande]);
        $statutCommande = $stmt->fetchAll();
        return $statutCommande;
    }
}
