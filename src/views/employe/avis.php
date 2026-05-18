<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h3>Validation des avis</h3>
</div>


<div class="row row-cols-1 row-cols-md-3 g-4 mb-5 mt-5 justify-content-center">
    <?php foreach ($avis as $unAvis): ?>
        <div class="col">
        <div class="card" style="width: 16rem;">
            <div class="card-body">
                <h5 class="card-title">Avis de la commande: <?= 'VG-' . date('Ymd', strtotime($unAvis['date_commande'])) . '-' . sprintf('%04d', $unAvis['Id_commande']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($unAvis['prenom'] . ' ' . $unAvis['nom']) ?></p>
                <p>Note: <?= htmlspecialchars($unAvis['note']) ?></p>
                <p><?= htmlspecialchars($unAvis['description_avis']) ?></p>
                <div class="d-flex gap-2 justify-content-center">
                    <form method="POST" action="/employe/avis">
                        <input type="hidden" name="id_avis" value="<?= $unAvis['Id_avis'] ?>">
                        <input type="hidden" name="statut" value="Validé">
                        <button type="submit" class="btn btn-success">Valider</button>
                    </form>
                    <form method="POST" action="/employe/avis">
                        <input type="hidden" name="id_avis" value="<?= $unAvis['Id_avis'] ?>">
                        <input type="hidden" name="statut" value="Refusé">
                        <button type="submit" class="btn btn-danger">Refuser</button>
                    </form>
                </div>
            </div>
        </div>
        </div>
    <?php endforeach; ?>
</div>



<?php require_once('../src/views/layouts/footer.php'); ?>