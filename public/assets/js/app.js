function togglePassword(id) {
  const input = document.getElementById(id);
  input.type = input.type === "password" ? "text" : "password";
}

function getFilters() {
  const theme = document.getElementById("theme-select").value;
  const regime = document.getElementById("regime-select").value;
  const prixMin = document.getElementById("prix-min").value;
  const prixMax = document.getElementById("prix-max").value;
  const nbrePers = document.getElementById("nbre-pers").value;
  return { theme, regime, prixMin, prixMax, nbrePers };
}

async function applyFilters() {
  // Récupère les valeurs des 5 filtres et les retourne dans un objet
  const filters = getFilters();

  // Construction la chaine de parametres GET à partir de l'objet
  const params = new URLSearchParams({
    prix_min: filters.prixMin,
    prix_max: filters.prixMax,
    theme: filters.theme,
    regime: filters.regime,
    nb_personnes: filters.nbrePers,
  });

  // Construction de l'URL complète
  const url = "/menus/filter?" + params.toString();

  try {
    const reponse = await fetch(url);
    if (!reponse.ok) {
      throw new Error(`Statut de réponse : ${reponse.status}`);
    }
    // convertit la réponse JSON en objet JavaScript
    const resultat = await reponse.json();
    // met à jour les cartes avec les menus filtrés
    updateMenuCards(resultat);
  } catch (erreur) {
    console.error(erreur.message);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Initialisation des tooltips Bootstrap
  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]',
  );
  tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));

  if (document.getElementById("theme-select")) {
    document
      .getElementById("theme-select")
      .addEventListener("change", applyFilters);
    document
      .getElementById("regime-select")
      .addEventListener("change", applyFilters);
    document.getElementById("prix-min").addEventListener("change", function () {
      const prixMax = document.getElementById("prix-max");
      if (prixMax.value && this.value > prixMax.value) {
        this.value = prixMax.value;
      }
      applyFilters();
    });
    document.getElementById("prix-max").addEventListener("change", function () {
      const prixMin = document.getElementById("prix-min");
      if (prixMin.value && this.value < prixMin.value) {
        this.value = prixMin.value;
      }
      applyFilters();
    });
    document
      .getElementById("nbre-pers")
      .addEventListener("change", applyFilters);
    document
      .getElementById("reset-filters")
      .addEventListener("click", function () {
        document.getElementById("theme-select").value = "";
        document.getElementById("regime-select").value = "";
        document.getElementById("prix-min").value = "";
        document.getElementById("prix-max").value = "";
        document.getElementById("nbre-pers").value = "";
        applyFilters();
      });
  }

  // Pré-remplissage du modal de modification d'un menu
  const modalModifMenu = document.getElementById("modalModifMenu");
  if (modalModifMenu) {
    modalModifMenu.addEventListener("show.bs.modal", function (e) {
      const btn = e.relatedTarget;
      const form = document.getElementById("form-modif-menu");
      form.querySelector('[name="Id_menu"]').value = btn.dataset.id;
      form.querySelector('[name="titre"]').value = btn.dataset.titre;
      form.querySelector('[name="description_menu"]').value =
        btn.dataset.description;
      form.querySelector('[name="prix_par_pers"]').value = btn.dataset.prix;
      form.querySelector('[name="nombre_pers_min"]').value = btn.dataset.pers;
      form.querySelector('[name="quantite_restante"]').value =
        btn.dataset.stock;
      form.querySelector('[name="conditions"]').value = btn.dataset.conditions;
      form.querySelector('[name="regime"]').value = btn.dataset.regime;
      form.querySelector('[name="Id_theme"]').value = btn.dataset.theme;
    });
  }

  // Récupération  de l'id menu pour suppression d'un menu
  const modalSupprimerMenu = document.getElementById("modalSupprimerMenu");
  if (modalSupprimerMenu) {
    modalSupprimerMenu.addEventListener("show.bs.modal", function (e) {
      const btn = e.relatedTarget;
      document.getElementById("id-menu-supprimer").value = btn.dataset.id;
    });
  }
  // Récupération  de l'id utilisateur pour la désactivation d'un employé
  const modalDeactivate = document.getElementById("modalDeactivate");
  if (modalDeactivate) {
    modalDeactivate.addEventListener("show.bs.modal", function (e) {
      const btn = e.relatedTarget;
      document.getElementById("id-utilisateur-desactiver").value =
        btn.dataset.id;
    });
  }

  // Pré-remplissage modal modification plat
  const modalModifPlat = document.getElementById("modalModifPlat");
  if (modalModifPlat) {
    modalModifPlat.addEventListener("show.bs.modal", function (e) {
      const btn = e.relatedTarget;
      const form = document.getElementById("form-modif-plat");
      form.querySelector('[name="Id_plat"]').value = btn.dataset.id;
      form.querySelector('[name="titre"]').value = btn.dataset.titre;
      form.querySelector('[name="type_plat"]').value = btn.dataset.type;
    });
  }

  // Récupération id plat pour suppression
  const modalSupprimerPlat = document.getElementById("modalSupprimerPlat");
  if (modalSupprimerPlat) {
    modalSupprimerPlat.addEventListener("show.bs.modal", function (e) {
      const btn = e.relatedTarget;
      document.getElementById("id-plat-supprimer").value = btn.dataset.id;
    });
  }

  // Graphiques statistiques administrateur
  if (document.getElementById("graphiqueCommandes")) {
    const labels = stats.map((s) => s.titre);
    const nbCommandes = stats.map((s) => s.nbre_commandes);
    const caTotal = stats.map((s) => s.ca_total);

    new Chart(document.getElementById("graphiqueCommandes"), {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Nombre de commandes",
            data: nbCommandes,
            backgroundColor: "#0056b3",
          },
        ],
      },
    });

    new Chart(document.getElementById("graphiqueCA"), {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Chiffre d'affaires (€)",
            data: caTotal,
            backgroundColor: "#e67e22",
          },
        ],
      },
    });
  }
});

