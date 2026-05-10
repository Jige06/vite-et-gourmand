<?php

class Roles
{
    private int $idRole;
    private string $libelle;

    public function __construct($idRole, $libelle)
    {
        $this->idRole = $idRole;
        $this->libelle = $libelle;
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

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
        return $this;
    }
}
