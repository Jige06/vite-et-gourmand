<?php

class PlatAllergene
{
    private int $idPlat;
    private int $idAllergene;

    public function __construct($idPlat, $idAllergene)
    {
        $this->idPlat = $idPlat;
        $this->idAllergene = $idAllergene;
    }

    public function getIdPlat()
    {
        return $this->idPlat;
    }

    public function setIdPlat($idPlat)
    {
        $this->idPlat = $idPlat;
        return $this;
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
}
