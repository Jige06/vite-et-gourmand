# Documentation du déploiement — Vite & Gourmand

## Stack de déploiement

- **Plateforme** : Railway (railway.app)
- **Conteneurisation** : Docker
- **Base de données relationnelle** : MySQL (service Railway)
- **Base de données non relationnelle** : MongoDB (service Railway)
- **Dépôt source** : GitHub (branche `main`)

---

## Prérequis

- Un compte Railway connecté à GitHub
- Le dépôt GitHub public `Jige06/vite-et-gourmand`
- Le fichier `Dockerfile` à la racine du projet

---

## Étapes de déploiement

### 1. Préparation du projet

Avant le déploiement, s'assurer que la branche `main` est à jour :

```bash
git checkout main
git merge develop
git push origin main
```

### 2. Création du projet Railway

1. Se connecter sur [railway.app](https://railway.app) avec son compte GitHub
2. Cliquer sur **"New Project"** → **"Deploy from GitHub repo"**
3. Sélectionner le dépôt `Jige06/vite-et-gourmand`
4. Choisir la branche **`main`**

Railway détecte automatiquement le `Dockerfile` et lance le build.

### 3. Configuration du Dockerfile

Le `Dockerfile` configure l'environnement d'exécution :

```dockerfile
FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Installation de l'extension MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Activation du module rewrite Apache
RUN a2enmod rewrite

# Copie du projet dans /var/www/html
COPY . /var/www/html

# Configuration Apache - document root sur le dossier public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
```

Cette version utilise la variable d'environnement `APACHE_DOCUMENT_ROOT` combinée à des commandes `sed` pour reconfigurer dynamiquement le document root d'Apache sur le dossier `public/`, sans nécessiter de fichier `apache.conf` séparé.

> ℹ️ Une version antérieure du Dockerfile copiait un fichier `apache.conf` dédié et utilisait un script de démarrage pour résoudre un conflit de modules MPM Apache. Cette approche a été simplifiée : la configuration via `sed` + `APACHE_DOCUMENT_ROOT` évite ce conflit nativement.

### 4. Ajout du service MySQL

1. Dans le projet Railway, cliquer sur **"New"** → **"Database"** → **"MySQL"**
2. Railway génère automatiquement les variables de connexion
3. Dans le service `vite-et-gourmand` → **Variables**, ajouter les références :

```
DB_HOST=${{MySQL.MYSQLHOST}}
DB_NAME=${{MySQL.MYSQLDATABASE}}
DB_USER=${{MySQL.MYSQLUSER}}
DB_PASS=${{MySQL.MYSQLPASSWORD}}
```

### 5. Import de la base de données

1. Récupérer `MYSQL_PUBLIC_URL` dans les variables du service MySQL
2. Se connecter à la base Railway depuis HeidiSQL avec les identifiants de l'URL
3. Importer dans cet ordre :
   - `database/create_bdd.sql` (remplacer `USE vite_et_gourmand` par `USE railway`)
   - `database/data.sql`

### 6. Configuration des variables d'environnement

Dans le service `vite-et-gourmand` → **Variables**, ajouter :

```
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USER=votre_username_mailtrap
MAIL_PASS=votre_password_mailtrap
MAIL_FROM=noreply@viteetgourmand.fr
MONGO_HOST=${{MongoDB.MONGOHOST}}
MONGO_PORT=${{MongoDB.MONGOPORT}}
MONGO_USER=${{MongoDB.MONGOUSER}}
MONGO_PASS=${{MongoDB.MONGOPASSWORD}}
MONGO_DB=vite_gourmand
ORS_API_KEY=votre_cle_openrouteservice
```

### 7. Génération du domaine public

Dans le service `vite-et-gourmand` → **Settings** → **Networking** → cliquer sur **"Generate Domain"** et saisir le port **80**.

L'application est accessible sur : `https://vite-et-gourmand.up.railway.app`

---

## Problèmes rencontrés et solutions

### Problème 1 — Dépendances manquantes pour MongoDB

**Erreur :** `fatal error: openssl/ssl.h: No such file or directory` puis `fatal error: zstd.h: No such file or directory`

**Cause :** L'installation de l'extension MongoDB via `pecl` compile depuis les sources et nécessite des bibliothèques système.

**Solution :** Ajouter `libssl-dev` dans le `apt-get install` du Dockerfile.

### Problème 2 — Conflit de modules MPM Apache

**Erreur :** `AH00534: apache2: Configuration error: More than one MPM loaded`

**Cause :** L'image `php:8.2-apache` active `mpm_event` par défaut. L'installation de l'extension MongoDB active également `mpm_prefork`, créant un conflit car un seul MPM peut être actif à la fois.

**Solution :** Reconfigurer le document root d'Apache via `APACHE_DOCUMENT_ROOT` et `sed`, ce qui évite ce conflit sans nécessiter de script de démarrage dédié.

### Problème 3 — Vendor absent sur le serveur

**Erreur :** `Failed to open stream: No such file or directory` sur `vendor/autoload.php`

**Cause :** Le dossier `vendor/` est dans le `.gitignore` et n'est donc pas présent sur le serveur.

**Solution :** Ajouter `composer install` dans le Dockerfile pour installer les dépendances au moment du build.

### Problème 4 — Fichier .env absent

**Erreur :** `parse_ini_file(): Failed to open stream`

**Cause :** Le fichier `.env` est dans le `.gitignore` et n'est pas déployé.

**Solution :** Modifier `index.php` pour charger le `.env` uniquement s'il existe (`file_exists()`), et configurer les variables d'environnement directement dans Railway.

### Problème 5 — SMTP bloqué sur le plan Hobby Railway

**Symptôme :** Les emails (confirmation de commande, réinitialisation de mot de passe, notification employé...) ne partent pas en production. Les logs affichent : `SMTP Error: Could not connect to SMTP host... Connection timed out`, suivi d'une erreur `upstream error` côté navigateur après un long délai.

**Cause :** Railway bloque les connexions SMTP sortantes (ports 25, 465, 587, 2525) sur les plans Free, Trial et Hobby, afin de prévenir les abus et le spam. Seul le plan Pro et supérieur autorise les connexions SMTP sortantes. Source : [documentation officielle Railway — Outbound Networking](https://docs.railway.com/networking/outbound-networking).

**Solution envisagée (non implémentée, hors budget du projet) :** Remplacer PHPMailer/SMTP par un service d'email transactionnel exposant une API HTTPS (Resend, SendGrid, Mailgun...). Ces services contournent la restriction puisque les appels passent par le port 443 (HTTPS), jamais bloqué par Railway quel que soit le plan.

**Contournement pour la démonstration :** L'envoi de mail fonctionne parfaitement en environnement local (Laragon et Docker), comme démontré tout au long du développement avec Mailtrap. La démonstration devant le jury s'appuie donc sur l'environnement Docker local pour toute fonctionnalité nécessitant l'envoi effectif d'un email.

---

## Variables d'environnement Railway

| Variable | Description |
|----------|-------------|
| `DB_HOST` | Host MySQL Railway |
| `DB_NAME` | Nom de la base MySQL |
| `DB_USER` | Utilisateur MySQL |
| `DB_PASS` | Mot de passe MySQL |
| `MAIL_HOST` | Host SMTP Mailtrap |
| `MAIL_PORT` | Port SMTP Mailtrap |
| `MAIL_USER` | Username Mailtrap |
| `MAIL_PASS` | Password Mailtrap |
| `MAIL_FROM` | Adresse expéditeur |
| `MONGO_HOST` | Host MongoDB Railway |
| `MONGO_PORT` | Port MongoDB Railway |
| `MONGO_DB` | Nom de la base MongoDB |
| `MONGO_USER` | Utilisateur MongoDB Railway |
| `MONGO_PASS` | Mot de passe MongoDB Railway |
| `ORS_API_KEY` | Clé API OpenRouteService (calcul des frais de livraison) |

---

## URL de production

**Application déployée :** [https://vite-et-gourmand.up.railway.app](https://vite-et-gourmand.up.railway.app)

> ⚠️ L'envoi d'emails est indisponible sur cette instance en raison du blocage SMTP du plan Hobby Railway (voir Problème 5). Pour une démonstration complète incluant l'envoi de mails, utiliser l'environnement Docker local (`docker compose up --build`).
