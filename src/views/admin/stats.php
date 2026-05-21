<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-admin.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Statistiques</h1>

    <!-- Formulaire de filtres -->
    <form method="GET" action="/admin/stats" class="card p-4 mb-5 shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="menu" class="form-label fw-bold">Filtrer par menu</label>
                <select name="menu" id="menu" class="form-select">
                    <option value="">Tous les menus</option>
                    <?php foreach ($menus as $m) : ?>
                        <option value="<?= htmlspecialchars($m) ?>" <?= $menuFiltre === $m ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="date_debut" class="form-label fw-bold">Date début</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control"
                    value="<?= htmlspecialchars($dateDebut ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label for="date_fin" class="form-label fw-bold">Date fin</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control"
                    value="<?= htmlspecialchars($dateFin ?? '') ?>">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">filtrer</button>
                <a href="/admin/stats" class="btn btn-outline-secondary w-100">reset</a>
            </div>
        </div>
    </form>

    <?php if (empty($stats)) : ?>
        <div class="alert alert-info text-center">
            Aucune statistique disponible pour ces critères.
        </div>
    <?php else : ?>
        <!-- Graphique du nombre de commandes par menu -->
        <div class="mb-5">
            <h2 class="text-center">Nombre de commandes par menu</h2>
            <canvas id="graphiqueCommandes"></canvas>
        </div>

        <!-- Graphique du chiffre d'affaires par menu -->
        <div class="mb-5">
            <h2 class="text-center">Chiffre d'affaires par menu</h2>
            <canvas id="graphiqueCA"></canvas>
        </div>
    <?php endif; ?>
</div>

<!-- passage des données PHP→JS -->
<script>
    const stats = <?= json_encode(array_values($stats)) ?>;
</script>

<?php require_once('../src/views/layouts/footer.php'); ?>