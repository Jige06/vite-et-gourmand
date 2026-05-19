<?php require_once('../src/views/layouts/header.php'); ?>
<?php require_once('../src/views/layouts/nav-admin.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Statistiques</h1>

    <!-- Graphique du nombre de commandes par menu -->
    <div class="mb-5">
        <h3 class="text-center">Nombre de commandes par menu</h3>
        <canvas id="graphiqueCommandes"></canvas>
    </div>

    <!-- Graphique du chiffre d'affaires par menu -->
    <div class="mb-5">
        <h3 class="text-center">Chiffre d'affaires par menu</h3>
        <canvas id="graphiqueCA"></canvas>
    </div>
</div>


<!-- passage des données PHP→JS -->
<script>
    const stats = <?= json_encode($stats) ?>;
</script>

<?php require_once('../src/views/layouts/footer.php'); ?>