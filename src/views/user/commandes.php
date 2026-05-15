<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h2 class="text-center">mes commandes</h2>
</div>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
<?php endif; ?>

<div>
    <table class="table table-hover table-borderless table-responsive-md">
        <thead>
            <tr>
                <th scope="col">N° commande</th>
                <th scope="col">Date commande</th>
                <th scope="col">Menu</th>
                <th scope="col">Nb personnes</th>
                <th scope="col">Montant</th>
                <th scope="col">Statut</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <th scope="row"><?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?></th>
                    <td> <?= $commande['date_commande'] ?></td>
                    <td> <?= htmlspecialchars($commande['menu_titre']) ?></td>
                    <td> <?= $commande['nbre_pers'] ?></td>
                    <td> <?= $commande['montant_total'] ?></td>
                    <td> <?= htmlspecialchars($commande['statut_actuel']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-<?= $commande['Id_commande'] ?>">Détails</button>
                        <?php $peutModifier = $commande['statut_actuel'] === 'En attente de validation'; ?>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-modifier-<?= $commande['Id_commande'] ?>" <?= !$peutModifier ? 'disabled' : '' ?>>Modifier</button>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-annuler-<?= $commande['Id_commande'] ?>" <?= !$peutModifier ? 'disabled' : '' ?>>Annuler</button>
                    </td>
                </tr>
                <div class="modal fade" id="modal-<?= $commande['Id_commande'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Détails de la commande</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>N° commande:</strong> <?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?> </p>
                                <p><strong>Date de la commande:</strong> <?= $commande['date_commande'] ?></p>
                                <p><strong>Menu choisi:</strong> <?= $commande['menu_titre'] ?></p>
                                <p><strong>Nombre de personnes:</strong> <?= $commande['nbre_pers'] ?></p>
                                <p><strong>Mode de retrait:</strong> <?= $commande['type_livraison'] ?></p>
                                <?php if ($commande['type_livraison'] === 'Livraison'): ?>
                                    <p><strong>Adresse de livraison:</strong> <?= htmlspecialchars($commande['adresse_livraison']) ?>, <?= $commande['code_postal_livraison'] ?> <?= htmlspecialchars($commande['ville_livraison']) ?></p>
                                <?php endif; ?>
                                <p><strong>Date souhaitée:</strong> <?= $commande['date_livraison'] ?></p>
                                <p><strong>Heure souhaitée:</strong> <?= $commande['heure_livraison'] ?></p>
                                <?php if ($commande['pret_materiel'] == '1'): ?>
                                    <p><strong>Prêt de matériel: </strong>Oui</p>
                                <?php endif; ?>
                                <?php if ($commande['type_livraison'] === 'Livraison'): ?>
                                    <p><strong>Frais de livraison:</strong> <?= $commande['prix_livraison'] ?> €</p>
                                <?php endif; ?>
                                <p><strong>Montant total:</strong> <?= $commande['montant_total'] ?> €</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" id="modal-annuler-<?= $commande['Id_commande'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Annulation de votre commande: <?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Confirmez-vous l'annulation de votre commande?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Retour</button>
                                <form action="/mon-espace/commandes/annuler" method="post">
                                    <input type="hidden" name="id_commande" value="<?= $commande['Id_commande'] ?>">
                                    <button type="submit" class="btn btn-danger">Confirmer l'annulation</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-modifier-<?= $commande['Id_commande'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modifier la commande: <?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="form-modifier-<?= $commande['Id_commande'] ?>" action="/mon-espace/commandes/modifier" method="post">
                                    <input type="hidden" name="id_commande" value="<?= $commande['Id_commande'] ?>">

                                    <div class="livraison text-start mb-4 ">
                                        <label class="mb-2 d-block" for="type_liv_liv">Type de livraison</label>
                                        <input type="radio" id="livraison" name="type_liv" required value="Livraison" <?= $commande['type_livraison'] === 'Livraison' ? 'checked' : '' ?>>
                                        <label for="livraison">Livraison</label>
                                        <input class="ms-2" type="radio" id="enlevement" name="type_liv" required value="Enlevement" <?= $commande['type_livraison'] === 'Enlevement' ? 'checked' : '' ?>>
                                        <label for="enlevement">Retrait sur place</label>
                                    </div>

                                    <div class="livraison livraison-param text-start mb-4">
                                        <label class="mb-1 d-block" for="adresse_liv">Adresse de livraison</label>
                                        <input class="form-control" type="text" id="adresse_liv" name="adresse_liv" value="<?= htmlspecialchars($commande['adresse_livraison']) ?>">
                                    </div>

                                    <div class="livraison livraison-param text-start mb-4">
                                        <label class="mb-1 d-block" for="codePostal">Code postal</label>
                                        <input class="form-control" type="text" id="codePostal_liv" name="codePostal_liv" value="<?= htmlspecialchars($commande['code_postal_livraison']) ?>">
                                    </div>

                                    <div class="livraison livraison-param text-start mb-4">
                                        <label class="mb-1 d-block" for="ville_liv">Ville</label>
                                        <input class="form-control" type="text" id="ville_liv" name="ville_liv" value="<?= htmlspecialchars($commande['ville_livraison']) ?>">
                                    </div>

                                    <div id="error-date" class="alert alert-danger" style="display:none"></div>

                                    <div class="livraison text-start mb-4">
                                        <label class="mb-1 d-block" for="date_liv">Date</label>
                                        <p><em>Merci de tenir compte du délai de commande minimum indiqué pour chaque menu</em></p>
                                        <input class="form-control" type="date" id="date_liv" name="date_liv" value="<?= htmlspecialchars($commande['date_livraison']) ?>">
                                    </div>

                                    <div class="livraison text-start mb-4">
                                        <label class="mb-1 d-block" for="heure_liv">Heure</label>
                                        <input class="form-control" type="time" id="heure_liv" name="heure_liv" min="9:00" max="20:00" value="<?= htmlspecialchars($commande['heure_livraison']) ?>">
                                    </div>

                                    <div class="livraison text-start mb-4">
                                        <label class="mb-1 d-block" for="nbre_pers">Nombre de personnes</label>
                                        <input class="form-control" type="number" id="nbre_pers" name="nbre_pers" min="1" value="<?= htmlspecialchars($commande['nbre_pers']) ?>">
                                    </div>

                                    <div class="livraison text-start mb-4">
                                        <label for="pret-materiel">Prêt de matériel</label>
                                        <input type="checkbox" id="pret-materiel" name="pret_materiel" <?= $commande['pret_materiel'] == 1 ? 'checked' : '' ?>>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" form="form-modifier-<?= $commande['Id_commande'] ?>" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php require_once('../src/views/layouts/footer.php'); ?>