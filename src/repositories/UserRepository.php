<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserRepository
{
    // Méthode qui retourne les utilisateurs en cherchant par leur email
    public static function findByEmail($email)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée avec jointure sur la table roles pour récupérer aussi le libellé du role
        $stmt = $pdo->prepare("SELECT utilisateur.*, roles.libelle as role_libelle 
        FROM utilisateur 
        JOIN roles ON utilisateur.Id_role = roles.Id_role 
        WHERE utilisateur.email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Méthode qui cré (insert) en BDD un nouvel utilisateur qui s'inscrit
    public static function createUser($nom, $prenom, $email, $hash, $telephone, $adresse, $codePostal, $ville, $idRole = 1)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, Id_role)
        VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :adresse, :code_postal, :ville, :Id_role)");
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':mot_de_passe', $hash);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':adresse', $adresse);
        $stmt->bindValue(':code_postal', $codePostal);
        $stmt->bindValue(':ville', $ville);
        $stmt->bindValue(':Id_role', $idRole);

        $stmt->execute();
    }

    // Méthode qui envoie un mail de bienvenue lors d'une nouvelle inscription d'un utilisateur
    public static function sendWelcomeMail($nom, $prenom, $email)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM'], 'Vite & Gourmand');
        $mail->addAddress($email, $nom . ' ' . $prenom);

        $mail->Subject = 'Bienvenue chez Vite & Gourmand';
        $mail->Body = "Bonjour $prenom $nom, Julie et José sont ravis de vous compter parmi leurs clients !";

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
        }
    }

    // Méthode qui met à jour le mot de passe d'un utilisateur
    public static function updatePassword($email, $hash)
    {
        $pdo = DatabaseConnection::getInstance();
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = :hash WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash', $hash);
        $stmt->execute();
    }

    // Méthode qui envoie le mail avec le lien de reinitialisation via PHPMailer
    public static function sendResetMail($nom, $prenom, $email, $token)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->CharSet = 'UTF-8';
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM'], 'Vite & Gourmand');
        $mail->addAddress($email, $nom . ' ' . $prenom);

        $mail->Subject = 'Lien de réinitialisation Vite et Gourmand';
        $mail->isHTML(true);

        $lien = $_ENV['APP_URL'] . '/reset-password?token=' . $token;

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
            <p>Vous avez demandé la réinitialisation de votre mot de passe Vite et Gourmand</p>
            <p>Veuillez cliquer sur le lien suivant:.</p>
            <a href='$lien'>Réinitialiser mon mot de passe</a>
            <p>Ce lien est valable 1 heure.</p>
            <br>
            <p>À bientôt,</p>
            <p>Vite & Gourmand</p>
            </div>
        </body>
        </html>";

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
        }
    }

    // Méthode qui met à jour le profil d'un utilisateur après vérification que le nouveau email ne soit pas déja en bdd
    public static function updateProfil($idUser, $nom, $prenom, $email, $telephone, $adresse, $codePostal, $ville)
    {
        $pdo = DatabaseConnection::getInstance();

        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $stmt = $pdo->prepare("SELECT Id_Utilisateur FROM utilisateur WHERE email = ? AND Id_Utilisateur != ?");
        $stmt->execute([$email, $idUser]);
        if ($stmt->fetch()) {
            return false;
        }

        $stmt = $pdo->prepare("UPDATE utilisateur 
        SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone,
        adresse = :adresse, code_postal = :code_postal, ville = :ville
        WHERE Id_Utilisateur = :id_user");
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':adresse', $adresse);
        $stmt->bindValue(':code_postal', $codePostal);
        $stmt->bindValue(':ville', $ville);
        $stmt->bindValue(':id_user', $idUser);
        $stmt->execute();
        return true;
    }

    // Méthode qui met a jour le statut actif/désativé d'un compte employé
    public static function deactivateUser($idUser)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare("UPDATE utilisateur SET actif = 0 WHERE Id_Utilisateur = ?");
        $stmt->execute([$idUser]);
    }

    // Méthode qui cré un nouvel utilisateur (Role employé) en vérifiant si l'email n'est pas déja present dans la BDD
    public static function createEmploye($nom, $prenom, $email, $password)
    {
        $pdo = DatabaseConnection::getInstance();

        // Vérifier si l'email est déjà utilisé par un autre utilisateur
        $stmt = $pdo->prepare("SELECT Id_Utilisateur FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, adresse, code_postal, ville, actif, Id_role)
        VALUES (:nom, :prenom, :email, :mot_de_passe, '0557841234', '19 rue Bouffard', '33000', 'Bordeaux', 1, 2)");
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':mot_de_passe', $hash);

        $stmt->execute();
        return true;
    }

    // Méthode qui envoie le mail à l'employé (nouveau compte employé)
    public static function sendNewEmployeMail($nom, $prenom, $email)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM'], 'Vite & Gourmand');
        $mail->addAddress($email, $nom . ' ' . $prenom);

        $mail->Subject = 'Confirmation de la création de votre espace employé';
        $mail->isHTML(true);
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
            <p>Votre compte employé a bien été créé avec comme identifiant $email .</p>
            <p>Pour obtenir votre mot de passe, veuillez vous rapprocher de l'administrateur.</p>
            <br>
            <p>À bientôt,</p>
            <p>José</p>
            </div>
        </body>
        </html>";

        try {
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
        }
    }

    // Méthode qui sauvegarde le token et sa date d'expiration
    public static function saveResetToken($email, $token, $expiry)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare('UPDATE utilisateur
        SET reset_token = :reset_token, reset_token_expiry = :reset_token_expiry
        WHERE email = :email');
        $stmt->bindvalue(':reset_token', $token);
        $stmt->bindvalue(':reset_token_expiry', $expiry);
        $stmt->bindvalue(':email', $email);
        $stmt->execute();
    }

    // Méthode qui retrouve un utilisateur par son token
    public static function findResetToken($token)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare('SELECT * FROM utilisateur
        WHERE reset_token = ? AND reset_token_expiry > NOW()');
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    // Méthode qui efface le token après son utilisation
    public static function clearResetToken($email)
    {
        $pdo = DatabaseConnection::getInstance();

        $stmt = $pdo->prepare('UPDATE utilisateur
        SET reset_token = NULL, reset_token_expiry = NULL
        WHERE email = ?');
        $stmt->execute([$email]);
    }
}
