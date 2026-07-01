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
- Les fichiers `Dockerfile` et `apache.conf` à la racine du projet

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

RUN apt-get update && apt-get install -y \
    libzip-dev libssl-dev libzstd-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && a2enmod rewrite

COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

RUN echo '#!/bin/bash\n\
find /etc/apache2/mods-enabled/ -name "mpm_*.load" -delete\n\
find /etc/apache2/mods-enabled/ -name "mpm_*.conf" -delete\n\
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load\n\
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf\n\
apache2-foreground' > /start.sh && chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
```

Le fichier `apache.conf` configure le document root sur `/var/www/html/public` et active `AllowOverride All` pour le routage.

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
```

### 7. Génération du domaine public

Dans le service `vite-et-gourmand` → **Settings** → **Networking** → cliquer sur **"Generate Domain"** et saisir le port **80**.

L'application est accessible sur : `https://vite-et-gourmand.up.railway.app`

---

## Problèmes rencontrés et solutions

### Problème 1 — Dépendances manquantes pour MongoDB

**Erreur :** `fatal error: openssl/ssl.h: No such file or directory` puis `fatal error: zstd.h: No such file or directory`

**Cause :** L'installation de l'extension MongoDB via `pecl` compile depuis les sources et nécessite des bibliothèques système.

**Solution :** Ajouter `libssl-dev` et `libzstd-dev` dans le `apt-get install` du Dockerfile.

### Problème 2 — Conflit de modules MPM Apache

**Erreur :** `AH00534: apache2: Configuration error: More than one MPM loaded`

**Cause :** L'image `php:8.2-apache` active `mpm_event` par défaut. L'installation de l'extension MongoDB active également `mpm_prefork`, créant un conflit car un seul MPM peut être actif à la fois.

**Solution :** Ajouter un script de démarrage (`/start.sh`) qui supprime tous les modules MPM actifs et réactive uniquement `mpm_prefork` avant le lancement d'Apache.

### Problème 3 — Vendor absent sur le serveur

**Erreur :** `Failed to open stream: No such file or directory` sur `vendor/autoload.php`

**Cause :** Le dossier `vendor/` est dans le `.gitignore` et n'est donc pas présent sur le serveur.

**Solution :** Ajouter `composer install` dans le Dockerfile pour installer les dépendances au moment du build.

### Problème 4 — Fichier .env absent

**Erreur :** `parse_ini_file(): Failed to open stream`

**Cause :** Le fichier `.env` est dans le `.gitignore` et n'est pas déployé.

**Solution :** Modifier `index.php` pour charger le `.env` uniquement s'il existe (`file_exists()`), et configurer les variables d'environnement directement dans Railway.

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
---

## URL de production

**Application déployée :** [https://vite-et-gourmand.up.railway.app](https://vite-et-gourmand.up.railway.app)
