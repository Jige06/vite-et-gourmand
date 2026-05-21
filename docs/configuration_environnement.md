# Configuration de l'environnement de travail — Vite & Gourmand

## Visual Studio Code

J'ai utilisé **Visual Studio Code** comme éditeur de code. Deux extensions PHP ont été installées :

- **PHP Intelephense** — apporte l'autocomplétion du code PHP, la navigation vers les définitions de fonctions et de classes, ainsi que la détection d'erreurs en temps réel
- **PHP Getters and Setters** — génère automatiquement les getters et setters pour les propriétés des classes, cohérent avec l'approche orientée objet du projet

---

## Git et GitHub

Un dépôt Git local a été initialisé dès le début du projet, puis un dépôt distant public a été créé sur GitHub. Une stratégie de branches a été mise en place (voir documentation gestion de projet) :

- `main` — branche principale pour la production
- `develop` — branche d'intégration (branche par défaut)
- `feature/*` — une branche par fonctionnalité, mergée dans `develop` après test

---

## Base de données MySQL

La base de données a été créée et gérée via **PHPMyAdmin** au départ (XAMPP) puis via **HeidiSQL** avec Laragon. Deux fichiers SQL ont été rédigés :

- `database/create_bdd.sql` — création de la structure de la base de données
- `database/data.sql` — insertion des données de test

---

## Environnement local : XAMPP puis Laragon

Le projet a débuté avec **XAMPP** comme serveur local. Des problèmes récurrents ont été rencontrés : MySQL se coupait aléatoirement et suite à une réinstallation complète, Apache ne chargeait plus le site correctement. Face à ces blocages, la décision a été prise de migrer vers **Laragon**.

Laragon est plus stable et plus simple à configurer sous Windows. Il crée automatiquement le Virtual Host dès que le projet est placé dans le dossier `www`, sans configuration manuelle, permettant de travailler directement sur l'URL `http://vite-et-gourmand.test`.

---

## Composer

**Composer** a été installé pour gérer les dépendances PHP du projet. Il a permis d'installer :

- **PHPMailer** — pour l'envoi de mails
- **Driver officiel MongoDB pour PHP** — pour la connexion à MongoDB

L'autoload de Composer permet de charger automatiquement toutes les classes du projet sans `require_once` manuel.

---

## Mailtrap

Un compte a été créé sur **Mailtrap.io** et configuré comme serveur SMTP de test. Il intercepte tous les emails envoyés par l'application en développement sans les délivrer réellement, permettant de tester les fonctionnalités d'envoi de mail en toute sécurité.

Les identifiants SMTP sont stockés dans le fichier `.env` (non versionné sur GitHub).

---

## API OpenRouteService

Un compte a été créé sur **OpenRouteService** afin d'obtenir une clé API. Cette clé a été intégrée dans le code pour permettre le calcul automatique de la distance entre l'adresse de livraison du client et l'adresse de Vite & Gourmand, utilisée pour le calcul des frais de livraison.

---

## MongoDB

MongoDB a été installé séparément de Laragon. En local, il doit être lancé manuellement via la commande :

```bash
mongod --dbpath "chemin/vers/votre/dossier/data"
```

Il est utilisé pour stocker et lire les données statistiques de l'application (nombre de commandes et chiffre d'affaires par menu).

---

## Docker

Un **Dockerfile** a été créé à la racine du projet pour conteneuriser l'application en vue du déploiement. Il définit l'environnement d'exécution (version PHP, extensions nécessaires, configuration Apache), garantissant que l'application fonctionne de manière identique quel que soit l'environnement cible.

---

## Trello

**Trello** a été utilisé pour organiser et suivre l'avancement des tâches sous forme de tableau Kanban (voir documentation gestion de projet).
