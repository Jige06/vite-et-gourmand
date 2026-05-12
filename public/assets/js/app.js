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
  document.getElementById("nbre-pers").addEventListener("change", applyFilters);
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
    image.src = "/assets/images/" + menu.photo;
    image.alt = menu.photo.replace(/\.[^/.]+$/, "");

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
