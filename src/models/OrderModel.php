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
        return $pdo->lastInsertId();
    }

    // Méthode qui envoie le mail de confirmation de commande
    public static function sendConfirmationMail($nom, $prenom, $email, $idCommande, $dateCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLive, $heureLiv, $dateLiv, $pretMat, $idMenu)
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
}
