<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h2 class="text-center">Commande</h2>
</div>

<form class="d-flex flex-column align-items-center" action="/commande" method="post">
    <div class="form-user container-fluid" id="form-user">


        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="nom">Nom</label>
            <input class="form-control" type="text" id="nom" name="nom" disabled value="<?= $_SESSION['nom'] ?>">
        </div>

        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="prenom">Prénom</label>
            <div class="password">
                <input class="form-control" type="text" id="prenom" name="prenom" disabled value="<?= $_SESSION['prenom'] ?>">
            </div>
        </div>

        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" disabled value="<?= $_SESSION['email'] ?>">
        </div>

        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="type_liv_liv">Type de livraison</label>

            <input class="" type="radio" id="livraison" name="type_liv" required value="Livraison" checked>
            <label for="livraison">Livraison</label>
            <input class="" type="radio" id="enlevement" name="type_liv" required value="Enlevement">
            <label for="enlevement">Enlèvement</label>
        </div>
        <div id="error-livraison" class="alert alert-danger" style="display:none"></div>
        <div class="livraison text-start mb-4">
            <label class="mb-1 d-block" for="adresse_liv">Adresse de livraison</label>
            <input class="form-control" type="text" id="adresse_liv" name="adresse_liv" required placeholder="ex: 19 Avenue des Champs Elysée">
        </div>

        <div class=" livraison text-start mb-4">
            <label class="mb-1 d-block" for="codePostal">Code postal de livraison</label>
            <div>
                <input class="form-control" type="text" id="codePostal_liv" name="codePostal_liv" required placeholder="ex: 33000">
            </div>
        </div>

        <div class="livraison text-start mb-4">
            <label class="mb-1 d-block" for="ville_liv">Ville de livraison</label>
            <input class="form-control" type="text" id="ville_liv" name="ville_liv" required placeholder="ex: Bordeaux">
        </div>
<div id="error-date" class="alert alert-danger" style="display:none"></div>
        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="date_liv">Date de livraison</label>
            <input class="form-control" type="date" id="date_liv" name="date_liv" required>
        </div>

        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="heure_liv">Heure de livraison</label>
            <input class="form-control" type="time" id="heure_liv" name="heure_liv" min="9:00" max="20:00" required>
        </div>


        <div class="text-start mb-4">
            <label class="mb-1 d-block" for="telephone">Téléphone</label>
            <div>
                <input class="form-control" type="text" id="telephone" name="telephone" disabled value="<?= $user['telephone'] ?>">
            </div>
        </div>
        <button class="connect-button mb-3 mt-3" id="etape-apres1" type="button">Etape suivante</button>

    </div>




    <div class="form-menu container-fluid" id="form-menu">

        <label for="menu">Choisissez un menu</label>

        <select name="menu" id="menu">
            <?php foreach ($menus as $menu): ?>
                <option value="<?= htmlspecialchars($menu['Id_menu']) ?>" data-prix="<?= $menu['prix_par_pers'] ?>"
                    data-min-pers="<?= $menu['nombre_pers_min'] ?>" <?= $menu['Id_menu'] == $idMenu ? 'selected' : '' ?>><?= htmlspecialchars($menu['titre']) ?></option>
            <?php endforeach; ?>
        </select>

        <button class="connect-button mb-3 mt-3" id="etape-avant2" type="button">Etape précédente</button>
        <button class="connect-button mb-3 mt-3" id="etape-apres2" type="button">Etape suivante</button>

    </div>






    <div id="form-order">




        <div class="connexion text-start mb-4">
            <label class="mb-1 d-block" for="nbre_pers">Nombre de personnes</label>
            <input class="form-control" type="number" id="nbre_pers" name="nbre_pers" min="1" required>
        </div>

        <div class="connexion text-start mb-4">
            <label for="pret-materiel">Prêt de matériel</label>
            <input type="checkbox" id="pret-materiel" name="pret-materiel">

        </div>

        <div class="alert alert-info">
            <strong>Une réduction de 10% est appliquée pour toutes commandes ayant 5 personnes de plus que le nombre de personnes minimum indiquée dans le menu</strong>
        </div>


        <div id="recap-livraison">

        </div>
        <input type="hidden" name="prix_livraison" id="hidden-livraison">
        <div id="recap-menu">

        </div>
        <div id="recap-reduc">

        </div>

        <div id="recap-total">

        </div>
        <input type="hidden" name="montant_total" id="hidden-total">
        <button class="connect-button mb-3 mt-3" id="etape-avant3" type="button">Etape précédente</button>
        <button class="connect-button mb-3 mt-3" id="validation" type="submit">Validez</button>
    </div>

</form>



<?php require_once('../src/views/layouts/footer.php'); ?>