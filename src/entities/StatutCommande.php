<?php

class StatutCommande
{
    private int $idStatutCommande;
    private string $libelle;

    public function __construct($idStatutCommande, $libelle)
    {
        $this->idStatutCommande = $idStatutCommande;
        $this->libelle = $libelle;
    }

    public function getIdStatutCommande()
    {
        return $this->idStatutCommande;
    }

    public function setIdStatutCommande($idStatutCommande)
    {
        $this->idStatutCommande = $idStatutCommande;
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
