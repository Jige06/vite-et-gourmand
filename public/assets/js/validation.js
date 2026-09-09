// Fonctions qui vont vérifier le bon format saisi par l'utilisateur

function nomValide(valeur) {
  return /^[a-zA-ZÀ-ÿ\- ]+$/.test(valeur);
}

function emailValide(valeur) {
  return /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(valeur);
}

function codePostalValide(valeur) {
  return /^[0-9]{5}$/.test(valeur);
}

function telephoneValide(valeur) {
  return /^[0-9]{10}$/.test(valeur);
}

function motDePasseValide(valeur) {
  return /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{10,}$/.test(valeur);
}

if (document.getElementById("form-inscription")) {
  const formInscription = document.getElementById("form-inscription");
  formInscription.addEventListener("submit", function (event) {
    let formulaireValide = true;

    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const ville = document.getElementById("ville").value;
    const email = document.getElementById("email").value;
    const telephone = document.getElementById("telephone").value;
    const codePostal = document.getElementById("codePostal").value;
    const motDePasse = document.getElementById("motdepasse").value;
    const confirmMotDePasse =
      document.getElementById("confirm_motdepasse").value;

    const errorNom = document.getElementById("error-nom");
    const errorEmail = document.getElementById("error-email");
    const errorCodePostal = document.getElementById("error-code-postal");
    const errorTelephone = document.getElementById("error-telephone");
    const errorMotDePasse = document.getElementById("error-mot-de-passe");
    const errorConfirmation = document.getElementById("error-confirmation");

    // On cache tous les messages d'erreur avant de revérifier
    errorNom.style.display = "none";
    errorEmail.style.display = "none";
    errorCodePostal.style.display = "none";
    errorTelephone.style.display = "none";
    errorMotDePasse.style.display = "none";
    errorConfirmation.style.display = "none";

    if (!nomValide(nom) || !nomValide(prenom) || !nomValide(ville)) {
      errorNom.textContent =
        "Le nom, prénom et ville ne doivent contenir que des lettres.";
      errorNom.style.display = "block";
      formulaireValide = false;
    }

    if (!emailValide(email)) {
      errorEmail.textContent = "L'adresse email n'est pas valide.";
      errorEmail.style.display = "block";
      formulaireValide = false;
    }

    if (!codePostalValide(codePostal)) {
      errorCodePostal.textContent = "Le code postal doit contenir 5 chiffres.";
      errorCodePostal.style.display = "block";
      formulaireValide = false;
    }

    if (!telephoneValide(telephone)) {
      errorTelephone.textContent =
        "Le numéro de téléphone doit contenir 10 chiffres.";
      errorTelephone.style.display = "block";
      formulaireValide = false;
    }

    if (!motDePasseValide(motDePasse)) {
      errorMotDePasse.textContent =
        "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
      errorMotDePasse.style.display = "block";
      formulaireValide = false;
    }

    if (motDePasse !== confirmMotDePasse) {
      errorConfirmation.textContent = "Les mots de passe ne correspondent pas.";
      errorConfirmation.style.display = "block";
      formulaireValide = false;
    }

    if (!formulaireValide) {
      event.preventDefault();
    }
  });
}

