<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/public/assets/images/Buffet_Big_title.png" alt="buffet">
    <h2 class="text-center">Inscription</h2>
</div>
<div class="box-connexion container-fluid">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form class="d-flex flex-column align-items-center" action="/inscription" method="post">
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="nom">Nom</label>
            <input class="form-control" type="text" id="nom" name="nom" required placeholder="ex: Martin">
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="prenom">Prénom</label>
            <div class="password">
                <input class="form-control" type="text" id="prenom" name="prenom" required placeholder="ex: Antoine">
            </div>
        </div>
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="adresse">Adresse</label>
            <input class="form-control" type="text" id="adresse" name="adresse" required placeholder="ex: 19 Avenue des Champs Elysée">
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="codePostal">Code postal</label>
            <div>
                <input class="form-control" type="text" id="codePostal" name="codePostal" required placeholder="ex: 33000">
            </div>
        </div>
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="ville">Ville</label>
            <input class="form-control" type="text" id="ville" name="ville" required placeholder="ex: Bordeaux">
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="telephone">Téléphone</label>
            <div>
                <input class="form-control" type="text" id="telephone" name="telephone" required placeholder="ex: 0612345678">
            </div>
        </div>
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required placeholder="exemple@exemple.com">
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="motdepasse">Mot de passe</label>
            <div>
                <input class="form-control" type="password" id="motdepasse" name="password" required placeholder="Votre mot de passe">
            </div>
        </div>
        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="confirm_motdepasse">Confirmation de votre mot de passe</label>
            <div>
                <input class="form-control" type="password" id="confirm_motdepasse" name="confirm_password" required placeholder="Votre mot de passe">
            </div>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">Créer votre compte</button>
        <div class=" mt-1">
            <p>Déjà un compte? <a href="/connexion">Se connecter</a></p>
        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>