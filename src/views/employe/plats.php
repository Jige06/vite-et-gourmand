<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-employe.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace employé</h1>
    <h2>Gestion des plats</h2>
</div>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'];
                                                unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <button class="connect-button" data-bs-toggle="modal" data-bs-target="#modalCreerPlat">
            + créer un plat
        </button>
    </div>

    <!-- tableau des plats -->
    <div>
        <table class="table table-hover table-responsive-md align-middle">
            <thead>
                <tr>
                    <th scope="col">Nom du plat</th>
                    <th scope="col">Type du plat</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plats as $plat): ?>
                    <tr>
                        <td><?= htmlspecialchars($plat['titre']) ?></td>
                        <td><?= htmlspecialchars($plat['type_plat']) ?></td>
                        <td>
                            <button
                                class="connect-button mb-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalModifPlat"
                                data-id="<?= $plat['Id_plat'] ?>"
                                data-titre="<?= htmlspecialchars($plat['titre']) ?>"
                                data-type="<?= htmlspecialchars($plat['type_plat']) ?>">
                                modifier
                            </button>
                            <input type="hidden" name="Id_plat" value="<?= $plat['Id_plat'] ?>">
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalSupprimerPlat" data-id="<?= $plat['Id_plat'] ?>">supprimer</button>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- modal de création d'un plat -->
    <div class="modal fade" id="modalCreerPlat" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Créer un plat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-crea-plat" enctype="multipart/form-data" action="/employe/plats" method="post">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="creer">
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nom du plat</label>
                            <input class="form-control" type="text" name="titre" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Type du plat</label>
                            <select class="form-control" name="type_plat" required>
                                <option value="">Veuillez choisir un type:</option>
                                <option value="Entrée">Entrée</option>
                                <option value="Plat">Plat</option>
                                <option value="Fromage">Fromage</option>
                                <option value="Dessert">Dessert</option>
                            </select>
                        </div>
                        <label class="mb-1 d-block">Photo</label>
                        <input class="form-control" type="file" name="photo" accept="image/*" required>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <button type="submit" form="form-crea-plat" class="btn btn-primary">créer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal de modification d'un plat -->
    <div class="modal fade" id="modalModifPlat" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier un plat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-modif-plat" action="/employe/plats" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="Id_plat" value="<?= $plat['Id_plat'] ?>">
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nom du plat</label>
                            <input class="form-control" type="text" name="titre" required>
                        </div>

                        <div class="mb-3">
                            <label class="mb-1 d-block">Type du plat</label>
                            <select class="form-control" name="type_plat" required>
                                <option value="">Veuillez choisir un type:</option>
                                <option value="Entrée">Entrée</option>
                                <option value="Plat">Plat</option>
                                <option value="Fromage">Fromage</option>
                                <option value="Dessert">Dessert</option>
                            </select>
                        </div>
                        <label class="mb-1 d-block">Photo</label>
                        <input class="form-control" type="file" name="photo" accept="image/*">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <button type="submit" form="form-modif-plat" class="btn btn-primary">modifier</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal confirmation suppression -->
    <div class="modal fade" id="modalSupprimerPlat" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce plat ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <form method="POST" action="/employe/plats">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="Id_plat" id="id-plat-supprimer">
                        <button type="submit" class="btn btn-danger">supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('../src/views/layouts/footer.php'); ?>