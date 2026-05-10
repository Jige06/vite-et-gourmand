<?php

class User
{
    private int $idUser;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $motDePasse;
    private string $telephone;
    private string $adresse;
    private string $codePostal;
    private string $ville;
    private bool $actif;
    private int $idRole;
    private bool $mustChangePassword;

    public function __construct($idUser, $nom, $prenom, $email, $motDePasse, $telephone, $adresse, $codePostal, $ville, $actif, $idRole, $mustChangePassword)
    {
        $this->idUser = $idUser;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->actif = $actif;
        $this->idRole = $idRole;
        $this->mustChangePassword = $mustChangePassword;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getCodePostal()
    {
        return $this->codePostal;
    }

    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }

    public function getIdRole()
    {
        return $this->idRole;
    }

    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
        return $this;
    }

    public function getMustChangePassword()
    {
        return $this->mustChangePassword;
    }

    public function setMustChangePassword($mustChangePassword)
    {
        $this->mustChangePassword = $mustChangePassword;
        return $this;
    }
}
