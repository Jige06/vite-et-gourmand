# 🍽 Vite & Gourmand

Application web pour le traiteur bordelais **Vite & Gourmand** (Julie et José).
Permet aux clients de consulter les menus, passer des commandes en ligne et laisser des avis.

---

## 🛠 Stack technique

- **Back-end** : PHP natif, architecture MVC, PDO
- **Base de données** : MySQL (relationnelle) + MongoDB (non relationnelle pour les statistiques)
- **Front-end** : HTML5, CSS3, Bootstrap 5.3, JavaScript vanilla, Chart.js
- **Envoi de mails** : PHPMailer + Mailtrap (tests)
- **API externe** : OpenRouteService (calcul frais de livraison)
- **Conteneurisation** : Docker
- **Déploiement** : Railway

---

## ✅ Prérequis

### Option A — Avec Laragon (recommandé pour le développement)
- [Laragon](https://laragon.org/) (Apache + PHP + MySQL)
- [Composer](https://getcomposer.org/)
- [MongoDB](https://www.mongodb.com/try/download/community)
- [Git](https://git-scm.com/)

### Option B — Avec Docker
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)

---

## 🚀 Installation et lancement en local

### Option A — Avec Laragon

#### 1. Cloner le dépôt

```bash
git clone https://github.com/Jige06/vite-et-gourmand.git
```

Placez le dossier cloné dans le répertoire `www` de Laragon.
Laragon crée automatiquement le Virtual Host — l'application sera accessible sur :
👉 `http://vite-et-gourmand.test`

#### 2. Installer les dépendances PHP

```bash
cd vite-et-gourmand
composer install
```

#### 3. Importer la base de données MySQL

1. Ouvrez **HeidiSQL** (inclus dans Laragon)
2. Créez une base de données nommée `vite_et_gourmand`
3. Importez les fichiers SQL dans cet ordre :
   - `database/create_bdd.sql` — création de la structure
   - `database/data.sql` — insertion des données de test

#### 4. Configurer les variables d'environnement

Renommez le fichier `.env.example` en `.env` et renseignez vos identifiants :

```env
APP_ENV=local
APP_URL=http://vite-et-gourmand.test

DB_HOST=localhost
DB_NAME=vite_et_gourmand
DB_USER=root
DB_PASS=

MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USER=votre_username_mailtrap
MAIL_PASS=votre_password_mailtrap
MAIL_FROM=noreply@viteetgourmand.fr

MONGO_HOST=localhost
MONGO_PORT=27017
MONGO_DB=vite_gourmand

ORS_API_KEY=votre_cle_openrouteservice
```

#### 5. Lancer MongoDB

```bash
mongod --dbpath "chemin/vers/votre/dossier/data"
```
*Exemple sous Windows :* `mongod --dbpath "C:\mongodb\data"`

#### 6. Lancer l'application

Démarrez Laragon (Apache + MySQL), puis rendez-vous sur :
👉 `http://vite-et-gourmand.test`

---

### Option B — Avec Docker

#### 1. Cloner le dépôt

```bash
git clone https://github.com/Jige06/vite-et-gourmand.git
cd vite-et-gourmand
```

#### 2. Configurer les variables d'environnement

Renommez le fichier `.env.example` en `.env` et renseignez vos identifiants :

```env
APP_ENV=local
APP_URL=http://localhost:8080

DB_HOST=mysql
DB_NAME=vite_et_gourmand
DB_USER=root
DB_PASS=

MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USER=votre_username_mailtrap
MAIL_PASS=votre_password_mailtrap
MAIL_FROM=noreply@viteetgourmand.fr

MONGO_HOST=mongodb
MONGO_PORT=27017
MONGO_DB=vite_gourmand

ORS_API_KEY=votre_cle_openrouteservice
```

> ⚠️ Avec Docker, `DB_HOST` doit valoir `mysql` et `MONGO_HOST` doit valoir `mongodb` (noms des services Docker).

#### 3. Lancer les conteneurs

```bash
docker compose up --build
```

L'application sera accessible sur :
👉 `http://localhost:8080`

La base de données MySQL est initialisée automatiquement au premier lancement.

---

## 🗂 Structure du projet

```
vite-et-gourmand/
├── database/
│ ├── create_bdd.sql # Structure de la base de données
│ └── data.sql # Données de test
├── docs/ # Documentation du projet
├── public/
│ ├── assets/
│ │ ├── css/ # Feuilles de style
│ │ ├── images/ # Images (menus, plats)
│ │ └── js/ # Scripts JavaScript
│ ├── .htaccess # Réécriture des URLs
│ ├── favicon-512.png
│ └── index.php # Point d'entrée + routeur
├── src/
│ ├── controllers/ # Contrôleurs (AuthController, OrderController...)
│ ├── core/ # Classes fondamentales (Auth, Csrf, Validator, FileUploadHandler...)
│ ├── entities/ # Classes entités (User, Menu, Commande...)
│ ├── repositories/ # Accès aux données (UserRepository, MenuRepository...)
│ ├── services/ # Logique métier (CommandeService, LivraisonService)
│ └── views/ # Vues PHP
│ ├── layouts/ # Header, footer, nav, messages
│ ├── auth/ # Connexion, inscription, reset password
│ ├── admin/ # Espace administrateur
│ ├── employe/ # Espace employé
│ ├── user/ # Espace utilisateur
│ ├── menus/ # Liste et détail des menus
│ ├── commande/ # Formulaire de commande
│ ├── contact/ # Page contact
│ └── legal/ # CGV, mentions légales
├── vendor/ # Dépendances Composer
├── .env.example
├── .gitignore
├── composer.json
├── docker-compose.yml
├── Dockerfile
└── README.md
```

---

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | jose@viteetgourmand.fr | Admin1234! |
| Employé | julie@viteetgourmand.fr | Employe1234! |
| Utilisateur | pierre.durand@exemple.com | User1234! |

---

## 🌐 Liens

- **Dépôt GitHub** : [github.com/Jige06/vite-et-gourmand](https://github.com/Jige06/vite-et-gourmand)
- **Application déployée** : [vite-et-gourmand.up.railway.app](https://vite-et-gourmand.up.railway.app)
- **Gestion de projet** : [Trello — Vite & Gourmand](https://trello.com/invite/b/698f205608a640eec2cec29e/ATTIbc2a9d11b045fafeb3c16d80817390bf7F928597/ecf-vitegourmand)

---

## 🔐 Sécurité

- Requêtes préparées PDO (protection injections SQL)
- Hachage des mots de passe avec `password_hash()` (bcrypt)
- Protection CSRF sur tous les formulaires POST
- Protection XSS via `htmlspecialchars()`
- Validation des données côté serveur (classe `Validator`) et côté client (JS)
- Contrôle d'accès par rôle sur toutes les routes protégées
- Upload de fichiers sécurisé (vérification MIME réel, nom aléatoire)
- Sessions sécurisées (HttpOnly, SameSite, régénération d'ID)

---

*Projet réalisé dans le cadre de l'ECF — Titre Professionnel Développeur Web et Web Mobile (Studi)*