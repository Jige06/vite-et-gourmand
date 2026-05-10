<?php

class Horaire
{
    private int $idHoraire;
    private string $jour;
    private string $heureOuverture;
    private string $heureFermeture;

    public function __construct($idHoraire, $jour, $heureOuverture, $heureFermeture)
    {
        $this->idHoraire = $idHoraire;
        $this->jour = $jour;
        $this->heureOuverture = $heureOuverture;
        $this->heureFermeture = $heureFermeture;
    }

    public function getIdHoraire()
    {
        return $this->idHoraire;
    }

    public function setIdHoraire($idHoraire)
    {
        $this->idHoraire = $idHoraire;
        return $this;
    }

    public function getJour()
    {
        return $this->jour;
    }

    public function setJour($jour)
    {
        $this->jour = $jour;
        return $this;
    }

    public function getHeureOuverture()
    {
        return $this->heureOuverture;
    }

    public function setHeureOuverture($heureOuverture)
    {
        $this->heureOuverture = $heureOuverture;
        return $this;
    }

    public function getHeureFermeture()
    {
        return $this->heureFermeture;
    }

    public function setHeureFermeture($heureFermeture)
    {
        $this->heureFermeture = $heureFermeture;
        return $this;
    }
}
