<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/menus/<?= htmlspecialchars($details['photo']) ?>" alt="<?= pathinfo($details['photo'], PATHINFO_FILENAME) ?>">
    <h1 class="text-center"><?= htmlspecialchars($details['theme_libelle']) ?></h1>
    <h2 class="text-center">Menu <?= htmlspecialchars($details['titre']) ?></h2>
    <h3 class=" description text-center"><em><?= htmlspecialchars($details['description_menu']) ?></em></h3>
</div>


<div class="details-container mt-4 mb-4 pb-4">
    <button onclick="window.location.href='/menus'" class="big-title-button mb-3 mt-3" type="button">retour aux menus</button>

    <div class="row align-items-strech">
        <div id="carouselExampleFade" class="carousel slide carousel-fade col-12 col-lg-6 mb-3 mb-lg-0" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                <?php $i = 0; ?>
                <?php foreach ($plats as $plat): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <img src="/assets/images/plats/<?= htmlspecialchars($plat['photo']) ?>" class="d-block w-100" alt="<?= pathinfo($plat['photo'], PATHINFO_FILENAME) ?>">
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="list-details col-12 col-lg-6 pt-2 h-100">
            <?php foreach ($plats as $plat): ?>
                <p class="type-plat"><span class="style-details"><?= htmlspecialchars($plat['type_plat']) ?></span></p>
                <p class="nom-plat"><?= htmlspecialchars($plat['titre']) ?> </p><?php if (!empty($plat['allergenes'])): ?><span class="liste-allergene">(allergènes: <?php foreach ($plat['allergenes'] as $allergene): ?><?= htmlspecialchars($allergene['nom']) ?> <?php endforeach; ?>)</span><?php endif; ?>
            <?php endforeach; ?>
            <p class="tarif"><span class="style-details">Tarif:</span> <?= $details['prix_par_pers'] ?> € / pers<br><span class="style-details">Commande min:</span> <?= $details['nombre_pers_min'] ?> pers</p>
            <p><span class="style-details">Stock disponible:</span> <?= htmlspecialchars($details['quantite_restante']) ?></p>

        </div>
        <div class="alert alert-warning mt-3 mb-5">
            <strong>⚠️</strong>
            <?= htmlspecialchars($details['conditions']) ?>
        </div>
    </div>



    <div class="button-commande text-center">
        <?php if (isset($_SESSION['id_user'])): ?>
            <button onclick="window.location.href='/commande?id_menu=<?= $details['Id_menu'] ?>'" class="big-title-button mb-3 mt-3" type="button">commandez ce menu</button>
        <?php else: ?>
            <button onclick="window.location.href='/connexion'" class="big-title-button mb-3 mt-3" type="button">commandez ce menu</button>
        <?php endif; ?>
    </div>

</div>


<?php require_once('../src/views/layouts/footer.php'); ?>