<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h2>Validation des avis</h2>
</div>


<div class="row row-cols-1 row-cols-md-3 g-4 mb-5 mt-5 justify-content-center">
    <?php foreach ($avis as $unAvis): ?>
        <div class="col">
        <div class="card w-100" >
            <div class="card-body">
                <h3 class="card-title">Avis de la commande: <?= 'VG-' . date('Ymd', strtotime($unAvis['date_commande'])) . '-' . sprintf('%04d', $unAvis['Id_commande']) ?></h3>
                <p class="card-text"><?= htmlspecialchars($unAvis['prenom'] . ' ' . $unAvis['nom']) ?></p>
                <p>Note: <?= htmlspecialchars($unAvis['note']) ?></p>
                <p><?= htmlspecialchars($unAvis['description_avis']) ?></p>
                <div class="d-flex gap-2 justify-content-center">
                    <form method="POST" action="/employe/avis">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="id_avis" value="<?= $unAvis['Id_avis'] ?>">
                        <input type="hidden" name="statut" value="Validé">
                        <button type="submit" class="btn btn-success">valider</button>
                    </form>
                    <form method="POST" action="/employe/avis">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="id_avis" value="<?= $unAvis['Id_avis'] ?>">
                        <input type="hidden" name="statut" value="Refusé">
                        <button type="submit" class="btn btn-danger">refuser</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
</div>



<?php require_once('../src/views/layouts/footer.php'); ?>