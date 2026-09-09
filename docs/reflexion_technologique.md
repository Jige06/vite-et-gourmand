# Réflexion technologique — Vite & Gourmand

## Introduction

Avant de démarrer le développement, j'ai analysé le cahier des charges pour choisir les technologies les plus adaptées au projet. L'objectif était de construire une application web complète, sécurisée et déployable, en utilisant des technologies maîtrisées et justifiées.

---

## Choix techniques

### Langage back-end : PHP natif

J'ai choisi d'utiliser PHP natif sans framework afin de maîtriser les mécanismes fondamentaux du développement web côté serveur. L'utilisation d'un framework comme Symfony ou Laravel n'aurait pas montré la logique sous-jacente dans un tel projet. J'ai ainsi pu construire moi-même l'architecture MVC, le routage et les accès aux données, ce qui représente un apprentissage bien plus complet.

### Paradigme : Programmation Orientée Objet (POO)

Tout le back-end a été développé en suivant les principes de la programmation orientée objet (POO). Chaque couche de l'architecture MVC est représentée par des classes : les models gèrent l'accès aux données via PDO, les controllers traitent la logique métier. Des classes entités représentant les objets du domaine (Utilisateur, Commande, Menu, Plat...) ont également été créées pour démontrer la compréhension du concept objet et de la modélisation. Le design pattern Singleton a été appliqué pour les connexions aux bases de données (DatabaseConnection et MongoDBRepository), garantissant une instance unique tout au long du cycle de vie de l'application.

### Architecture : MVC (Model - View - Controller)

L'architecture MVC permet de séparer distinctement les responsabilités : la logique métier dans les models, le traitement des requêtes dans les controllers, et l'affichage dans les views. Cette séparation rend le code plus lisible, plus maintenable et plus facile à faire évoluer.

### Accès aux données : PDO (PHP Data Objects)

PDO est l'extension recommandée pour interagir avec une base de données en PHP. En utilisant des requêtes préparées, on se protège efficacement contre les injections SQL. Elle offre également une abstraction de la base de données, facilitant un éventuel changement de SGBD.

### Base de données relationnelle : MySQL

MySQL est un système de gestion de base de données (SGBD) open source, largement utilisé dans le développement web. Il est parfaitement adapté pour stocker et gérer les données structurées de l'application (utilisateurs, commandes, menus, plats, avis...).

### Base de données non relationnelle : MongoDB

Exigé dans le cahier des charges, MongoDB a été choisi pour stocker les données statistiques de l'application. Son modèle de documents JSON est particulièrement adapté à l'agrégation et à la lecture rapide de données statistiques.

### Front-end : HTML5, CSS3, Bootstrap 5.3, JavaScript vanilla

HTML5 et CSS3 forment la base de l'interface web. Bootstrap 5.3 a été utilisé pour accélérer l'intégration et garantir un design responsive. Du CSS personnalisé a été ajouté pour respecter la charte graphique du client (couleurs et polices). JavaScript vanilla a été privilégié pour les interactions dynamiques (filtres, formulaire de commande multi-étapes, modals) afin d'éviter l'ajout d'une dépendance inutile.

### Graphiques : Chart.js

Chart.js est une bibliothèque JavaScript légère et simple à intégrer, permettant de générer des graphiques interactifs. Elle a été utilisée pour afficher les statistiques de commandes et de chiffre d'affaires dans l'espace administrateur.

### Envoi de mails : PHPMailer

PHPMailer est la bibliothèque PHP de référence pour l'envoi d'emails. Elle supporte le protocole SMTP et permet d'envoyer des mails HTML personnalisés de façon fiable et sécurisée.

### Tests d'envoi de mails : Mailtrap

Mailtrap est un service de boîte mail fictive utilisé en développement pour intercepter les emails envoyés par l'application sans les délivrer réellement, permettant de tester les fonctionnalités d'envoi de mail en toute sécurité.

### API externe : OpenRouteService

Cette API a été intégrée pour calculer la distance entre l'adresse de livraison du client et l'adresse de Vite & Gourmand, afin de déterminer automatiquement les frais de livraison.

### Gestion des dépendances : Composer

Composer est le gestionnaire de dépendances standard de PHP. Il a été utilisé pour installer et autocharger les bibliothèques tierces (PHPMailer, driver MongoDB).

### Conteneurisation : Docker

Docker a été utilisé pour conteneuriser l'application en vue de son déploiement. Un Dockerfile a été créé pour définir l'environnement d'exécution (version PHP, extensions nécessaires, configuration Apache). L'utilisation de Docker garantit que l'application s'exécute de manière identique quel que soit l'environnement cible.

### Déploiement : Railway

Railway est une plateforme de déploiement cloud qui supporte PHP, MySQL et MongoDB. Le déploiement y est rapide depuis un dépôt GitHub et elle propose un environnement de production proche de l'environnement local.

### Versioning : Git & GitHub

Git a été utilisé pour versionner le code avec une stratégie de branches (voir documentation gestion de projet). GitHub a servi de dépôt distant public.

### Gestion de projet : Trello

Trello a été utilisé pour organiser et suivre l'avancement des tâches sous forme de tableau Kanban.

### Éditeur de code : Visual Studio Code

VS Code est un éditeur open source léger et extensible. Les extensions PHP Intelephense et PHP Getters and Setters ont facilité le développement.

---

## Alternatives envisagées

| Technologie choisie | Alternative envisagée | Raison du choix |
|--------------------|-----------------------|-----------------|
| PHP natif | Symfony / Laravel | Maîtrise des mécanismes fondamentaux |
| JavaScript vanilla | React / Vue.js | Pas de dépendance inutile pour ce projet |
| MySQL | PostgreSQL | Plus répandu, bien supporté par Laragon |
| Railway | Heroku / Fly.io | Support PHP + MySQL + MongoDB, déploiement simple depuis GitHub |
