# Application installable (PWA)

Vite & Gourmand est une **Progressive Web App** : le site peut être installé sur l'écran d'accueil d'un téléphone ou d'un ordinateur, s'ouvre dans sa propre fenêtre et reste partiellement consultable sans connexion.

Le back-end PHP n'a pas changé : la PWA est une couche ajoutée côté navigateur.

## Fichiers concernés

| Fichier | Rôle |
|---|---|
| `public/manifest.webmanifest` | Carte d'identité de l'appli : nom (« Vite et Gourmand » / « V&G »), icônes, couleurs, page de démarrage, raccourcis |
| `public/sw.js` | Service worker : intercepte les requêtes et gère le cache |
| `public/offline.html` | Page affichée quand une page n'est pas disponible hors ligne. Elle liste les pages déjà en cache |
| `public/assets/js/pwa.js` | Enregistre le service worker et gère le bouton « installer l'appli » |
| `public/assets/icons/` | Icônes 192 et 512 px, icône « maskable » pour Android, icône Apple 180 px |
| `src/views/layouts/header.php` | Liens vers le manifest, `theme-color`, icône Apple, script `pwa.js`, bouton d'installation |
| `public/.htaccess` | Type MIME du manifest, et désactivation du cache HTTP pour `sw.js` |
| `Dockerfile` | Activation du module Apache `headers` (nécessaire au `.htaccess`) |

`sw.js` est placé à la racine de `public/` : un service worker ne contrôle que les URL situées à son niveau ou en dessous. À la racine, il couvre tout le site.

## Stratégies de cache

| Type de requête | Stratégie | Pourquoi |
|---|---|---|
| Pages publiques : `/`, `/menus`, `/menus/detail`, `/avis`, `/cgv`, `/mentions-legales` | Réseau d'abord, copie en cache en secours | Toujours à jour en ligne, consultables hors ligne une fois visitées |
| Toutes les autres pages : espaces client, employé et admin, connexion, commande, contact… | Réseau uniquement | Données personnelles et jetons CSRF : ne doivent jamais être stockés |
| CSS et JS du site, CDN (Bootstrap, Chart.js, Google Fonts) | Périmé pendant la revalidation | Affichage immédiat ; la nouvelle version est récupérée en arrière-plan |
| Images (`/assets/images/`, `/assets/icons/`) | Cache d'abord | Une image ne change pas |
| POST et appels `fetch` (filtres des menus, calcul des frais, API OpenRouteService) | Non interceptés | Comportement normal du navigateur |

La liste des pages publiques est une **liste autorisée** : une nouvelle route ajoutée plus tard n'est jamais mise en cache, sauf si on l'ajoute explicitement à `PAGES_PUBLIQUES` dans `sw.js`.

Les caches sont limités à 30 pages et 80 images ; les entrées les plus anciennes sont supprimées au-delà.

## Session et confidentialité

Les pages en cache contiennent la barre de navigation, donc le nom de l'utilisateur connecté. Pour éviter qu'il reste sur l'appareil, le service worker vide le cache des pages :

- lors de la connexion (POST sur `/connexion`) ;
- lors de la déconnexion (`/logout`).

## Mettre à jour le service worker

- **CSS ou JS modifié** : rien à faire. La nouvelle version s'affiche au chargement suivant.
- **`sw.js` modifié, ou liste des fichiers préchargés changée** : incrémenter `VERSION` en haut de `sw.js` (`'v1'` → `'v2'`). Le navigateur installe le nouveau service worker et supprime les anciens caches.

## Tester

Le service worker ne fonctionne qu'en **HTTPS**, ou sur `localhost` en développement.

- Docker : `http://localhost:8080` fonctionne directement.
- Laragon : un domaine `http://….test` ne suffit pas. Activer le SSL de Laragon (menu Apache → SSL → Enabled) et utiliser `https://….test`, ou passer par `http://localhost`.
- Production : Railway fournit le HTTPS automatiquement.

Dans Chrome, ouvrir les DevTools :

1. Onglet **Application → Manifest** : vérifier le nom, les icônes et l'absence d'erreur.
2. Onglet **Application → Service workers** : le service worker doit être « activated and is running ». La case « Update on reload » est pratique pendant le développement.
3. Onglet **Application → Cache storage** : on voit les caches `vg-statique`, `vg-pages`, `vg-images` et `vg-cdn` se remplir au fil de la navigation.
4. Onglet **Network** → menu « No throttling » → **Offline** : naviguer vers une page déjà visitée (elle s'affiche), puis vers une page jamais visitée (page hors-ligne).
5. Onglet **Lighthouse** : un audit vérifie que l'appli est installable.

## Installer l'appli

- **Android, Chrome sur ordinateur, Edge** : bouton « installer l'appli » dans la navbar, ou icône d'installation dans la barre d'adresse.
- **iPhone (Safari)** : bouton Partager → « Sur l'écran d'accueil ». Safari ne permet pas d'afficher un bouton d'installation dans la page.
