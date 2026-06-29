<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h2>Tableau des commandes</h2>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'];
                                    unset($_SESSION['error']); ?></div>
<?php endif; ?>

<!-- Filtres des menus par statut ou par nom/prenon -->
<div class="container filters mb-4 py-3">
    <form method="GET" action="/employe">
        <input class="mx-4" type="text" name="client" placeholder="Nom du client">
        <label class="ms-4" for="statut-select">choisissez un statut&nbsp;:</label>
        <select class="ms-1" name="statut" id="statut-select">
            <option value=""></option>
            <option value="En attente de validation">En attente de validation</option>
            <option value="Accepté">Accepté</option>
            <option value="En préparation">En préparation</option>
            <option value="En cours de livraison">En cours de livraison</option>
            <option value="Livré">Livré</option>
            <option value="En attente du retour matériel">En attente du retour matériel</option>
            <option value="Terminé">Terminé</option>
            <option value="Annulé">Annulé</option>
        </select>
        <button class="connect-button mx-5" type="submit">filtrer</button>
    </form>
</div>

<!-- Tableau des commandes -->
<div class="container mb-4 table-responsive">
    <table class="table table-hover table-borderless table-responsive-md">
        <thead>
            <tr>
                <th scope="col">N° de commande</th>
                <th scope="col">Client</th>
                <th scope="col">Date</th>
                <th scope="col">Montant total</th>
                <th scope="col">Statut actuel</th>
                <th scope="col">Statut à changer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= 'VG-' . date('Ymd', strtotime($order['date_commande'])) . '-' . sprintf('%04d', $order['Id_commande']) ?></td>
                    <td><?= htmlspecialchars($order['prenom'] . ' ' . $order['nom']) ?></td>
                    <td><?= htmlspecialchars($order['date_commande']) ?></td>
                    <td><?= htmlspecialchars($order['montant_total']) ?> €</td>
                    <td><?= htmlspecialchars($order['statut_actuel']) ?></td>
                    <td>
                        <form class="container" method="POST" action="/employe/statut">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="Id_Commande" value="<?= $order['Id_commande'] ?>">
                            <label for="statut-select">Nouveau statut&nbsp;:</label>
                            <select name="nouveau_statut" id="nouveau_statut">
                                <option value=""></option>
                                <option value="Accepté">Accepté</option>
                                <option value="En préparation">En préparation</option>
                                <option value="En cours de livraison">En cours de livraison</option>
                                <option value="Livré">Livré</option>
                                <option value="En attente du retour matériel">En attente du retour matériel</option>
                                <option value="Terminé">Terminé</option>
                                <option value="Annulé">Annulé</option>
                            </select>
                            <button class="connect-button ms-4" type="submit">valider</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>