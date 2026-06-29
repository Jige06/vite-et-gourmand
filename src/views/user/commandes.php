<?php require_once('../src/views/layouts/header.php'); ?>

<div class="big-title-accueil container-fluid">
    <img src="/assets/images/Buffet_Big_title.png" alt="buffet">
    <h1 class="text-center">mon espace</h1>
</div>

<div class="mon_espace text-center py-2">
    <button class="connect-button my-4 mx-4" data-bs-toggle="modal" data-bs-target="#modal-profil">modifier mon profil</button>
</div>

<div class="text-center mt-4 mb-4">
    <h2>mes commandes</h2>
</div>

<!-- Modal de modification des informations du profil -->
<div class="modal fade" id="modal-profil" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier mon profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-profil" action="/mon-espace/profil" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div id="error-nom" class="alert alert-danger" style="display:none"></div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Nom</label>
                        <input id="nom" class="form-control" type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Prénom</label>
                        <input id="prenom" class="form-control" type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                    </div>
                    <div id="error-email" class="alert alert-danger" style="display:none"></div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Email</label>
                        <input id="email" class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div id="error-telephone" class="alert alert-danger" style="display:none"></div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Téléphone</label>
                        <input id="telephone" class="form-control" type="text" name="telephone" value="<?= htmlspecialchars($user['telephone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Adresse</label>
                        <input id="adresse" class="form-control" type="text" name="adresse" value="<?= htmlspecialchars($user['adresse']) ?>" required>
                    </div>
                    <div id="error-code-postal" class="alert alert-danger" style="display:none"></div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Code postal</label>
                        <input id="codePostal" class="form-control" type="text" name="code_postal" value="<?= htmlspecialchars($user['code_postal']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="mb-1 d-block">Ville</label>
                        <input id="ville" class="form-control" type="text" name="ville" value="<?= htmlspecialchars($user['ville']) ?>" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                <button type="submit" form="form-profil" class="connect-button">enregistrer</button>
            </div>
        </div>
    </div>
</div>


<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'];
                                        unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'];
                                    unset($_SESSION['error']); ?></div>
<?php endif; ?>

