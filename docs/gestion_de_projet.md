# Gestion de projet — Vite & Gourmand

## Méthode de travail

La gestion de ce projet a été réalisée de manière autonome, sans équipe, dans le cadre de l'ECF du Titre Professionnel Développeur Web et Web Mobile.

N'ayant pas d'expérience avec les méthodes agiles formelles (Scrum, sprints), j'ai adopté une approche au fil de l'eau, en avançant fonctionnalité par fonctionnalité selon les priorités définies par le cahier des charges. Cette méthode m'a permis de rester concentré sur un objectif à la fois et de valider chaque fonctionnalité avant de passer à la suivante.

---

## Outil de gestion : Trello

J'ai utilisé **Trello** pour organiser et suivre l'avancement des tâches sous forme de tableau Kanban. Le board est structuré en trois colonnes :

- **Tâches à planifier** — fonctionnalités identifiées mais pas encore démarrées
- **Tâches en cours** — fonctionnalités en cours de développement
- **Tâches terminées** — fonctionnalités développées et testées

### État du board au moment de la livraison

| Colonne | Nombre de tâches | Exemples |
|---------|-----------------|---------|
| Tâches à planifier | 3 | Gestion des horaires, Filtres statistiques, Annulation commande avec motif |
| Tâches en cours | 5 | Déploiement, Page avis, Page contact, Mockups WEB, Mockups mobile |
| Tâches terminées | 19 | MCD, Diagramme de séquences, Processus de commande, Espace administrateur, Page d'accueil, Wireframes mobile, Router, Vue détaillée menu, Création BDD, Espace utilisateur, Vue globale menus, Module authentification, Diagramme de classes, Index.php, Classe DatabaseConnection (Singleton)... |

### Lien vers le board Trello
[Accéder au board Trello](https://trello.com/invite/b/698f205608a640eec2cec29e/ATTIbc2a9d11b045fafeb3c16d80817390bf7F928597/ecf-vitegourmand)

---

## Gestion des versions : Git & GitHub

Le versioning du projet a été géré avec **Git**, avec un dépôt distant public sur **GitHub**.

### Stratégie de branches

```
main
└── develop (branche par défaut)
    ├── feature/auth-views
    ├── feature/commande
    ├── feature/detail-menu
    ├── feature/espace-admin
    ├── feature/espace-employe
    ├── feature/espace-user
    ├── feature/home-page
    ├── feature/menus
    └── feature/router-config
```

- **`main`** — branche principale, contient le code stable prêt pour la production
- **`develop`** — branche d'intégration, toutes les fonctionnalités y sont mergées après test
- **`feature/*`** — une branche par fonctionnalité, créée depuis `develop` et mergée dans `develop` après validation

### Bonnes pratiques appliquées
- Une branche par fonctionnalité
- Merge dans `develop` uniquement après test local
- Merge dans `main` uniquement pour la livraison finale

---

## Priorisation des tâches

Les tâches ont été priorisées selon trois niveaux :

**Priorité 1 — Obligatoire ECF**
Fonctionnalités directement évaluées par le jury : architecture MVC, base de données, authentification, commande, espaces utilisateur/employé/admin, MongoDB, déploiement.

**Priorité 2 — Important**
Fonctionnalités attendues dans le cahier des charges mais non bloquantes pour la note : page contact, CGV, mentions légales, page avis publique.

**Priorité 3 — Si le temps le permet**
Fonctionnalités souhaitables mais non critiques : gestion des horaires, filtres statistiques, annulation commande avec motif côté employé.

---

## Fonctionnalités non implémentées

Par manque de temps, certaines fonctionnalités prévues dans le cahier des charges n'ont pas pu être développées :

- Gestion des horaires depuis l'espace employé
- Annulation d'une commande par l'employé avec saisie obligatoire du motif et du mode de contact

Ces points constituent des axes d'amélioration prioritaires pour une prochaine itération.
