<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-admin.php'); ?>

<div class="employe text-center mt-4 mb-4">
    <h1>Espace administrateur</h1>
    <h2>Tableau des employés</h2>
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
        <button class="connect-button" data-bs-toggle="modal" data-bs-target="#modalCreerEmploye">
            + créer un compte employé
        </button>
    </div>

    <!-- tableau des employés -->
    <div>
        <table class="table table-hover table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $employe): ?>
                    <tr>
                        <td><?= htmlspecialchars($employe['nom']) ?></td>
                        <td><?= htmlspecialchars($employe['prenom']) ?></td>
                        <td><?= htmlspecialchars($employe['email']) ?></td>
                        <td>
                            <?php if ($employe['actif'] == 1): ?>
                                <span class="badge bg-success">actif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">désactivé</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($employe['actif'] == 1): ?>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeactivate" data-id="<?= $employe['Id_Utilisateur'] ?>">désactiver</button>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- modal de création d'un compte employé-->
    <div class="modal fade" id="modalCreerEmploye" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Créer un compte employé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-crea-employe" action="/admin" method="post">
                        <input type="hidden" name="action" value="creer">
                        <div class="mb-3">
                            <label class="mb-1 d-block">Nom</label>
                            <input class="form-control" type="text" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">Prénom</label>
                            <input class="form-control" type="text" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block">email</label>
                            <input class="form-control" type="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label class="mb-1 d-block" for="motdepasse">Mot de passe</label>
                            <div class="password-input">
                                <input class="form-control" type="password" id="motdepasse" name="password" required placeholder="Votre mot de passe">
                                <span class="toggle-password" onclick="togglePassword('motdepasse')">👁</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 d-block" for="confirm_motdepasse">Confirmation de votre mot de passe</label>
                            <div class="password-input">
                                <input class="form-control" type="password" id="confirm_motdepasse" name="confirm_password" required placeholder="Votre mot de passe">
                                <span class="toggle-password" onclick="togglePassword('confirm_motdepasse')">👁</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <button type="submit" form="form-crea-employe" class="connect-button">créer le compte</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal confirmation désactivation -->
    <div class="modal fade" id="modalDeactivate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la désactivation du compte employé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir désactiver ce compte employé ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                    <form method="POST" action="/admin">
                        <input type="hidden" name="action" value="desactiver">
                        <input type="hidden" name="id_user" id="id-utilisateur-desactiver">
                        <button type="submit" class="btn btn-danger">désactiver</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>