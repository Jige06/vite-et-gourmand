/**
 * PWA : enregistrement du service worker et bouton d'installation
 */

// 1. Enregistrement du service worker
// On attend la fin du chargement de la page pour ne pas ralentir
// le premier affichage avec le préchargement du cache.
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js')
            .catch(function (erreur) {
                console.error('Service worker non enregistré :', erreur);
            });
    });
}

// 2. Bouton « installer l'appli » dans la navbar
// Chrome, Edge et Samsung Internet déclenchent l'événement beforeinstallprompt
// quand le site est installable. On le met de côté pour l'utiliser au clic.
// Safari (iPhone) ne le déclenche pas : le bouton reste caché et l'installation
// se fait via le menu Partager → « Sur l'écran d'accueil ».
let invitationInstallation = null;

window.addEventListener('beforeinstallprompt', function (event) {
    // Empêche le bandeau automatique du navigateur
    event.preventDefault();
    invitationInstallation = event;

    const bouton = document.getElementById('bouton-installer');
    if (bouton) {
        bouton.parentElement.hidden = false;
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const bouton = document.getElementById('bouton-installer');
    if (!bouton) {
        return;
    }

    bouton.addEventListener('click', async function () {
        if (!invitationInstallation) {
            return;
        }
        // Affiche la fenêtre d'installation du navigateur
        invitationInstallation.prompt();
        await invitationInstallation.userChoice;
        // L'invitation ne peut servir qu'une fois
        invitationInstallation = null;
        bouton.parentElement.hidden = true;
    });
});

// Une fois l'appli installée, on masque le bouton définitivement
window.addEventListener('appinstalled', function () {
    const bouton = document.getElementById('bouton-installer');
    if (bouton) {
        bouton.parentElement.hidden = true;
    }
});
