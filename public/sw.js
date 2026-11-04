/**
 * Service worker de Vite & Gourmand
 *
 * Il s'intercale entre le navigateur et le serveur pour chaque requête
 * du site, et décide d'où vient la réponse : du réseau, du cache, ou des deux.
 *
 * Placé à la racine de public/, il contrôle tout le site (portée « / »).
 *
 * Stratégies utilisées :
 *  - Pages publiques (accueil, menus, détail d'un menu, avis, CGV, mentions) :
 *    RÉSEAU D'ABORD. On affiche toujours la version à jour ; la copie en cache
 *    ne sert que si le réseau est indisponible.
 *  - Pages privées (espaces client, employé, admin, connexion, commande…) :
 *    RÉSEAU UNIQUEMENT. Jamais mises en cache : elles contiennent des données
 *    personnelles et des jetons CSRF qui ne doivent pas être rejoués.
 *  - CSS et JS du site, bibliothèques des CDN (Bootstrap, Chart.js, polices) :
 *    PÉRIMÉ PENDANT LA REVALIDATION (stale-while-revalidate). Affichage
 *    immédiat depuis le cache, mise à jour en arrière-plan pour la visite suivante.
 *  - Images : CACHE D'ABORD. Une image ne change pas, inutile de la retélécharger.
 *  - Requêtes POST et appels fetch (filtres, calcul des frais) : pas
 *    d'interception, le navigateur les traite normalement.
 */

// Changer ce numéro force le nettoyage de tous les anciens caches.
// À incrémenter quand on modifie ce fichier ou la liste des fichiers préchargés.
const VERSION = 'v1';

const CACHE_STATIQUE = `vg-statique-${VERSION}`;
const CACHE_PAGES = `vg-pages-${VERSION}`;
const CACHE_IMAGES = `vg-images-${VERSION}`;
const CACHE_CDN = `vg-cdn-${VERSION}`;
const CACHES_ACTUELS = [CACHE_STATIQUE, CACHE_PAGES, CACHE_IMAGES, CACHE_CDN];

// Fichiers téléchargés dès l'installation, pour que la page hors-ligne
// et l'habillage du site soient disponibles même à la toute première coupure.
const FICHIERS_A_PRECHARGER = [
    '/offline.html',
    '/assets/css/style.css',
    '/assets/js/app.js',
    '/assets/js/validation.js',
    '/assets/js/pwa.js',
    '/assets/icons/icon-192.png',
    '/favicon-512.png',
    '/manifest.webmanifest'
];

// Seules ces pages peuvent être gardées pour une consultation hors ligne.
// Liste « autorisée » plutôt que « interdite » : une nouvelle route privée
// ajoutée plus tard ne sera jamais mise en cache par erreur.
const PAGES_PUBLIQUES = ['/', '/menus', '/menus/detail', '/avis', '/cgv', '/mentions-legales'];

// Domaines externes dont on accepte de garder les fichiers
const HOTES_CDN = ['cdn.jsdelivr.net', 'fonts.googleapis.com', 'fonts.gstatic.com'];

// Limites pour éviter que le cache grossisse sans fin sur le téléphone
const MAX_PAGES = 30;
const MAX_IMAGES = 80;


/* ============================================================
   CYCLE DE VIE
   ============================================================ */

// Installation : on précharge les fichiers indispensables
self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_STATIQUE)
            .then(function (cache) {
                return cache.addAll(FICHIERS_A_PRECHARGER);
            })
            // Le nouveau service worker remplace l'ancien sans attendre
            // la fermeture de tous les onglets
            .then(function () {
                return self.skipWaiting();
            })
    );
});

// Activation : on supprime les caches des versions précédentes
self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys()
            .then(function (noms) {
                const anciens = noms.filter(function (nom) {
                    return nom.startsWith('vg-') && !CACHES_ACTUELS.includes(nom);
                });
                return Promise.all(anciens.map(function (nom) {
                    return caches.delete(nom);
                }));
            })
            // Prend le contrôle des onglets déjà ouverts
            .then(function () {
                return self.clients.claim();
            })
    );
});


/* ============================================================
   AIGUILLAGE DES REQUÊTES
   ============================================================ */

