<?php

class Allergene
{
    private int $idAllergene;
    private string $nom;

    public function __construct($idAllergene, $nom)
    {
        $this->idAllergene = $idAllergene;
        $this->nom = $nom;
    }

    public function getIdAllergene()
    {
        return $this->idAllergene;
    }

    public function setIdAllergene($idAllergene)
    {
        $this->idAllergene = $idAllergene;
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
}