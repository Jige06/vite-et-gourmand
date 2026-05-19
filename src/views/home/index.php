<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h3 class="text-center">Julie et José vous souhaitent la bienvenue chez</h3>
    <h2 class="text-center">Vite & Gourmand</h2>
    <button onclick="window.location.href='/menus'" class="big-title-button mb-3 mt-3" type="submit">Découvrir nos menus</button>
</div>

<div class="presentation container-fluid text-center mb-4 mt-4 pt-4 pb-4">
    <div class="titre-presentation pb-4 pt-4">
        <h3>notre entreprise</h3>
    </div>
    <div class="text-presentation pb-1">
        <p>Portée par Julie et José, notre équipe met son professionnalisme au service de vos événements. Des repas de fêtes (Noël, Pâques) aux grandes célébrations (mariages, séminaires), nous proposons des menus savoureux en constante évolution, adaptés à tous les régimes. Profitez de notre savoir-faire artisanal et d'une commande simplifiée pour faire de vos réceptions un moment gastronomique d’exception.</p>
    </div>
    <div class="image-presentation">
        <img src="/assets/images/Julie_et_José.png" alt="Julie_et_José_en_photo">
    </div>
</div>

<div class="realisations container-fluid text-center mb-4 mt-4 pb-4 pt-4">
    <div class="titre-realisation pb-4 pt-4">
        <h3>nos réalisations</h3>
    </div>
    <div class="text-realisation pb-1">
        <p>Découvrez nos dernières créations culinaires et laissez-vous inspirer pour votre prochain événement.</p>
    </div>
    <div class="row image mt-4">
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/asperges_sauce_mousseline.png" alt="asperges_sauce_mousseline">
        </div>
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/buffet_entrees_maraicheres.png" alt="buffet_entrees_maraicheres">
        </div>
    </div>
    <div class="row image">
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/cochon_lait_roti_broche.png" alt="cochon_lait_roti_broche">
        </div>
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/filet_boeuf_en_croute_juscorse.png" alt="filet_boeuf_en_croute_juscorse">
        </div>
    </div>
    <div class="row image">
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/plateaux_fromages_france.png" alt="plateaux_fromages_france">
        </div>
        <div class="col-12 col-md-12 col-lg-6 image-realisation mb-4">
            <img src="/assets/images/plats/trio_gourmandises_chocolatees.png" alt="trio_gourmandises_chocolatees">
        </div>
    </div>
    <button onclick="window.location.href='/menus'" class="connect-button mb-3 mt-3" type="submit">Découvrir nos menus</button>
</div>

<div class="section-avis container-fluid text-start mb-4 mt-4 pb-4 pt-4">
    <div class="titre-avis text-center pb-4 pt-4">
        <h3>quelques avis clients</h3>
    </div>
    <?php foreach ($validatedReviews as $avis): ?>
        <div class="avis ps-3 pe-3 pt-3 mt-2 mb-2">
            <p>Note: <?= htmlspecialchars($avis['note']) ?>/5</p>
            <p>Prénom: <?= htmlspecialchars($avis['prenom']) ?></p>
            <p>"<?= htmlspecialchars($avis['description_avis']) ?>"</p>
        </div>
    <?php endforeach; ?>
    <div class="avis-button text-center">
        <button onclick="window.location.href='/avis'" class="connect-button mb-3 mt-3" type="submit">Lire les avis</button>
    </div>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>