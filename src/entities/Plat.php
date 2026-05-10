<?php

class Plat
{
    private int $idPlat;
    private string $titre;
    private string $typePlat;
    private string $photo;

    public function __construct($idPlat, $titre, $typePlat, $photo)
    {
        $this->idPlat = $idPlat;
        $this->titre = $titre;
        $this->typePlat = $typePlat;
        $this->photo = $photo;
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

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    public function getTypePlat()
    {
        return $this->typePlat;
    }

    public function setTypePlat($typePlat)
    {
        $this->typePlat = $typePlat;
        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }
}
