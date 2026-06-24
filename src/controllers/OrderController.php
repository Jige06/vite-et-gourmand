<?php

class OrderController
{
    /**
     * Affiche la vue du formulaire de commande
     * Récupère l'ensemble des menus
     * Récupère les informations de l'utilisateur
     * Récupère l'id du menu du menu choisi
     */
    public function showOrder()
    {
        // Récupération de la liste des menus
        $menus = MenuRepository::getAllMenu();
        // Récupération des infos de l'utilisateur
        $user = UserRepository::findByEmail($_SESSION['email']);
        // Récupération de l'id du menu choisi
        $idMenu = filter_input(INPUT_GET, 'id_menu', FILTER_VALIDATE_INT) ?: null;
        // Affichage de la vue order
        require_once(__DIR__ . '/../views/commande/order.php');
    }

    /**
     * Point d'entrée de la page commande.
     * Vérifie que l'utilisateur est connecté, puis
     * affiche le formulaire (GET) ou traite la commande (POST).
     */
    public function handleOrder()
    {
        // Si l'utilisateur n'est pas connecté, on le redirige vers la connexion
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        // Si le formulaire est soumis, on traite la commande
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $dateCommande = date('Y-m-d');
            $nbrePers = intval($_POST['nbre_pers']);
            $typeLiv = trim(htmlspecialchars($_POST['type_liv']));
            $adresseLiv = isset($_POST['adresse_liv']) ? trim(htmlspecialchars($_POST['adresse_liv'])) : null;
            $codePostalLiv = isset($_POST['codePostal_liv']) ? trim(htmlspecialchars($_POST['codePostal_liv'])) : null;
            $villeLiv = isset($_POST['ville_liv']) ? trim(htmlspecialchars($_POST['ville_liv'])) : null;
            $heureLiv = trim(htmlspecialchars($_POST['heure_liv']));
            $dateLiv = trim(htmlspecialchars($_POST['date_liv']));
            $pretMat = isset($_POST['pret_materiel']) ? 1 : 0;
            $idMenu = intval($_POST['menu']);
            $idUser = $_SESSION['id_user'];
            $nom = $_SESSION['nom'];
            $prenom = $_SESSION['prenom'];
            $email = $_SESSION['email'];

            // Vérification code postal (5 chiffres)
            if ($codePostalLiv && !preg_match('/^[0-9]{5}$/', $codePostalLiv)) {
                $_SESSION['error'] = "Le code postal n'est pas valide.";
                Auth::redirect('/commande');
                return;
            }

            // Étape 1 : recalcul du prix du menu côté serveur (jamais confiance au client)
            $montantTotal = CommandeService::calculerPrixMenu($idMenu, $nbrePers);
            if ($montantTotal === null) {
                $_SESSION['error'] = "Ce menu n'existe pas, ou le nombre de personnes est insuffisant.";
                Auth::redirect('/commande');
                return;
            }

            // Étape 2 : calcul des frais de livraison côté serveur, si livraison hors Bordeaux
            $prixLiv = 0;
            if ($typeLiv === 'Livraison') {
                $adresseComplete = $adresseLiv . ', ' . $codePostalLiv . ' ' . $villeLiv;
                $resultatLivraison = LivraisonService::calculerFraisLivraison($adresseComplete);

                if ($resultatLivraison === null) {
                    $_SESSION['error'] = "Impossible de calculer les frais de livraison. Vérifiez votre adresse.";
                    Auth::redirect('/commande');
                    return;
                }
                $prixLiv = $resultatLivraison['prix'];
            }

            $montantTotal += $prixLiv;

            // traiter la commande
            $idCommande = OrderRepository::createOrder($dateCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLiv, $heureLiv, $dateLiv, $pretMat, $idMenu, $idUser);

            // Envoi du mail de confirmation de la commande
            OrderRepository::sendConfirmationMail($nom, $prenom, $email, $idCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLiv, $heureLiv, $dateLiv, $idMenu);

            $_SESSION['success'] = "Votre commande a bien été enregistrée ! Vous recevrez un mail de confirmation.";
            Auth::redirect('/menus');

            // Sinon on affiche le formulaire
        } else {
            $this->showOrder();
        }
    }

    public function showUserOrders()
    {
        $idUser = $_SESSION['id_user'];
        $user = UserRepository::findByEmail($_SESSION['email']);
        $commandes = OrderRepository::getOrdersByUser($idUser);
        foreach ($commandes as &$commande) {
            $commande['historique'] = OrderRepository::getStatusByOrder($commande['Id_commande']);
        }
        unset($commande);

        require_once(__DIR__ . '/../views/user/commandes.php');
    }

    // Méthode qui permet d'annuler une commande lorsque son statut le permet
    public function deleteOrder()
    {
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        $idCommande = intval($_POST['id_commande']);

        // Étape 1 : la commande existe-t-elle vraiment ?
        $commande = OrderRepository::getOrderById($idCommande);
        if ($commande === false) {
            $_SESSION['error'] = "Cette commande n'existe pas.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        // Étape 2 : la commande appartient-elle bien à l'utilisateur connecté ?
        if ($commande['Id_Utilisateur'] != $_SESSION['id_user']) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à annuler cette commande.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        // Étape 3 : le statut permet-il l'annulation ?
        if ($commande['statut_actuel'] !== 'En attente de validation') {
            $_SESSION['error'] = "Cette commande ne peut plus être annulée.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        OrderRepository::cancelOrder($idCommande);
        $_SESSION['success'] = "Votre commande a bien été annulée !";
        Auth::redirect('/mon-espace/commandes');
    }

    // Méthode qui permet de modifier une commande lorsque son statut le permet
    public function updateOrder()
    {
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }

        // Si le formulaire est soumis, on traite la commande
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCommande = intval($_POST['id_commande']);
            $nbrePers = trim(htmlspecialchars($_POST['nbre_pers']));
            $typeLiv = trim(htmlspecialchars($_POST['type_liv']));
            $adresseLiv = isset($_POST['adresse_liv']) ? trim(htmlspecialchars($_POST['adresse_liv'])) : null;
            $codePostalLiv = isset($_POST['codePostal_liv']) ? trim(htmlspecialchars($_POST['codePostal_liv'])) : null;
            $villeLiv = isset($_POST['ville_liv']) ? trim(htmlspecialchars($_POST['ville_liv'])) : null;
            $heureLiv = trim(htmlspecialchars($_POST['heure_liv']));
            $dateLiv = trim(htmlspecialchars($_POST['date_liv']));
            $pretMat = isset($_POST['pret_materiel']) ? 1 : 0;

            // Étape 1 : la commande existe-t-elle vraiment ?
            $commande = OrderRepository::getOrderById($idCommande);
            if ($commande === false) {
                $_SESSION['error'] = "Cette commande n'existe pas.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            // Étape 2 : la commande appartient-elle bien à l'utilisateur connecté ?
            if ($commande['Id_Utilisateur'] != $_SESSION['id_user']) {
                $_SESSION['error'] = "Vous n'êtes pas autorisé à modifier cette commande.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            // Étape 3 : le statut permet-il la modification ?
            if ($commande['statut_actuel'] !== 'En attente de validation') {
                $_SESSION['error'] = "Cette commande ne peut plus être modifiée.";
                Auth::redirect('/mon-espace/commandes');
                return;
            }

            OrderRepository::updateOrder($idCommande, $nbrePers, $typeLiv, $adresseLiv, $codePostalLiv, $villeLiv, $heureLiv, $dateLiv, $pretMat);
            $_SESSION['success'] = "Votre commande a été mis à jour !";
            Auth::redirect('/mon-espace/commandes');
        } else {
            Auth::redirect('/mon-espace/commandes');
        }
    }

    // Méthode qui permet de déposer un avis sur une commande
    public function leaveReview()
    {
        if (!isset($_SESSION['id_user'])) {
            Auth::redirect('/connexion');
            return;
        }
        $idCommande = intval($_POST['id_commande']);

        // Étape 1 : la commande existe-t-elle vraiment ?
        $commande = OrderRepository::getOrderById($idCommande);
        if ($commande === false) {
            $_SESSION['error'] = "Cette commande n'existe pas.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        // Étape 2 : la commande appartient-elle bien à l'utilisateur connecté ?
        if ($commande['Id_Utilisateur'] != $_SESSION['id_user']) {
            $_SESSION['error'] = "Vous n'êtes pas autorisé à laisser un avis sur cette commande.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        // Étape 3 : le statut permet-il de déposer un avis ?
        if ($commande['statut_actuel'] !== 'Terminé') {
            $_SESSION['error'] = "Le statut de cette commande ne permet pas de déposer un avis.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }

        $note = intval($_POST['note']);
        if ($note < 1 || $note > 5) {
            $_SESSION['error'] = "La note doit être comprise entre 1 et 5.";
            Auth::redirect('/mon-espace/commandes');
            return;
        }
        $descriptionAvis = trim(htmlspecialchars($_POST['commentaire']));
        ReviewRepository::createReview($note, $descriptionAvis, $idCommande);
        $_SESSION['success'] = "Votre avis a bien été déposé. Il sera visible dès sa validation par notre équipe !";
        Auth::redirect('/mon-espace/commandes');
    }

    // Méthode appelée en fetch JS pour obtenir un aperçu des frais de livraison
    public function calculerFrais()
    {
        if (!isset($_SESSION['id_user'])) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['erreur' => 'Non autorisé']);
            return;
        }

        $adresseLiv = filter_input(INPUT_GET, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $codePostalLiv = filter_input(INPUT_GET, 'codePostal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $villeLiv = filter_input(INPUT_GET, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($adresseLiv) || empty($codePostalLiv) || empty($villeLiv)) {
            header('Content-Type: application/json');
            echo json_encode(['erreur' => 'Adresse incomplète']);
            return;
        }

        $adresseComplete = $adresseLiv . ', ' . $codePostalLiv . ' ' . $villeLiv;
        $resultat = LivraisonService::calculerFraisLivraison($adresseComplete);

        header('Content-Type: application/json');

        if ($resultat === null) {
            echo json_encode(['erreur' => 'Adresse introuvable']);
            return;
        }

        echo json_encode($resultat);
    }
}
