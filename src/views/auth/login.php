<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/public/assets/images/Buffet_Big_title.png" alt="buffet">
    <h2 class="text-center">Connexion</h2>
</div>

<div class="box-connexion container-fluid">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form class="d-flex flex-column align-items-center" action="/connexion" method="post">
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required placeholder="exemple@exemple.com"
                value="<?= isset($_SESSION['prefill_email']) ? htmlspecialchars($_SESSION['prefill_email']) : '';
                        unset($_SESSION['prefill_email']); ?>">
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="motdepasse">Mot de passe</label>
            <div class="password">
                <input class="form-control" type="password" id="motdepasse" name="password" required placeholder="Votre mot de passe">
                <div class="text-end">
                    <a class="forgot-password" href="#">Mot de passe oublié</a>
                </div>
            </div>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">Se connecter</button>
        <div class=" mt-1">
            <p>Pas de compte ? <a href="/inscription">Créer un compte, cliquez ici</a></p>
        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>