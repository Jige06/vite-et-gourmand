<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="">
    <h1 class="text-center">Connexion</h1>
</div>

<div class="box-connexion container-fluid">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form class="d-flex flex-column align-items-center" action="/connexion" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required placeholder="exemple@exemple.com"
                value="<?= isset($_SESSION['prefill_email']) ? htmlspecialchars($_SESSION['prefill_email']) : '';
                        unset($_SESSION['prefill_email']); ?>">
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="motdepasse">Mot de passe</label>
            <div class="password password-input">
                <input class="form-control" type="password" id="motdepasse" name="password" required placeholder="Votre mot de passe">
                <button type="button" onclick="togglePassword('motdepasse')" aria-label="Afficher ou masquer le mot de passe">👁</button>
                <div class="text-end">
                    <a class="forgot-password" href="/mot-de-passe-oublie">Mot de passe oublié</a>
                </div>
            </div>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">se connecter</button>
        <div class=" mt-1">
            <p>Pas de compte ? <a href="/inscription">Créer un compte, cliquez ici</a></p>
        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>