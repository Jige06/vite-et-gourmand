<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h2>Gestion des horaires</h2>
</div>

<div class="container mb-4 table-responsive">
    <form method="POST" action="/employe/horaires">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="action" value="modifier">
        <table class="table table-hover table-striped table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">Jour de la semaine</th>
                    <th scope="col">Heure d'ouverture</th>
                    <th scope="col">Heure de fermeture</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires as $horaire): ?>
                    <tr>
                        <td><?= htmlspecialchars($horaire['jour']) ?></td>
                        <td>
                            <input type="time"
                                name="heure_ouverture[<?= $horaire['Id_horaire'] ?>]"
                                value="<?= htmlspecialchars($horaire['heure_ouverture']) ?>">
                        </td>
                        <td>
                            <input type="time"
                                name="heure_fermeture[<?= $horaire['Id_horaire'] ?>]"
                                value="<?= htmlspecialchars($horaire['heure_fermeture']) ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <button class="connect-button mt-3" type="submit">enregistrer les horaires</button>
    </form>
</div>


<?php require_once('../src/views/layouts/footer.php'); ?>