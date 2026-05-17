<?php

class EmployeModel
{
    // Methode qui filtre la recherche des commandes (client et/ou statut)
    public static function getAllOrders($filters)
    {
        $pdo = DatabaseConnection::getInstance();

        $sql = "SELECT commande.*, utilisateur.nom, utilisateur.prenom,
        (SELECT statut_commande.libelle
        FROM commande_statut_commande
        JOIN statut_commande ON commande_statut_commande.Id_Statut_commande = statut_commande.ID_statut_commande
        WHERE commande_statut_commande.Id_commande = commande.Id_commande
        ORDER BY date_changement DESC
        LIMIT 1) AS statut_actuel
        FROM commande
        JOIN utilisateur ON commande.Id_Utilisateur = utilisateur.Id_Utilisateur
        WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['client'])) {
            $sql .= " AND (utilisateur.nom LIKE ? OR utilisateur.prenom LIKE ?)";
            $params[] = '%' . $filters['client'] . '%';
            $params[] = '%' . $filters['client'] . '%';
        }

        if (!empty($filters['statut'])) {
            $sql .= " HAVING statut_actuel = ?";
            $params[] = $filters['statut'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $orders = $stmt->fetchAll();
        return $orders;
    }

    public static function updateStatus($idCommande, $nouveauStatut)
    {
        $pdo = DatabaseConnection::getInstance();

        // Récupération de l'id du statut à partir de son libellé
        $stmt = $pdo->prepare("SELECT Id_statut_commande FROM statut_commande WHERE libelle = ?");
        $stmt->execute([$nouveauStatut]);
        $statut = $stmt->fetch();

        // Vérification si ce statut a déjà été attribué à cette commande
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM commande_statut_commande 
        WHERE Id_commande = ? AND Id_statut_commande = ?");
        $stmt->execute([$idCommande, $statut['Id_statut_commande']]);
        // fetchColumn récupère uniquement la 1ere colonne de la 1ere ligne -> le count
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        // Insertion du nouveau statut en bdd 
        $stmt = $pdo->prepare("INSERT INTO commande_statut_commande (Id_commande, Id_statut_commande, date_changement)
        VALUES (:Id_commande, :statut_commande, NOW())");
        $stmt->bindValue(':Id_commande', $idCommande);
        $stmt->bindValue(':statut_commande', $statut['Id_statut_commande']);

        $stmt->execute();
        return true;
    }
}
