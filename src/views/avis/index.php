<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h3 class="text-center">Julie et José vous souhaitent la bienvenue chez</h3>
    <h2 class="text-center">Vite & Gourmand</h2>
    <button onclick="window.location.href='/menus'" class="big-title-button mb-3 mt-3" type="submit">Découvrir nos menus</button>
</div>
<div class="presentation container-fluid text-center mb-4 mt-4 pt-4 pb-4">

    <div class="titre-realisation pb-4 pt-4">
        <h3>les avis</h3>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5 mt-5 justify-content-center">
        <?php foreach ($allValidatedReviews as $allValidatedReview): ?>
            <div class="col">
                <div class="card">
                    <img src="/assets/images/menus/<?= htmlspecialchars($allValidatedReview['photo']) ?>" class="card-img-top" alt="<?= pathinfo($allValidatedReview['photo'], PATHINFO_FILENAME) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($allValidatedReview['titre']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($allValidatedReview['description_avis']) ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Note: <?= htmlspecialchars($allValidatedReview['note']) ?></li>
                        <li class="list-group-item"><?= htmlspecialchars($allValidatedReview['prenom']) ?></li>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="avis-button text-center">
        <button onclick="window.location.href='/menus'" class="big-title-button mb-3 mt-3" type="submit">Envie de commander ?</button>
    </div>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>