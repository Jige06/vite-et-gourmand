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
$router->add('/', [HomeController::class,'index']);
$router->add('/menus', []);
$router->add('/menus/detail', []);
$router->add('/connexion', [AuthController::class,'handleLogin']);
$router->add('/logout', [AuthController::class, 'logout']);
$router->add('/inscription', [AuthController::class,'handleSignUp']);
$router->add('/mot-de-passe-oublie', [AuthController::class,'handleResetPassword']);
$router->add('/contact', []);
$router->add('/avis', []);
$router->add('/commande', []);
$router->add('/mon-espace', []);
$router->add('/mon-espace/commandes', []);
$router->add('/mon-espace/avis', []);
$router->add('/employe', []);
$router->add('/admin', []);

$router->dispatch();