if (document.getElementById("form-profil")) {
  const formProfil = document.getElementById("form-profil");
  formProfil.addEventListener("submit", function (event) {
    let formulaireValide = true;

    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const ville = document.getElementById("ville").value;
    const email = document.getElementById("email").value;
    const telephone = document.getElementById("telephone").value;
    const codePostal = document.getElementById("codePostal").value;

    const errorNom = document.getElementById("error-nom");
    const errorEmail = document.getElementById("error-email");
    const errorCodePostal = document.getElementById("error-code-postal");
    const errorTelephone = document.getElementById("error-telephone");

    // On cache tous les messages d'erreur avant de revérifier
    errorNom.style.display = "none";
    errorEmail.style.display = "none";
    errorCodePostal.style.display = "none";
    errorTelephone.style.display = "none";

    if (!nomValide(nom) || !nomValide(prenom) || !nomValide(ville)) {
      errorNom.textContent =
        "Le nom, prénom et ville ne doivent contenir que des lettres.";
      errorNom.style.display = "block";
      formulaireValide = false;
    }

    if (!emailValide(email)) {
      errorEmail.textContent = "L'adresse email n'est pas valide.";
      errorEmail.style.display = "block";
      formulaireValide = false;
    }

    if (!codePostalValide(codePostal)) {
      errorCodePostal.textContent = "Le code postal doit contenir 5 chiffres.";
      errorCodePostal.style.display = "block";
      formulaireValide = false;
    }

    if (!telephoneValide(telephone)) {
      errorTelephone.textContent =
        "Le numéro de téléphone doit contenir 10 chiffres.";
      errorTelephone.style.display = "block";
      formulaireValide = false;
    }

    if (!formulaireValide) {
      event.preventDefault();
    }
  });
}

if (document.getElementById("form-crea-employe")) {
  const formCreaEmploye = document.getElementById("form-crea-employe");
  formCreaEmploye.addEventListener("submit", function (event) {
    let formulaireValide = true;

    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const email = document.getElementById("email").value;
    const motDePasse = document.getElementById("motdepasse").value;
    const confirmMotDePasse =
      document.getElementById("confirm_motdepasse").value;

    const errorNom = document.getElementById("error-nom");
    const errorEmail = document.getElementById("error-email");
    const errorMotDePasse = document.getElementById("error-mot-de-passe");
    const errorConfirmation = document.getElementById("error-confirmation");

    // On cache tous les messages d'erreur avant de revérifier
    errorNom.style.display = "none";
    errorEmail.style.display = "none";
    errorMotDePasse.style.display = "none";
    errorConfirmation.style.display = "none";

    if (!nomValide(nom) || !nomValide(prenom)) {
      errorNom.textContent =
        "Le nom et prénom ne doivent contenir que des lettres.";
      errorNom.style.display = "block";
      formulaireValide = false;
    }

    if (!emailValide(email)) {
      errorEmail.textContent = "L'adresse email n'est pas valide.";
      errorEmail.style.display = "block";
      formulaireValide = false;
    }

    if (!motDePasseValide(motDePasse)) {
      errorMotDePasse.textContent =
        "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
      errorMotDePasse.style.display = "block";
      formulaireValide = false;
    }

    if (motDePasse !== confirmMotDePasse) {
      errorConfirmation.textContent = "Les mots de passe ne correspondent pas.";
      errorConfirmation.style.display = "block";
      formulaireValide = false;
    }

    if (!formulaireValide) {
      event.preventDefault();
    }
  });
}

if (document.getElementById("form-change-password")) {
  const formChangePassword = document.getElementById("form-change-password");
  formChangePassword.addEventListener("submit", function (event) {
    let formulaireValide = true;

    const motDePasse = document.getElementById("password").value;
    const confirmMotDePasse =
      document.getElementById("confirm_password").value;

    const errorMotDePasse = document.getElementById("error-mot-de-passe");
    const errorConfirmation = document.getElementById("error-confirmation");

    // On cache tous les messages d'erreur avant de revérifier
    errorMotDePasse.style.display = "none";
    errorConfirmation.style.display = "none";

    if (!motDePasseValide(motDePasse)) {
      errorMotDePasse.textContent =
        "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
      errorMotDePasse.style.display = "block";
      formulaireValide = false;
    }

    if (motDePasse !== confirmMotDePasse) {
      errorConfirmation.textContent = "Les mots de passe ne correspondent pas.";
      errorConfirmation.style.display = "block";
      formulaireValide = false;
    }

    if (!formulaireValide) {
      event.preventDefault();
    }
  });
}