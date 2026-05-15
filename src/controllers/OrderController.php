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
        $menus = MenuModel::getAllMenu();
        // Récupération des infos de l'utilisateur
        $user = UserModel::findByEmail($_SESSION['email']);
        // Récupération de l'id du menu choisi
        $idMenu = isset($_GET['id_menu']) ? $_GET['id_menu'] : null;
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
            $nbrePers = trim(htmlspecialchars($_POST['nbre_pers']));
            $montantTotal = floatval($_POST['montant_total']);
            $prixLiv = floatval($_POST['prix_livraison']);
            $typeLiv = trim(htmlspecialchars($_POST['type_liv']));
            $adresseLiv = isset($_POST['adresse_liv']) ? trim(htmlspecialchars($_POST['adresse_liv'])) : null;
            $codePostalLiv = isset($_POST['codePostal_liv']) ? trim(htmlspecialchars($_POST['codePostal_liv'])) : null;
            $villeLive = isset($_POST['ville_liv']) ? trim(htmlspecialchars($_POST['ville_liv'])) : null;
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

            // traiter la commande
            $idCommande = OrderModel::createOrder($dateCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLive, $heureLiv, $dateLiv, $pretMat, $idMenu, $idUser);

            // Envoi du mail de confirmation de la commande
            OrderModel::sendConfirmationMail($nom, $prenom, $email, $idCommande, $dateCommande, $nbrePers, $montantTotal, $prixLiv, $typeLiv, $adresseLiv, $codePostalLiv, $villeLive, $heureLiv, $dateLiv, $pretMat, $idMenu);

            $_SESSION['success'] = "Votre commande a bien été enregistrée ! Vous recevrez un mail de confirmation.";
            Auth::redirect('/menus');



            // Sinon on affiche le formulaire
        } else {
            $this->showOrder();
        }
    }
}
