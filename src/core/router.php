<?php

/* Implémentation du router qui va permettre de diriger vers le bon controller en fonction de l'URL */

class Router
{
    private $routes = [];

    // Ajoute une route dans le tableau des routes
    public function add($url, $action)
    {
        $this->routes[$url] = $action;
    }
    // Lit l'URL actuelle et appelle le bon controller
    public function dispatch()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim($path, "/");

        try {
            if (!isset($this->routes[$path])) {
                http_response_code(404);
                die("Page non trouvée");
            }
            $action = $this->routes[$path];
            call_user_func($action);
        } catch (\Throwable $th) {
            http_response_code(500);
            die("Erreur serveur : " . $th->getMessage());
        }
    }
}
