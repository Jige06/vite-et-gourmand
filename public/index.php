<?php

// Demarrage de la session utilisateur
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement
$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    $_ENV[$key] = $value;
}

// Chargement des classes par autoload
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/../src/core/' . $class . '.php')) {
        require_once __DIR__ . '/../src/core/' . $class . '.php';
    }
    if (file_exists(__DIR__ . '/../src/entities/' . $class . '.php')) {
        require_once __DIR__ . '/../src/entities/' . $class . '.php';
    }
    if (file_exists(__DIR__ . '/../src/controllers/' . $class . '.php')) {
        require_once __DIR__ . '/../src/controllers/' . $class . '.php';
    }
    if (file_exists(__DIR__ . '/../src/models/' . $class . '.php')) {
        require_once __DIR__ . '/../src/models/' . $class . '.php';
    }
});

// Définition des routes
$router = new Router();
$router->add('/', [HomeController::class, 'index']);
$router->add('/menus', [MenuController::class, 'index']);
$router->add('/menus/detail', [MenuController::class, 'showDetails']);
$router->add('/menus/filter', [MenuController::class, 'filter']);
$router->add('/connexion', [AuthController::class, 'handleLogin']);
$router->add('/logout', [AuthController::class, 'logout']);
$router->add('/inscription', [AuthController::class, 'handleSignUp']);
$router->add('/mot-de-passe-oublie', [AuthController::class, 'handleResetPassword']);
$router->add('/contact', [ContactController::class, 'handleContact']);
$router->add('/avis', [AvisController::class, 'index']);
$router->add('/commande', [OrderController::class, 'handleOrder']);
$router->add('/mon-espace', []);
$router->add('/mon-espace/commandes', [OrderController::class, 'showUserOrders']);
$router->add('/mon-espace/commandes/modifier', [OrderController::class, 'updateOrder']);
$router->add('/mon-espace/commandes/annuler', [OrderController::class, 'deleteOrder']);
$router->add('/mon-espace/avis', [OrderController::class, 'LeaveReview']);
$router->add('/mon-espace/profil', [UserController::class, 'updateProfil']);
$router->add('/employe', [EmployeController::class, 'showOrders']);
$router->add('/employe/statut', [EmployeController::class, 'handleUpdateStatus']);
$router->add('/employe/menus', [EmployeController::class, 'handleMenus']);
$router->add('/employe/plats', [EmployeController::class, 'handlePlats']);
$router->add('/employe/avis', [EmployeController::class, 'handleReviews']);
$router->add('/admin', [AdminController::class, 'handleNewEmploye']);
$router->add('/admin/stats', [AdminController::class, 'handleStats']);
$router->add('/cgv', [LegalController::class, 'showCgv']);
$router->add('/mentions-legales', [LegalController::class, 'showMentionsLegales']);

$router->dispatch();