function updateMenuCards(menus) {
  const container = document.getElementById("menu-cards");
  container.textContent = "";

  menus.forEach(function (menu) {
    const col = document.createElement("div");
    col.className = "details-menu col-12 col-md-6 col-lg-4 mb-3 ms-3 pt-2 pb-2";

    const carte = document.createElement("div");
    carte.className = "carte-menu";

    const image = document.createElement("img");
    image.src = "/assets/images/menus/" + menu.photo;
    image.alt = "photo du menu " + menu.titre;
    image.className = "card-img-menu";

    const theme = document.createElement("p");
    theme.textContent = menu.theme_libelle;

    const titre = document.createElement("h3");
    titre.textContent = menu.titre;

    const description = document.createElement("p");
    description.textContent = menu.description_menu;

    const prixParPers = document.createElement("p");
    prixParPers.textContent =
      menu.prix_par_pers + " €/pers — min " + menu.nombre_pers_min + " pers";

    const button = document.createElement("button");
    button.className = "detail-button";
    button.onclick = function () {
      window.location.href = "/menus/detail?id=" + menu.Id_menu;
    };
    button.textContent = "Voir le détail";

    carte.appendChild(image);
    carte.appendChild(theme);
    carte.appendChild(titre);
    carte.appendChild(description);
    carte.appendChild(prixParPers);
    carte.appendChild(button);

    col.appendChild(carte);
    container.appendChild(col);
  });
}

// Fonctionnement des boutons etape suivante et étape precedente de commande

