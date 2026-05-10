<?php

class MenuPlat
{
    private int $idMenu;
    private int $idPlat;

    public function __construct($idMenu, $idPlat)
    {
        $this->idMenu = $idMenu;
        $this->idPlat = $idPlat;
    }

    public function getIdMenu()
    {
        return $this->idMenu;
    }

    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
        return $this;
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
}
