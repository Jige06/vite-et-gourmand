<?php

class CommandeStatut
{
    private string $dateChangement;
    private int $idCommande;
    private int $idStatutCommande;

    public function __construct($dateChangement, $idCommande, $idStatutCommande)
    {
        $this->dateChangement = $dateChangement;
        $this->idCommande = $idCommande;
        $this->idStatutCommande = $idStatutCommande;
    }

    public function getDateChangement()
    {
        return $this->dateChangement;
    }

    public function setDateChangement($dateChangement)
    {
        $this->dateChangement = $dateChangement;
        return $this;
    }

    public function getIdCommande()
    {
        return $this->idCommande;
    }

    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
        return $this;
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
}
