<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="">
    <h1 class="text-center">Changer mon mot de passe</h1>
</div>
<div class="box-connexion container-fluid">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message'];
                                        unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <form class="d-flex flex-column align-items-center" action="/mot-de-passe-oublie" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required placeholder="exemple@exemple.com">
        </div>

        <button class="connect-button mb-3 mt-3" type="submit">recevoir mon mot de passe temporaire</button>
        <div class=" mt-1">
            <p>Vous vous rappelez de votre mot de passe ! <a href="/connexion">Se connecter</a></p>
        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>