const formUser = document.getElementById("form-user");
const formMenu = document.getElementById("form-menu");
const formOrder = document.getElementById("form-order");
if (formUser && formMenu && formOrder) {
  let prixLivraison = 0;
  // Passage à l'etape 2 de la commande
  const etapeApres1 = document.getElementById("etape-apres1");

  etapeApres1.addEventListener("click", function () {
    const typeLivraison = document.querySelector(
      'input[name="type_liv"]:checked',
    ).value;

    const date = document.getElementById("date_liv").value;
    const heure = document.getElementById("heure_liv").value;
    if (!date || !heure) {
      const errorDiv = document.getElementById("error-date");
      errorDiv.textContent = "Veuillez saisir la date et l'heure souhaitées.";
      errorDiv.style.display = "block";
      return;
    }
    document.getElementById("error-date").style.display = "none";

    const dateLivraison = new Date(date);
    const aujourdhui = new Date();
    aujourdhui.setHours(0, 0, 0, 0);
    if (dateLivraison < aujourdhui) {
      const errorDivDate = document.getElementById("error-date");
      errorDivDate.textContent = "Date incorrect.";
      errorDivDate.style.display = "block";
      return;
    }
    document.getElementById("error-date").style.display = "none";

    if (typeLivraison === "Livraison") {
      // Récupération des valeurs pour l'API
      const adresse = document.getElementById("adresse_liv").value;
      const codePostal = document.getElementById("codePostal_liv").value;
      const ville = document.getElementById("ville_liv").value;

      if (!adresse || !codePostal || !ville) {
        const errorDiv = document.getElementById("error-livraison");
        errorDiv.textContent = "Veuillez remplir tous les champs de livraison.";
        errorDiv.style.display = "block";
        return;
      }
      document.getElementById("error-livraison").style.display = "none";

      // Appel au serveur pour calculer les frais (plus de calcul direct côté client)
      calculerFraisLivraison(adresse, codePostal, ville);
    }

    formUser.style.display = "none";
    formMenu.style.display = "block";
  });

  // Passage à l'etape 1 via l'etape 2 de la commande
  const etapeAvant2 = document.getElementById("etape-avant2");
  etapeAvant2.addEventListener("click", function () {
    formUser.style.display = "block";
    formMenu.style.display = "none";
  });

  // Passage à l'etape 3 via l'etape 2 de la commande
  const etapeApres2 = document.getElementById("etape-apres2");
  etapeApres2.addEventListener("click", function () {
    formMenu.style.display = "none";
    formOrder.style.display = "block";
  });

  // Passage à l'etape 2 via l'etape3 de la commande
  const etapeAvant3 = document.getElementById("etape-avant3");
  etapeAvant3.addEventListener("click", function () {
    formOrder.style.display = "none";
    formMenu.style.display = "block";
  });

  // Gestion de l'affiche des champs de livraison en fonction du type
  // de livraison selectionné
  const livraison = document.getElementById("livraison");
  const enlevement = document.getElementById("enlevement");

  livraison.addEventListener("change", function () {
    document.querySelectorAll(".livraison").forEach(function (el) {
      el.style.display = "block";
    });
  });

  enlevement.addEventListener("change", function () {
    document.querySelectorAll(".livraison-param").forEach(function (el) {
      el.style.display = "none";
    });
    prixLivraison = 0;
    document.getElementById("recap-livraison").textContent = "";
    document.getElementById("hidden-livraison").value = 0;
    calculerPrixTotal();
  });

  document
    .getElementById("pret-materiel")
    .addEventListener("change", function () {
      const infoPret = document.getElementById("info-pret-materiel");
      infoPret.style.display = this.checked ? "block" : "none";
    });

  /* Récupère les frais de livraison calculés côté serveur (PHP), via une
requête au serveur, et les affiche dans le récapitulatif de la commande.
Le calcul n'est plus fait en JS pour éviter d'exposer la clé API et pour
empêcher la manipulation du prix par l'utilisateur. */

  async function calculerFraisLivraison(adresseLiv, codePostalLiv, villeLiv) {
    const params = new URLSearchParams({
      adresse: adresseLiv,
      codePostal: codePostalLiv,
      ville: villeLiv,
    });

    const response = await fetch(`/commande/calculer-frais?${params}`);
    const data = await response.json();

    if (data.erreur) {
      document.getElementById("recap-livraison").textContent = data.erreur;
      return;
    }

    prixLivraison = data.prix;

    document.getElementById("recap-livraison").textContent =
      `Frais de livraison : ${data.prix.toFixed(2)} € (${data.distance.toFixed(1)} km)`;
    document.getElementById("hidden-livraison").value = data.prix.toFixed(2);
    calculerPrixTotal();
  }

  // Mise à jour du min quand le menu change
  const menuSelect = document.getElementById("menu");
  const optionDefaut = menuSelect.options[menuSelect.selectedIndex];
  document.getElementById("nbre_pers").min = parseInt(
    optionDefaut.dataset.minPers,
  );
  menuSelect.addEventListener("change", function () {
    const optionSelectionnee = menuSelect.options[menuSelect.selectedIndex];
    const nbreMinPers = parseInt(optionSelectionnee.dataset.minPers);
    document.getElementById("nbre_pers").min = nbreMinPers;
  });

  // Calcul du total pour les menus
  const nbrePersInput = document.getElementById("nbre_pers");
  nbrePersInput.addEventListener("change", function () {
    calculerPrixTotal();
  });

  function calculerPrixTotal() {
    const optionSelectionnee = menuSelect.options[menuSelect.selectedIndex];
    const prix = parseFloat(optionSelectionnee.dataset.prix);
    const nbrePers = parseInt(nbrePersInput.value);
    if (!nbrePers) return;
    const nbreMinPers = parseInt(optionSelectionnee.dataset.minPers);
    if (nbrePers < nbreMinPers) {
      document.getElementById("recap-menu").textContent =
        `Minimum ${nbreMinPers} personnes requis pour ce menu.`;
      return;
    }
    let totalMenu;
    if (nbrePers - nbreMinPers >= 5) {
      const totalSansReduction = prix * nbrePers;
      const reduction = totalSansReduction * 0.1;
      totalMenu = totalSansReduction - reduction;

      document.getElementById("recap-menu").textContent =
        `Total de vos menus : ${totalSansReduction.toFixed(2)} €`;

      document.getElementById("recap-reduc").textContent =
        `Réduction : ${reduction.toFixed(2)} €`;
    } else {
      totalMenu = prix * nbrePers;
      document.getElementById("recap-menu").textContent =
        `Total de vos menus : ${totalMenu.toFixed(2)} €`;
      document.getElementById("recap-reduc").textContent = "";
    }

    const totalGeneral = totalMenu + prixLivraison;
    document.getElementById("recap-total").textContent =
      `Total de votre commande : ${totalGeneral.toFixed(2)} € TTC`;
    document.getElementById("hidden-total").value = totalGeneral.toFixed(2);
  }
}