self.addEventListener('fetch', function (event) {
    const requete = event.request;
    const url = new URL(requete.url);

    // Connexion (formulaire POST) : on vide les pages en cache, car elles
    // contiennent la barre de navigation d'un éventuel utilisateur précédent.
    // On ne répond pas à la place du navigateur : la requête part normalement.
    if (requete.method === 'POST' && url.pathname === '/connexion') {
        event.waitUntil(caches.delete(CACHE_PAGES));
        return;
    }

    // Tout ce qui n'est pas une lecture (POST…) est laissé au navigateur
    if (requete.method !== 'GET') {
        return;
    }

    // Bibliothèques externes (Bootstrap, Chart.js, Google Fonts)
    if (HOTES_CDN.includes(url.hostname)) {
        event.respondWith(perimePendantRevalidation(event, CACHE_CDN));
        return;
    }

    // Les autres domaines (API OpenRouteService…) ne sont pas interceptés
    if (url.origin !== self.location.origin) {
        return;
    }

    // Navigation vers une page (clic sur un lien, saisie d'URL, rechargement)
    if (requete.mode === 'navigate') {
        if (url.pathname === '/logout') {
            event.respondWith(deconnexion(requete));
        } else if (PAGES_PUBLIQUES.includes(url.pathname)) {
            event.respondWith(reseauDabord(requete));
        } else {
            event.respondWith(reseauUniquement(requete));
        }
        return;
    }

    // Images du site (menus, plats, icônes)
    if (url.pathname.startsWith('/assets/images/') || url.pathname.startsWith('/assets/icons/')) {
        event.respondWith(cacheDabord(requete, CACHE_IMAGES, MAX_IMAGES));
        return;
    }

    // Feuilles de style et scripts du site
    if (url.pathname.startsWith('/assets/css/') || url.pathname.startsWith('/assets/js/')) {
        event.respondWith(perimePendantRevalidation(event, CACHE_STATIQUE));
        return;
    }

    // Le reste (appels fetch JSON, sitemap…) n'est pas intercepté
});


/* ============================================================
   STRATÉGIES
   ============================================================ */

/**
 * Réseau d'abord : version à jour si possible, sinon copie en cache,
 * sinon page hors-ligne.
 */
async function reseauDabord(requete) {
    const cache = await caches.open(CACHE_PAGES);

    try {
        const reponse = await fetch(requete);

        // On ne garde que les vraies pages (pas les erreurs ni les redirections,
        // par exemple /menus/detail?id=999 qui renvoie vers /menus)
        if (reponse.ok && reponse.type === 'basic') {
            await cache.put(requete, reponse.clone());
            limiterTailleCache(CACHE_PAGES, MAX_PAGES);
        }
        return reponse;
    } catch (erreur) {
        const copie = await cache.match(requete);
        return copie || pageHorsLigne();
    }
}

/**
 * Réseau uniquement : rien n'est stocké. En cas de coupure,
 * on affiche la page hors-ligne plutôt que l'erreur du navigateur.
 */
async function reseauUniquement(requete) {
    try {
        return await fetch(requete);
    } catch (erreur) {
        return pageHorsLigne();
    }
}

/**
 * Cache d'abord : si le fichier est déjà en cache, on le sert directement ;
 * sinon on le télécharge et on le garde pour la prochaine fois.
 */
async function cacheDabord(requete, nomCache, tailleMax) {
    // caches.match cherche dans tous les caches : une icône préchargée
    // à l'installation (cache statique) est donc trouvée elle aussi
    const copie = await caches.match(requete);
    if (copie) {
        return copie;
    }

    const cache = await caches.open(nomCache);
    try {
        const reponse = await fetch(requete);
        if (reponse.ok) {
            await cache.put(requete, reponse.clone());
            limiterTailleCache(nomCache, tailleMax);
        }
        return reponse;
    } catch (erreur) {
        // Image introuvable hors ligne : réponse vide plutôt qu'une erreur
        return new Response('', { status: 503, statusText: 'Hors ligne' });
    }
}

/**
 * Périmé pendant la revalidation : on répond tout de suite avec la copie
 * en cache (affichage rapide), et en parallèle on télécharge la dernière
 * version pour mettre le cache à jour.
 * Une modification du CSS ou du JS apparaît donc au chargement suivant.
 */
async function perimePendantRevalidation(event, nomCache) {
    const requete = event.request;
    const cache = await caches.open(nomCache);
    const copie = await cache.match(requete);

    const telechargement = fetch(requete)
        .then(function (reponse) {
            // type « opaque » : fichier d'un autre domaine chargé sans CORS
            // (c'est le cas de Chart.js). Son contenu est illisible pour nous
            // mais le navigateur peut quand même l'utiliser.
            if (reponse.ok || reponse.type === 'opaque') {
                return cache.put(requete, reponse.clone()).then(function () {
                    return reponse;
                });
            }
            return reponse;
        })
        .catch(function () {
            return copie || new Response('', { status: 503, statusText: 'Hors ligne' });
        });

    // Garde le service worker éveillé jusqu'à la fin de la mise à jour du cache,
    // même si on a déjà répondu avec la copie
    event.waitUntil(telechargement);

    return copie || telechargement;
}

/**
 * Déconnexion : on vide les pages en cache (elles affichent le nom de
 * l'utilisateur dans la navbar), puis on laisse le serveur fermer la session.
 */
async function deconnexion(requete) {
    await caches.delete(CACHE_PAGES);
    return reseauUniquement(requete);
}


/* ============================================================
   OUTILS
   ============================================================ */

function pageHorsLigne() {
    return caches.match('/offline.html');
}

/**
 * Supprime les entrées les plus anciennes au-delà de la taille maximale.
 * cache.keys() renvoie les entrées dans leur ordre d'ajout.
 */
async function limiterTailleCache(nomCache, tailleMax) {
    const cache = await caches.open(nomCache);
    const cles = await cache.keys();
    for (let i = 0; i < cles.length - tailleMax; i++) {
        await cache.delete(cles[i]);
    }
}
