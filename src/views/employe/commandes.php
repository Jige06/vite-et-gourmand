<?php require_once('../src/views/layouts/header.php'); ?>

<div class="employe">
    <h1>Espace employé</h1>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- Filtres des menus par statut ou par nom/prenon -->
<div class="filters">
    <form method="GET" action="/employe">
        <input type="text" name="client" placeholder="Nom du client">
        <label for="statut-select">Choisissez un statut&nbsp;:</label>
        <select name="statut" id="statut-select">
            <option value=""></option>
            <option value="En attente de validation">En attente de validation</option>
            <option value="Accepté">Accepté</option>
            <option value="En préparation">En préparation</option>
            <option value="En cours de livraison">En cours de livraison</option>
            <option value="Livré">Livré</option>
            <option value="En attente de retour matériel">En attente de retour matériel</option>
            <option value="Terminé">Terminé</option>
            <option value="Annulé">Annulé</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>
</div>

<!-- Tableau des commandes -->
<div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">N° de commande</th>
                <th scope="col">Client</th>
                <th scope="col">Date</th>
                <th scope="col">Statut actuel</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= 'VG-' . date('Ymd', strtotime($order['date_commande'])) . '-' . sprintf('%04d', $order['Id_commande']) ?></td>
                    <td><?= htmlspecialchars($order['prenom'] . ' ' . $order['nom']) ?></td>
                    <td><?= htmlspecialchars($order['date_commande']) ?></td>
                    <td><?= htmlspecialchars($order['statut_actuel']) ?></td>
                    <td>
                        <form method="POST" action="/employe/statut">
                            <input type="hidden" name="Id_Commande" value="<?= $order['Id_commande'] ?>">
                            <label for="statut-select">Nouveau statut&nbsp;:</label>
                            <select name="nouveau_statut" id="nouveau_statut">
                                <option value=""></option>
                                <option value="Accepté">Accepté</option>
                                <option value="En préparation">En préparation</option>
                                <option value="En cours de livraison">En cours de livraison</option>
                                <option value="Livré">Livré</option>
                                <option value="En attente de retour matériel">En attente de retour matériel</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Annulé">Annulé</option>
                            </select>
                            <button type="submit">Valider</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>