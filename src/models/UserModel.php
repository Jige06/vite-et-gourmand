<?php

class UserModel
{
    public static function findByEmail($email)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();

        // Requête préparée
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

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

    public static function sendWelcomeMail() {}

    public static function generateTempPassword()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $tempPassword = '';
        for ($i = 0; $i < 10; $i++) {
            $tempPassword .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $tempPassword;
    }

    public static function updateTempPassword($email, $tempPassword)
    {
        // Connexion à la BDD
        $pdo = DatabaseConnection::getInstance();
        // On crypte le mot de passe temporaire
        $hash = password_hash($tempPassword, PASSWORD_BCRYPT);
        // Requête préparée
        $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = :hash WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash', $hash);

        $stmt->execute();
    }

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

    public static function sendResetMail() {}
}
