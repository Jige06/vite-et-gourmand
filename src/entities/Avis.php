<?php

class Avis
{
    private int $idAvis;
    private int $note;
    private string $descriptionAvis;
    private string $statut;

    public function __construct($idAvis, $note, $descriptionAvis, $statut)
    {
        $this->idAvis = $idAvis;
        $this->note = $note;
        $this->descriptionAvis = $descriptionAvis;
        $this->statut = $statut;
    }

    public function getIdAvis()
    {
        return $this->idAvis;
    }

    public function setIdAvis($idAvis)
    {
        $this->idAvis = $idAvis;

        return $this;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    public function getDescriptionAvis()
    {
        return $this->descriptionAvis;
    }

    public function setDescriptionAvis($descriptionAvis)
    {
        $this->descriptionAvis = $descriptionAvis;
        return $this;
    }

    public function getStatut()
    {
        return $this->statut;
    }

    public function setStatut($statut)
    {
        $this->statut = $statut;
        return $this;
    }
}
