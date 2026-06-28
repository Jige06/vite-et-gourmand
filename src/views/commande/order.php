<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h1 class="text-center">Commande</h1>
</div>

<div class="form-container">
    <form class="d-flex flex-column align-items-center" action="/commande" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <!-- Étape 1 : Informations de commande -->
        <div class="form-user mt-4 mb-4" id="form-user">

            <div class="livraison mb-4 text-center">
                <h2>informations de commande</h2>
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="nom">Nom</label>
                <input class="form-control" type="text" id="nom" name="nom" disabled value="<?= $_SESSION['nom'] ?>">
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="prenom">Prénom</label>
                <input class="form-control" type="text" id="prenom" name="prenom" disabled value="<?= $_SESSION['prenom'] ?>">
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" disabled value="<?= $_SESSION['email'] ?>">
            </div>

            <div class="livraison text-start mb-4 ">
                <label class="mb-2 d-block" for="type_liv_liv">Type de livraison</label>
                <input class="" type="radio" id="livraison" name="type_liv" required value="Livraison" checked>
                <label for="livraison">Livraison</label>
                <input class="ms-2" type="radio" id="enlevement" name="type_liv" required value="Enlevement">
                <label for="enlevement">Retrait sur place</label>
            </div>

            <div id="error-livraison" class="alert alert-danger" style="display:none"></div>

            <div class="livraison livraison-param text-start mb-4">
                <label class="mb-1 d-block" for="adresse_liv">Adresse de livraison</label>
                <input class="form-control" type="text" id="adresse_liv" name="adresse_liv" placeholder="ex: 19 Avenue des Champs Elysée">
            </div>

            <div class="livraison livraison-param text-start mb-4">
                <label class="mb-1 d-block" for="codePostal">Code postal</label>
                <input class="form-control" type="text" id="codePostal_liv" name="codePostal_liv" placeholder="ex: 33000">
            </div>

            <div class="livraison livraison-param text-start mb-4">
                <label class="mb-1 d-block" for="ville_liv">Ville</label>
                <input class="form-control" type="text" id="ville_liv" name="ville_liv" placeholder="ex: Bordeaux">
            </div>

            <div id="error-date" class="alert alert-danger" style="display:none"></div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="date_liv">Date</label>
                <p><em>Merci de tenir compte du délai de commande minimum indiqué pour chaque menu</em></p>
                <input class="form-control" type="date" id="date_liv" name="date_liv" required>
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="heure_liv">Heure</label>
                <input class="form-control" type="time" id="heure_liv" name="heure_liv" min="9:00" max="20:00" required>
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="telephone">Téléphone</label>
                <input class="form-control" type="text" id="telephone" name="telephone" disabled value="<?= $user['telephone'] ?>">
            </div>

            <div class="text-center">
                <button class="connect-button mb-3 mt-3" id="etape-apres1" type="button">étape suivante</button>
            </div>

        </div>




        <div class="form-menu mt-4 mb-4" id="form-menu">
            <!-- Étape 2 : Choix du menu -->
            <div class="livraison mb-4 text-center">
                <h2>choix de votre menu</h2>
            </div>

            <label for="menu">Choisissez un menu</label>

            <select name="menu" id="menu">
                <?php foreach ($menus as $menu): ?>
                    <option value="<?= htmlspecialchars($menu['Id_menu']) ?>" data-prix="<?= $menu['prix_par_pers'] ?>"
                        data-min-pers="<?= $menu['nombre_pers_min'] ?>" <?= $menu['Id_menu'] == $idMenu ? 'selected' : '' ?>><?= htmlspecialchars($menu['titre']) ?></option>
                <?php endforeach; ?>
            </select>

            <div class="text-center mt-5">
                <button class="connect-button mb-3 mt-3" id="etape-avant2" type="button">étape précédente</button>
                <button class="connect-button mb-3 mt-3 ms-5" id="etape-apres2" type="button">étape suivante</button>
            </div>

        </div>

        <div class="form-order mt-4 mb-4" id="form-order">
            <!-- Étape 3 : Finalisation -->
            <div class="livraison mb-4 text-center">
                <h2>finalisation de votre commande</h2>
            </div>

            <div class="livraison text-start mb-4">
                <label class="mb-1 d-block" for="nbre_pers">Nombre de personnes</label>
                <input class="form-control" type="number" id="nbre_pers" name="nbre_pers" min="1" required>
            </div>

            <div class="livraison text-start mb-4">
                <label for="pret-materiel">Prêt de matériel</label>
                <input type="checkbox" id="pret-materiel" name="pret_materiel">
            </div>

            <div id="info-pret-materiel" class="alert alert-warning" style="display:none">
                <strong>⚠️ Information importante :</strong> Matériel à restituer sous 10 jours ouvrés.
                Passé ce délai, des frais de <strong>600€</strong> vous seront facturés conformément à nos CGV. Un mail d'information vous sera envoyé.
            </div>

            <div class="alert alert-info">
                <strong>Réduction de 10% pour toute commande supérieure à 5 personnes que le minimum requis.</strong>
            </div>

            <div id="recap-livraison">

            </div>

            <input type="hidden" name="prix_livraison" id="hidden-livraison">

            <div class="mt-4" id="recap-menu"></div>

            <div class="mt-4" id="recap-reduc"></div>

            <div class="mt-4" id="recap-total"></div>

            <input type="hidden" name="montant_total" id="hidden-total">

            <div class="text-center mt-4">
                <button class="connect-button mb-3 mt-3" id="etape-avant3" type="button">étape précédente</button>
                <button class="connect-button mb-3 mt-3 ms-5" id="validation" type="submit">valider</button>
            </div>

        </div>
    </form>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>