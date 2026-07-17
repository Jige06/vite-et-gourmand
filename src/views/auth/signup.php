<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="">
    <h1 class="text-center">Inscription</h1>
</div>
<div class="box-connexion container-fluid">
<?php require_once('../src/views/layouts/messages.php'); ?>
    <form id="form-inscription" class="d-flex flex-column align-items-center" action="/inscription" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div id="error-nom" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="nom">Nom</label>
            <input class="form-control" type="text" id="nom" name="nom" required placeholder="ex: Martin">
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="prenom">Prénom</label>
            <div class="password">
                <input class="form-control" type="text" id="prenom" name="prenom" required placeholder="ex: Antoine">
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="adresse">Adresse</label>
            <input class="form-control" type="text" id="adresse" name="adresse" required placeholder="ex: 19 Avenue des Champs Elysée">
        </div>
        <div id="error-code-postal" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="codePostal">Code postal</label>
            <div>
                <input class="form-control" type="text" id="codePostal" name="codePostal" required placeholder="ex: 33000">
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="ville">Ville</label>
            <input class="form-control" type="text" id="ville" name="ville" required placeholder="ex: Bordeaux">
        </div>
        <div id="error-telephone" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="telephone">Téléphone</label>
            <div>
                <input class="form-control" type="text" id="telephone" name="telephone" required placeholder="ex: 0612345678">
            </div>
        </div>
        <div id="error-email" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required placeholder="exemple@exemple.com">
        </div>
        <div id="error-mot-de-passe" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="motdepasse">Mot de passe</label>
            <div class="password password-input">
                <input class="form-control" type="password" id="motdepasse" name="password" required placeholder="Votre mot de passe">
                <button type="button" onclick="togglePassword('motdepasse')" aria-label="Afficher ou masquer le mot de passe">👁</button>
            </div>
        </div>
        <div id="error-confirmation" class="alert alert-danger" style="display:none"></div>
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-start mb-4">
            <label class="mb-1 d-block" for="confirm_motdepasse">Confirmation de votre mot de passe</label>
            <div class="password password-input">
                <input class="form-control" type="password" id="confirm_motdepasse" name="confirm_password" required placeholder="Votre mot de passe">
                <button type="button" onclick="togglePassword('confirm_motdepasse')" aria-label="Afficher ou masquer le mot de passe">👁</button>
            </div>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">créer votre compte</button>
        <div class=" mt-1">
            <p>Déjà un compte? <a href="/connexion">Se connecter</a></p>
        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>