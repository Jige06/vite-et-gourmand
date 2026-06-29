<?php

class SitemapController
{
    // Méthode qui génère dynamiquement le sitemap.xml à partir des menus existants
    public function generate()
    {
        $urlBase = 'https://vite-et-gourmand.fr';

        $pagesStatiques = [
            '/',
            '/menus',
            '/contact',
            '/avis',
        ];
        
        $menus = MenuRepository::getAllMenu();

        header('Content-Type: application/xml; charset=utf-8');

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($pagesStatiques as $page) {
            echo '<url><loc>' . $urlBase . $page . '</loc></url>';
        }

        foreach ($menus as $menu) {
            echo '<url><loc>' . $urlBase . '/menus/detail?id=' . $menu['Id_menu'] . '</loc></url>';
        }

        echo '</urlset>';
    }
}
