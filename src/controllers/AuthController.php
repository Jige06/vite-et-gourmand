<?php

class AuthController
{
    public function showlogin()
    {
        require_once(__DIR__ . '/../views/auth/login.php');
    }

    public function login()
    {
        // on récupère les données du formulaire
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim($_POST['password']);

        // on vérifie que les champs ne soient pas vides
        if ((!empty($email)) && (!empty($password))) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/connexion');
            }
            // on cherche l'utilisateur dans la bdd
            $user = UserModel::findByEmail($email);

            if ($user === null) {
                $_SESSION['error'] = "Il n'existe pas d'utilisateur avec cet email.";
                Auth::redirect('/connexion');
                return;
            } else if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['id_user'] = $user['Id_Utilisateur'];
                $_SESSION['role'] = $user['Id_role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];

                switch ($_SESSION['role']) {
                    // Jointure pour récupérer le libellé du rôle
                    case 'Administrateur':
                        Auth::redirect('/admin');
                        break;
                    case 'Employé':
                        Auth::redirect('/employe');
                        break;
                    default:
                        Auth::redirect('/');
                        break;
                }
            } else {
                $_SESSION['error'] = "Le mot de passe n'est pas valide.";
                Auth::redirect('/connexion');
            }
        }
    }

    public function showSignUp()
    {
        require_once(__DIR__ . '/../views/auth/signup.php');
    }

    public function signUp()
    {
        // on récupère les données du formulaire
        $nom = trim(htmlspecialchars($_POST['nom']));
        $prenom = trim(htmlspecialchars($_POST['prenom']));
        $email = trim(htmlspecialchars($_POST['email']));
        $telephone = trim(htmlspecialchars($_POST['telephone']));
        $adresse = trim(htmlspecialchars($_POST['adresse']));
        $codePostal = trim(htmlspecialchars($_POST['codePostal']));
        $ville = trim(htmlspecialchars($_POST['ville']));
        $password = trim($_POST['password']);

        // on vérifie que les champs ne soient pas vides
        if ((!empty($nom)) && (!empty($prenom)) && (!empty($email)) && (!empty($telephone)) &&
            (!empty($adresse)) && (!empty($codePostal)) && (!empty($ville)) && (!empty($password))
        ) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/inscription');
            }
            if (!preg_match('/^[0-9]{10}$/', $telephone)) {
                $_SESSION['error'] = "Le numéro de téléphone doit contenir 10 chiffres.";
                Auth::redirect('/inscription');
            }
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $password)) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                Auth::redirect('/inscription');
            }

            // on cherche l'utilisateur dans la bdd
            $user = UserModel::findByEmail($email);

            if ($user !== null) {
                $_SESSION['error'] = "Un compte existe déjà avec cet email";
                $_SESSION['prefill_email'] = $email;
                Auth::redirect('/connexion');
                return;
            }
            $hash = password_hash($password, PASSWORD_BCRYPT);
            UserModel::createUser($nom, $prenom, $email, $hash, $telephone, $adresse, $codePostal, $ville, 1);
            $newUser = UserModel::findByEmail($email);

            $_SESSION['id_user'] = $newUser['Id_Utilisateur'];
            $_SESSION['role'] = $newUser['Id_role'];
            $_SESSION['nom'] = $newUser['nom'];
            $_SESSION['prenom'] = $newUser['prenom'];

            UserModel::sendWelcomeMail($nom, $prenom, $email);
            Auth::redirect('/');
        } else {
            $_SESSION['error'] = "Tous les champs doivent être remplis";
            Auth::redirect('/inscription');
        }
    }

    public function showResetPassword()
    {
        require_once(__DIR__ . '/../views/auth/reset.php');
    }

    public function logout()
    {
        session_unset();

        session_destroy();

        Auth::redirect('/');
    }
}
