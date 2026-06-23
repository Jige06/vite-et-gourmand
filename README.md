# 🍽️ Vite & Gourmand

Application web pour le traiteur bordelais **Vite & Gourmand** (Julie et José).  
Permet aux clients de consulter les menus, passer des commandes en ligne et laisser des avis.

---

## 🛠️ Stack technique

- **Back-end** : PHP natif, architecture MVC, PDO
- **Base de données** : MySQL (relationnelle) + MongoDB (non relationnelle pour les statistiques)
- **Front-end** : HTML5, CSS3, Bootstrap 5.3, JavaScript vanilla, Chart.js
- **Envoi de mails** : PHPMailer + Mailtrap (tests)
- **API externe** : OpenRouteService (calcul frais de livraison)
- **Conteneurisation** : Docker
- **Déploiement** : Railway

---

## ✅ Prérequis

Avant de lancer le projet en local, assurez-vous d'avoir installé :

- [Laragon](https://laragon.org/) (Apache + PHP + MySQL)
- [Composer](https://getcomposer.org/)
- [MongoDB](https://www.mongodb.com/try/download/community) (installé séparément)
- [Git](https://git-scm.com/)

---

## 🚀 Installation et lancement en local

### 1. Cloner le dépôt

```bash
git clone https://github.com/Jige06/vite-et-gourmand.git
```

Placez le dossier cloné dans le répertoire `www` de Laragon.  
Laragon crée automatiquement le Virtual Host — l'application sera accessible sur :  
👉 `http://vite-et-gourmand.test`

### 2. Installer les dépendances PHP

```bash
cd vite-et-gourmand
composer install
```

### 3. Importer la base de données MySQL

1. Ouvrez **HeidiSQL** (inclus dans Laragon)
2. Créez une base de données nommée `vite_et_gourmand`
3. Importez les fichiers SQL dans cet ordre :
   - `database/create_bdd.sql` — création de la structure
   - `database/data.sql` — insertion des données de test

### 4. Configurer les variables d'environnement

Renommez le fichier `.env.example` en `.env` et renseignez vos identifiants Mailtrap :

```env
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
```

> 💡 La clé API OpenRouteService est déjà intégrée dans le code — aucune configuration supplémentaire n'est nécessaire.

### 5. Lancer MongoDB

MongoDB doit être lancé manuellement. Ouvrez un terminal et exécutez :

```bash
mongod --dbpath "chemin/vers/votre/dossier/data"
```
*Exemple sous Windows :* `mongod --dbpath "C:\mongodb\data"`

### 6. Lancer l'application

Démarrez Laragon (Apache + MySQL), puis rendez-vous sur :  
👉 `http://vite-et-gourmand.test`

---

## 🗂️ Structure du projet

```
vite-et-gourmand/
├── database/
│   ├── create_bdd.sql      # Structure de la base de données
│   └── data.sql            # Données de test
├── docs/
│   ├── Diagramme de classes Vite et Gourmand
│   └── MCD_Vite_et_gourmand.jpg
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── images/
│   │   └── js/
│   ├── .htaccess
│   ├── favicon-512.png
│   └── index.php           # Point d'entrée + routeur
├── src/
│   ├── controllers/        # Contrôleurs (AuthController, OrderController...)
│   ├── core/               # Classes fondamentales (DatabaseConnection...)
│   ├── entities/           # Classes entités (User, Menu, Commande...)
│   ├── repositories/       # Repositories (UserRepository, MenuRepository, OrderRepository...)
│   └── views/              # Vues PHP
├── vendor/                 # Dépendances Composer
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
├── Dockerfile
├── evolution.md
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
- **Application déployée** : [votre-app.railway.app](https://votre-app.railway.app)
- **Gestion de projet** : [trello.com/votre-board](https://trello.com/invite/b/698f205608a640eec2cec29e/ATTIbc2a9d11b045fafeb3c16d80817390bf7F928597/ecf-vitegourmand)

---

## 🔐 Sécurité

- Requêtes préparées PDO (protection injections SQL)
- Hachage des mots de passe avec `password_hash()`
- Protection XSS via `htmlspecialchars()`
- Contrôle d'accès par rôle sur toutes les routes protégées
- Sessions PHP pour l'authentification

---

*Projet réalisé dans le cadre de l'ECF — Titre Professionnel Développeur Web et Web Mobile (Studi)*
