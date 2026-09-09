<footer>
    <div class="container-fluid footer text-center pt-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="colonne">
                    <?php
                    $horaires = HoraireRepository::getAllHoraire();
                    foreach ($horaires as $horaire):
                    ?>
                        <p><?= htmlspecialchars($horaire['jour']) ?> : <?= htmlspecialchars($horaire['heure_ouverture']) ?> - <?= htmlspecialchars($horaire['heure_fermeture']) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col">
                <p>Vite & Gourmand</p>
                <p>19 rue Bouffard</p>
                <p>33000 Bordeaux</p>
                <p>05 57 84 12 34</p>
            </div>
            <div class="lien col">
                <a href="mailto:contact@viteetgourmand.fr">contact@viteetgourmand.fr</a>
            </div>
        </div>
        <div class="lien text-center">
            <a href="/mentions-legales">Mentions légales</a>
            <a href="/cgv">Conditions générales de vente</a>
        </div>
    </div>
</footer>