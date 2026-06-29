<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h1 class="text-center">Vite & Gourmand</h1>
    <button onclick="window.location.href='/commande'" class="big-title-button mb-3 mt-3" type="submit">passer une commande</button>
</div>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
<?php endif; ?>
<div class="menus container-fluid text-center mb-4 mt-4 pt-4 pb-4">
    <div class="titre-h2-bleu  pb-4 pt-4">
        <h2>nos menus</h2>
    </div>

    <!-- Les filtres -->
    <div class="filters container mt-4 mb-4 pt-4 pb-4">
        <div class="row justify-content-center g-3">
            <div class="col-12 col-md-auto">
                <label for="theme-select">Thème</label>
                <select class="form-select" name="theme" id="theme-select">
                    <option value="">Choissisez un thème</option>
                    <?php foreach ($themes as $theme): ?>
                        <option value="<?= $theme['Id_theme'] ?>"><?= htmlspecialchars($theme['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 col-md-auto">
                <label for="regime-select">Régime</label>
                <select class="form-select" name="regime" id="regime-select">
                    <option value="">Choissisez un régime</option>
                    <?php foreach ($regimes as $regime): ?>
                        <option value="<?= htmlspecialchars($regime['regime']) ?>"><?= htmlspecialchars($regime['regime']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row justify-content-center g-3 mt-2">
            <div class="col-12 col-md-auto">
                <label for="prix-min">Prix minimum / pers</label>
                <input class="form-control" type="number" name="prix-min" id="prix-min" min="<?= $minPrix ?>" max="<?= $maxPrix ?>">
            </div>
            <div class="col-12 col-md-auto">

                <label for="prix-max">Prix maximum / pers</label>
                <input class="form-control" type="number" name="prix-max" id="prix-max" min="<?= $minPrix ?>" max="<?= $maxPrix ?>">
            </div>
            <div class="col-12 col-md-auto">

                <label for="nbre-pers">Nombre de personnes</label>
                <input class="form-control" type="number" name="nbre-pers" id="nbre-pers" min="<?= $minPersonnes ?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-auto text-center">
                <button class="connect-button" id="reset-filters">réinitialiser les filtres</button>
            </div>
        </div>
    </div>
</div>

<!-- Les cartes menus -->
<div class="list-menus text-center mt-4 mb-4 px-4 pt-4 pb-4">
    <div class="row g-3 justify-content-center" id="menu-cards">
        <?php foreach ($menus as $menu): ?>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="details-menu h-100 pt-2 pb-2 px-3">
                    <div class="carte-menu">
                        <img class="card-img-menu" src="/assets/images/menus/<?= htmlspecialchars($menu['photo']) ?>" alt="photo du menu <?= htmlspecialchars($menu['titre']) ?>">
                        <p><?= htmlspecialchars($menu['theme_libelle']) ?></p>
                        <h3><?= htmlspecialchars($menu['titre']) ?></h3>
                        <p><?= htmlspecialchars($menu['description_menu']) ?></p>
                        <p><?= $menu['prix_par_pers'] ?> €/pers — min <?= $menu['nombre_pers_min'] ?> pers</p>
                        <button class="detail-button" onclick="window.location.href='/menus/detail?id=<?= $menu['Id_menu'] ?>'">voir le détail</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>