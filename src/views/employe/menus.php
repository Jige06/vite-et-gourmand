<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h2>Gestion des menus</h2>
</div>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
                                                unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'];
                                            unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <button class="connect-button" data-bs-toggle="modal" data-bs-target="#modalCreerMenu">
            + créer un menu
        </button>
    </div>

    <!-- tableau des menus -->
    <div>
        <table class="table table-hover table-responsive-md align-middle">
            <thead>
                <tr>
                    <th scope="col">Nom du menu</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix par personne</th>
                    <th scope="col">Nombre min par personne</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Conditions</th>
                    <th scope="col">Régime</th>
                    <th scope="col">Thème</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                    <tr>
                        <td><?= htmlspecialchars($menu['titre']) ?></td>
                        <td><?= htmlspecialchars($menu['description_menu']) ?></td>
                        <td><?= htmlspecialchars($menu['prix_par_pers']) ?> €</td>
                        <td><?= htmlspecialchars($menu['nombre_pers_min']) ?></td>
                        <td><?= htmlspecialchars($menu['quantite_restante']) ?></td>
                        <td><?= htmlspecialchars($menu['conditions']) ?></td>
                        <td><?= htmlspecialchars($menu['regime']) ?></td>
                        <td><?= htmlspecialchars($menu['theme_libelle']) ?></td>
                        <td>
                            <button
                                class="connect-button mb-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalModifMenu"
                                data-id="<?= $menu['Id_menu'] ?>"
                                data-titre="<?= htmlspecialchars($menu['titre']) ?>"
                                data-description="<?= htmlspecialchars($menu['description_menu']) ?>"
                                data-prix="<?= $menu['prix_par_pers'] ?>"
                                data-pers="<?= $menu['nombre_pers_min'] ?>"
                                data-stock="<?= $menu['quantite_restante'] ?>"
                                data-conditions="<?= htmlspecialchars($menu['conditions']) ?>"
                                data-regime="<?= htmlspecialchars($menu['regime']) ?>"
                                data-theme="<?= $menu['Id_theme'] ?>">
                                modifier
                            </button>
                            <input type="hidden" name="Id_menu" value="<?= $menu['Id_menu'] ?>">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSupprimerMenu" data-id="<?= $menu['Id_menu'] ?>">supprimer</button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- modal de création d'un menu-->
    <div class="modal fade" id="modalCreerMenu" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Créer un menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-crea-menu" enctype="multipart/form-data" action="/employe/menus" method="post">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="creer">
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nom du menu</label>
                            <input class="form-control" type="text" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Description</label>
                            <input class="form-control" type="text" name="description_menu" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Prix par personne</label>
                            <input class="form-control" type="number" name="prix_par_pers" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nombre de pers minimum</label>
                            <input class="form-control" type="number" name="nombre_pers_min" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Stock</label>
                            <input class="form-control" type="number" name="quantite_restante" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Conditions</label>
                            <input class="form-control" type="text" name="conditions" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Régime</label>
                            <input class="form-control" type="text" name="regime" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Thème</label>
                            <select class="form-control" name="Id_theme" required>
                                <?php foreach ($themes as $theme): ?>
                                    <option value="<?= $theme['Id_theme'] ?>">
                                        <?= htmlspecialchars($theme['libelle']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label class="mb-1 d-block">Photo</label>
                        <input class="form-control" type="file" name="photo" accept="image/*" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <button type="submit" form="form-crea-menu" class="btn btn-primary">créer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal de modification d'un menu-->
    <div class="modal fade" id="modalModifMenu" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier un menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-modif-menu" action="/employe/menus" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="Id_menu" value="<?= $menu['Id_menu'] ?>">
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nom du menu</label>
                            <input class="form-control" type="text" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Description</label>
                            <input class="form-control" type="textarea" name="description_menu" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Prix par personne</label>
                            <input class="form-control" type="number" name="prix_par_pers" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nombre de pers minimum</label>
                            <input class="form-control" type="number" name="nombre_pers_min" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Stock</label>
                            <input class="form-control" type="number" name="quantite_restante" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Conditions</label>
                            <input class="form-control" type="text" name="conditions" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Régime</label>
                            <input class="form-control" type="text" name="regime" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Thème</label>
                            <select class="form-control" name="Id_theme" required>
                                <?php foreach ($themes as $theme): ?>
                                    <option value="<?= $theme['Id_theme'] ?>">
                                        <?= htmlspecialchars($theme['libelle']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label class="mb-1 d-block">Photo</label>
                        <input class="form-control" type="file" name="photo" accept="image/*">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <button type="submit" form="form-modif-menu" class="btn btn-primary">modifier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal confirmation suppression -->
    <div class="modal fade" id="modalSupprimerMenu" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce menu ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <form method="POST" action="/employe/menus">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="Id_menu" id="id-menu-supprimer">
                        <button type="submit" class="btn btn-danger">supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('../src/views/layouts/footer.php'); ?>