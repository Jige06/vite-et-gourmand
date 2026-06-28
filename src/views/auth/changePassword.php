<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h1 class="text-center">Changer mon mot de passe</h1>
</div>

<div class="box-connexion container-fluid">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <p class="text-center text-warning">Vous utilisez un mot de passe temporaire. Veuillez le modifier avant de continuer.</p>
    <form class="d-flex flex-column align-items-center" action="/changer-mot-de-passe" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="password">Nouveau mot de passe</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="confirm_password">Confirmer le mot de passe</label>
            <input class="form-control" type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">modifier mon mot de passe</button>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>