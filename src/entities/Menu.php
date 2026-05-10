<?php

class Menu
{
    private int $idMenu;
    private string $titre;
    private string $descriptionMenu;
    private float $prixParPers;
    private int $nombrePersMin;
    private int $quantiteRestante;
    private string $conditions;
    private string $regime;
    private string $photo;
    private int $idTheme;

    public function __construct(
        $idMenu,
        $titre,
        $descriptionMenu,
        $prixParPers,
        $nombrePersMin,
        $quantiteRestante,
        $conditions,
        $regime,
        $photo,
        $idTheme
    ) {
        $this->idMenu = $idMenu;
        $this->titre = $titre;
        $this->descriptionMenu = $descriptionMenu;
        $this->prixParPers = $prixParPers;
        $this->nombrePersMin = $nombrePersMin;
        $this->quantiteRestante = $quantiteRestante;
        $this->conditions = $conditions;
        $this->regime = $regime;
        $this->photo = $photo;
        $this->idTheme = $idTheme;
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

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescriptionMenu()
    {
        return $this->descriptionMenu;
    }

    public function setDescriptionMenu($descriptionMenu)
    {
        $this->descriptionMenu = $descriptionMenu;
        return $this;
    }

    public function getPrixParPers()
    {
        return $this->prixParPers;
    }

    public function setPrixParPers($prixParPers)
    {
        $this->prixParPers = $prixParPers;
        return $this;
    }

    public function getNombrePersMin()
    {
        return $this->nombrePersMin;
    }

    public function setNombrePersMin($nombrePersMin)
    {
        $this->nombrePersMin = $nombrePersMin;
        return $this;
    }

    public function getQuantiteRestante()
    {
        return $this->quantiteRestante;
    }

    public function setQuantiteRestante($quantiteRestante)
    {
        $this->quantiteRestante = $quantiteRestante;
        return $this;
    }

    public function getConditions()
    {
        return $this->conditions;
    }

    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function getRegime()
    {
        return $this->regime;
    }

    public function setRegime($regime)
    {
        $this->regime = $regime;
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

    public function getIdTheme()
    {
        return $this->idTheme;
    }

    public function setIdTheme($idTheme)
    {
        $this->idTheme = $idTheme;
        return $this;
    }
}
