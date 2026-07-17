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
    <p class="text-center">Veuillez saisir votre nouveau mot de passe.</p>
    <form id="form-change-password" class="d-flex flex-column align-items-center" action="/reset-password?token=<?= htmlspecialchars($token) ?>" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div id="error-mot-de-passe" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="password">Nouveau mot de passe</label>
            <input class="form-control" type="password" id="password" name="password" required>
            <button type="button" onclick="togglePassword('password')" aria-label="Afficher ou masquer le mot de passe">👁</button>
        </div>
        <div id="error-confirmation" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="confirm_password">Confirmer le mot de passe</label>
            <input class="form-control" type="password" id="confirm_password" name="confirm_password" required>
            <button type="button" onclick="togglePassword('confirm_password')" aria-label="Afficher ou masquer le mot de passe">👁</button>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">modifier mon mot de passe</button>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>