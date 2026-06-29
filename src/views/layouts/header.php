<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Balises meta og -->
    <meta property="og:title" content="Vite & Gourmand — Traiteur à Bordeaux">
    <meta property="og:description" content="Découvrez nos menus de traiteur et commandez en ligne. Julie et José vous proposent une cuisine authentique depuis 25 ans à Bordeaux.">
    <meta property="og:image" content="https://vite-et-gourmand.fr/assets/images/V&G.png">
    <meta property="og:url" content="https://vite-et-gourmand.fr">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="Vite & Gourmand">
    <!-- Balises meta SEO -->
    <meta name="description" content="Vite & Gourmand, traiteur à Bordeaux depuis 25 ans. Découvrez nos menus et commandez en ligne pour tous vos événements festifs et professionnels.">
    <meta name="keywords" content="traiteur bordeaux, menu traiteur, commande repas bordeaux, cuisine événementielle, traiteur événement, Julie José Bordeaux">
    <meta name="author" content="Vite & Gourmand">
    <meta name="robots" content="index, follow">
    <?php
    $urlCanonique = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
    <link rel="canonical" href="<?= htmlspecialchars($urlCanonique) ?>">
    <!-- Balise link favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon-512.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>Vite & Gourmand</title>
    <script src="/assets/js/app.js" defer></script>
    <script src="/assets/js/validation.js" defer></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Vite & Gourmand</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/">accueil</a></li>
                        <li class="nav-item"><a class="nav-link" href="/menus">nos menus</a></li>
                        <li class="nav-item"><a class="nav-link" href="/avis">les avis</a></li>
                        <?php if (!isset($_SESSION['role']) || $_SESSION['role'] === 'Utilisateur'): ?>
                            <li class="nav-item"><a class="nav-link" href="/contact">contact</a></li>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['id_user'])): ?>
                            <li class="nav-item">
                                <span class="nav-link"><?= htmlspecialchars($_SESSION['prenom']) . ' ' . htmlspecialchars($_SESSION['nom']) ?></span>
                            </li>

                            <?php if ($_SESSION['role'] === 'Administrateur'): ?>
                                <li class="nav-item"><a class="nav-link" href="/admin">espace admin</a></li>
                                <li class="nav-item"><a class="nav-link" href="/employe">espace employé</a></li>
                            <?php elseif ($_SESSION['role'] === 'Employé'): ?>
                                <li class="nav-item"><a class="nav-link" href="/employe">espace employé</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link" href="/mon-espace/commandes">mon espace</a></li>
                            <?php endif; ?>

                            <li class="nav-item"><a class="nav-link" href="/logout">déconnexion</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="/connexion">connexion</a></li>
                            <li class="nav-item"><a class="nav-link" href="/inscription">s'inscrire</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>