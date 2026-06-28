<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h1 class="text-center">Vite & Gourmand</h1>
</div>

<div class="contact my-5 p3-5">
    <div class="titre-realisation text-center pb-4 pt-4">
        <h2>Contact</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success text-center"><?= $_SESSION['success'];
                                                            unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
                                            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
    </div>

    <form class="d-flex flex-column align-items-center" action="/contact" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="mb-3 col-12 col-md-8 col-lg-8 mx-auto">
            <label for="email" class="form-label">Votre email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@exemple.com" required>
        </div>


        <div class="mb-3 col-12 col-md-8 col-lg-8 mx-auto">
            <label for="titre" class="form-label">Objet</label>
            <input class="form-control" type="text" id="titre" name="titre" required placeholder="ex: Demande de devis">
        </div>


        <div class="mb-3 col-12 col-md-8 col-lg-8 mx-auto">
            <label for="description" class="form-label">Votre message</label>
            <textarea class="form-control" id="description" name="description" rows="8" required autocorrect="on" maxlength="300"></textarea>
        </div>
        <button class="connect-button mb-3 mt-3" type="submit">envoyer</button>
    </form>

</div>


<?php require_once('../src/views/layouts/footer.php'); ?>