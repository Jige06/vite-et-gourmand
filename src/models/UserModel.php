<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserModel
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

    // Méthode qui génère un mot de passe temporaire pour le reset password
    public static function generateTempPassword()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $tempPassword = '';
        for ($i = 0; $i < 10; $i++) {
            $tempPassword .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $tempPassword;
    }

    // Méthode qui met à jour la bdd avec le mot de passe temporaire (hashé) 
    public static function updateTempPassword($email, $tempPassword)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // On crypte le mot de passe temporaire
        $hash = password_hash($tempPassword, PASSWORD_BCRYPT);

        // Requête préparée qui met à jour la bdd
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = :hash WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash', $hash);

        $stmt->execute();
    }

    // Méthode qui change la valeur du parametre "MustChangePassword"
    public static function updateMustChangePassword($email, $value = 1)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();
        // Requête préparée
        $stmt = $pdo->prepare("UPDATE utilisateur SET must_change_password = :value WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':value', $value);

        $stmt->execute();
    }

    // Méthode qui envoie le mail avec le mot de passe temporaire via PHPMailer
    public static function sendResetMail($nom, $prenom, $email, $tempPassword)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['MAIL_PORT'];
        $mail->Username = $_ENV['MAIL_USER'];
        $mail->Password = $_ENV['MAIL_PASS'];

        $mail->setFrom($_ENV['MAIL_FROM'], 'Vite & Gourmand');
        $mail->addAddress($email, $nom . ' ' . $prenom);

        $mail->Subject = 'Mot de passe temporaire';
        $mail->Body = "Bonjour $prenom $nom, voici votre mot de passe temporaire: $tempPassword . Vous devrez le modifier lors de votre connexion.";

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
            <p>Votre compte employé a bien été créé.</p>
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
}
