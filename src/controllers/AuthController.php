<?php

class AuthController
{
    //Méthode qui affiche la vue de connexion
    public function showLogin()
    {
        require_once(__DIR__ . '/../views/auth/login.php');
    }

    // Méthode qui permet de se connecter avec gestion des roles
    public function login()
    {
        // on récupère les données du formulaire et on les nettoie
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim($_POST['password']);

        // on vérifie que les champs ne soient pas vides
        if ((!empty($email)) && (!empty($password))) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/connexion');
            }
            // on cherche l'utilisateur dans la bdd
            $user = UserRepository::findByEmail($email);

            if ($user === null) {
                $_SESSION['error'] = "Il n'existe pas d'utilisateur avec cet email.";
                Auth::redirect('/connexion');
                return;
            }
            if ($user['actif'] == 0) {
                $_SESSION['error'] = "Votre compte a été désactivé.";
                Auth::redirect('/connexion');
                return;
            }
            if (password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['id_user'] = $user['Id_Utilisateur'];
                $_SESSION['role'] = $user['role_libelle'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['email'] = $user['email'];

                // Vérification si l'utilisateur doit changer son mot de passe
                if ($user['must_change_password'] == 1) {
                    Auth::redirect('/changer-mot-de-passe');
                    return;
                }

                switch ($_SESSION['role']) {
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

    // Méthode qui gére la connexion
    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->login();
        } else {
            $this->showLogin();
        }
    }

    // Méthode qui affiche le vue pour s'inscrire
    public function showSignUp()
    {
        require_once(__DIR__ . '/../views/auth/signup.php');
    }

    // Méthode qui permet de se créer un compte (s'inscrire)
    public function signUp()
    {
        // on récupère les données du formulaire d'inscription
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

            // Vérification que les champs ne contiennent que des lettres
            if (
                !preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $nom) ||
                !preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $prenom) ||
                !preg_match('/^[a-zA-ZÀ-ÿ\- ]+$/', $ville)
            ) {
                $_SESSION['error'] = "Le nom, prénom et ville ne doivent contenir que des lettres.";
                Auth::redirect('/inscription');
            }

            // Vérification du format de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/inscription');
            }
            // Vérification que le code postal ne contient que 5 chiffres
            if (!preg_match('/^[0-9]{5}$/', $codePostal)) {
                $_SESSION['error'] = "Le code postal doit contenir 5 chiffres.";
                Auth::redirect('/inscription');
            }
            // Vérification que le téléphone ne contient que 10 chiffres
            if (!preg_match('/^[0-9]{10}$/', $telephone)) {
                $_SESSION['error'] = "Le numéro de téléphone doit contenir 10 chiffres.";
                Auth::redirect('/inscription');
            }
            // Vérification que le mot de passe a le bon format (sécurité)
            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $password)) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                Auth::redirect('/inscription');
            }
            // Vérification que le mot de passe est indique à la 1ere saisi
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                Auth::redirect('/inscription');
            }

            // on cherche l'utilisateur dans la bdd
            $user = UserRepository::findByEmail($email);

            if ($user !== null) {
                $_SESSION['error'] = "Un compte existe déjà avec cet email";
                $_SESSION['prefill_email'] = $email;
                Auth::redirect('/connexion');
                return;
            }
            $hash = password_hash($password, PASSWORD_BCRYPT);
            UserRepository::createUser($nom, $prenom, $email, $hash, $telephone, $adresse, $codePostal, $ville, 1);
            $newUser = UserRepository::findByEmail($email);

            $_SESSION['id_user'] = $newUser['Id_Utilisateur'];
            $_SESSION['role'] = $newUser['Id_role'];
            $_SESSION['nom'] = $newUser['nom'];
            $_SESSION['prenom'] = $newUser['prenom'];

            UserRepository::sendWelcomeMail($nom, $prenom, $email);
            $_SESSION['success'] = "Votre compte a été créé avec succés !";
            Auth::redirect('/');
        } else {
            $_SESSION['error'] = "Tous les champs doivent être remplis";
            Auth::redirect('/inscription');
        }
    }

    // Méthode qui gére l'inscription
    public function handleSignUp()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->signUp();
        } else {
            $this->showSignUp();
        }
    }

    // Méthode qui affiche la vue de reinitialisation du mot de passe
    public function showResetPassword()
    {
        require_once(__DIR__ . '/../views/auth/reset.php');
    }

    // Méthode qui permet de reinitialiser le mot de passe
    public function resetPassword()
    {
        // On récupére l'email saisi dans le formaulaire
        $email = trim(htmlspecialchars($_POST['email']));

        if (!empty($email)) {
            // On vérifie que c'est bien au format email
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $user = UserRepository::findByEmail($email);
                if ($user !== null) {

                    // Génération d'un mot de passe temporaire
                    $tempPassword = UserRepository::generateTempPassword();
                    // enregistrement du temppassword en bdd;
                    UserRepository::updateTempPassword($email, $tempPassword);
                    UserRepository::updateMustChangePassword($email, 1);
                    // envoi du mail avec le mot de passe temporaire
                    UserRepository::sendResetMail($user['nom'], $user['prenom'], $email, $tempPassword);
                }
                $_SESSION['message'] = "Si un compte existe avec cet email, vous recevrez un mot de passe temporaire. Vous devrez le modifier lors de votre prochaine connexion";
                Auth::redirect('/connexion');
            } else {
                $_SESSION['error'] = "L'adresse email n'est pas valide.";
                Auth::redirect('/reset');
            }
        } else {
            $_SESSION['message'] = "Veuillez saisir votre email.";
            Auth::redirect('/reset');
        }
    }

    // Méthode qui gère la réinitialisation du mot de passe
    public function handleResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->resetPassword();
        } else {
            $this->showResetPassword();
        }
    }

    // Méthode qui gère la demande de modification de password apres reset
    public function handleChangePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password']);
            $confirm = trim($_POST['confirm_password']);

            if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/', $password)) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                Auth::redirect('/changer-mot-de-passe');
                return;
            }
            if ($password !== $confirm) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                Auth::redirect('/changer-mot-de-passe');
                return;
            }

            $hash = password_hash($password, PASSWORD_BCRYPT);
            UserRepository::updatePassword($_SESSION['email'], $hash);
            UserRepository::updateMustChangePassword($_SESSION['email'], 0);

            $_SESSION['success'] = "Votre mot de passe a été modifié avec succès !";

            switch ($_SESSION['role']) {
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
            require_once(__DIR__ . '/../views/auth/changePassword.php');
        }
    }

    // Méthode qui permet de se déconnecter
    public function logout()
    {
        session_unset();

        session_destroy();

        Auth::redirect('/');
    }
}