<!-- Tableau des commandes du client -->
<div class="py-5 px-5">
    <table class="table table-hover table-responsive-md align-middle">
        <thead>
            <tr class="text-center">
                <th scope="col">N° de commande</th>
                <th scope="col">Date de commande</th>
                <th scope="col">Menu</th>
                <th scope="col">Nombre de personnes</th>
                <th scope="col">Montant Total</th>
                <th scope="col">Statut</th>
                <th scope="col">Suivi de commande</th>
                <th scope="col">Actions</th>
                <th scope="col">Avis</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr class="text-center">
                    <th scope="row"><?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?></th>
                    <td> <?= $commande['date_commande'] ?></td>
                    <td> <?= htmlspecialchars($commande['menu_titre']) ?></td>
                    <td> <?= $commande['nbre_pers'] ?></td>
                    <td> <?= $commande['montant_total'] ?></td>
                    <td> <?= htmlspecialchars($commande['statut_actuel']) ?></td>
                    <?php $peutSuivre = !in_array($commande['statut_actuel'], ['En attente de validation', 'Annulé']); ?>
                    <td>
                        <button class="btn btn-sm btn-info" <?= !$peutSuivre ? 'disabled' : '' ?> data-bs-toggle="modal" data-bs-target="#modal-suivi-<?= $commande['Id_commande'] ?>">suivi</button>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-<?= $commande['Id_commande'] ?>">détails</button>
                            <?php $peutModifier = $commande['statut_actuel'] === 'En attente de validation'; ?>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal-modifier-<?= $commande['Id_commande'] ?>" <?= !$peutModifier ? 'disabled' : '' ?>>modifier</button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-annuler-<?= $commande['Id_commande'] ?>" <?= !$peutModifier ? 'disabled' : '' ?>>annuler</button>
                        </div>
                    </td>
                    <?php $peutDonnerAvis = $commande['statut_actuel'] === 'Terminé' && $commande['avis_depose'] == 0; ?>
                    <td>
                        <button class="btn btn-sm btn-success" <?= !$peutDonnerAvis ? 'disabled' : '' ?> data-bs-toggle="modal" data-bs-target="#modal-avis-<?= $commande['Id_commande'] ?>">déposer un avis</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal des détails de la commande -->
    <?php foreach ($commandes as $commande): ?>
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

        <!-- Modal d'annulation de la commande -->
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
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                            <input type="hidden" name="id_commande" value="<?= $commande['Id_commande'] ?>">
                            <button type="submit" class="btn btn-danger">confirmer l'annulation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de modification de la commande -->
        <div class="modal fade" id="modal-modifier-<?= $commande['Id_commande'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier la commande: <?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-modifier-<?= $commande['Id_commande'] ?>" action="/mon-espace/commandes/modifier" method="post">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

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
                                <input class="form-control" type="text" id="adresse_liv" name="adresse_liv" value="<?= htmlspecialchars($commande['adresse_livraison'] ?? '') ?>">
                            </div>

                            <div class="livraison livraison-param text-start mb-4">
                                <label class="mb-1 d-block" for="codePostal">Code postal</label>
                                <input class="form-control" type="text" id="codePostal_liv" name="codePostal_liv" value="<?= htmlspecialchars($commande['code_postal_livraison'] ?? '') ?>">
                            </div>

                            <div class="livraison livraison-param text-start mb-4">
                                <label class="mb-1 d-block" for="ville_liv">Ville</label>
                                <input class="form-control" type="text" id="ville_liv" name="ville_liv" value="<?= htmlspecialchars($commande['ville_livraison'] ?? '') ?>">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">annuler</button>
                        <button type="submit" form="form-modifier-<?= $commande['Id_commande'] ?>" class="btn btn-primary">enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal du suivi de la commande -->
        <div class="modal modal-lg" id="modal-suivi-<?= $commande['Id_commande'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Suivi de commande: <?= 'VG-' . date('Ymd', strtotime($commande['date_commande'])) . '-' . sprintf('%04d', $commande['Id_commande']) ?> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <?php $statutsAtteints = array_column($commande['historique'], 'statut_libelle'); ?>
                        <div class="progress-stacked">
                            <?php
                            $statuts = [
                                'En attente de validation' => 'bg-warning',
                                'Accepté' => 'bg-success',
                                'En préparation' => 'bg-info',
                                'En cours de livraison' => 'bg-info',
                                'Livré' => 'bg-primary',
                                'En attente du retour matériel' => 'bg-warning',
                                'Terminé' => 'bg-success',
                            ];
                            foreach ($statuts as $libelle => $couleur):
                                $estAtteint = in_array($libelle, $statutsAtteints);
                            ?>
                                <div class="progress" style="width: 14.28%" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="<?= $libelle ?>">
                                    <div class="progress-bar <?= $estAtteint ? $couleur : 'bg-secondary' ?>"></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Tableau de l'historique des changements de statut avec dates -->
                        <table class="table mt-3">
                            <?php foreach ($commande['historique'] as $statut): ?>
                                <tr>
                                    <td><?= htmlspecialchars($statut['statut_libelle']) ?></td>
                                    <td><?= $statut['date_changement'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de dépot de l'avis -->
        <div class="modal fade" id="modal-avis-<?= $commande['Id_commande'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Déposer un avis</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-avis-<?= $commande['Id_commande'] ?>" action="/mon-espace/avis" method="post">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="id_commande" value="<?= $commande['Id_commande'] ?>">
                            <div class="mb-3">
                                <label class="mb-1 d-block" for="prenom_avis">Prénom</label>
                                <input class="form-control" type="text" id="prenom_avis" name="prenom" value="<?= htmlspecialchars($_SESSION['prenom']) ?>" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="mb-1 d-block" for="note">Note (1 à 5)</label>
                                <input class="form-control" type="number" id="note" name="note" min="1" max="5" required>
                            </div>

                            <div class="mb-3">
                                <label class="mb-1 d-block" for="commentaire">Commentaire</label>
                                <textarea class="form-control" id="commentaire" name="commentaire" rows="4" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" form="form-avis-<?= $commande['Id_commande'] ?>">envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once('../src/views/layouts/footer.php'); ?>