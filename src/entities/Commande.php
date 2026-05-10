<?php

class Commande
{
    private int $idCommande;
    private string $dateCommande;
    private int $nbrePers;
    private int $nbrePersVegetarien;
    private float $montantTotal;
    private float $prixLivraison;
    private string $typeLivraison;
    private string $adresseLivraison;
    private string $codePostalLivraison;
    private string $villeLivraison;
    private string $heureLivraison;
    private string $dateLivraison;
    private bool $pretMateriel;
    private bool $restitutionMateriel;

    public function __construct(
        $idCommande,
        $dateCommande,
        $nbrePers,
        $nbrePersVegetarien,
        $montantTotal,
        $prixLivraison,
        $typeLivraison,
        $adresseLivraison,
        $codePostalLivraison,
        $villeLivraison,
        $heureLivraison,
        $dateLivraison,
        $pretMateriel,
        $restitutionMateriel
    ) {
        $this->idCommande = $idCommande;
        $this->dateCommande = $dateCommande;
        $this->nbrePers = $nbrePers;
        $this->nbrePersVegetarien = $nbrePersVegetarien;
        $this->montantTotal = $montantTotal;
        $this->prixLivraison = $prixLivraison;
        $this->typeLivraison = $typeLivraison;
        $this->adresseLivraison = $adresseLivraison;
        $this->codePostalLivraison = $codePostalLivraison;
        $this->villeLivraison = $villeLivraison;
        $this->heureLivraison = $heureLivraison;
        $this->dateLivraison = $dateLivraison;
        $this->pretMateriel = $pretMateriel;
        $this->restitutionMateriel = $restitutionMateriel;
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

    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getNbrePers()
    {
        return $this->nbrePers;
    }

    public function setNbrePers($nbrePers)
    {
        $this->nbrePers = $nbrePers;
        return $this;
    }

    public function getNbrePersVegetarien()
    {
        return $this->nbrePersVegetarien;
    }

    public function setNbrePersVegetarien($nbrePersVegetarien)
    {
        $this->nbrePersVegetarien = $nbrePersVegetarien;
        return $this;
    }

    public function getMontantTotal()
    {
        return $this->montantTotal;
    }

    public function setMontantTotal($montantTotal)
    {
        $this->montantTotal = $montantTotal;
        return $this;
    }

    public function getPrixLivraison()
    {
        return $this->prixLivraison;
    }

    public function setPrixLivraison($prixLivraison)
    {
        $this->prixLivraison = $prixLivraison;
        return $this;
    }

    public function getTypeLivraison()
    {
        return $this->typeLivraison;
    }

    public function setTypeLivraison($typeLivraison)
    {
        $this->typeLivraison = $typeLivraison;
        return $this;
    }

    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison($adresseLivraison)
    {
        $this->adresseLivraison = $adresseLivraison;
        return $this;
    }

    public function getCodePostalLivraison()
    {
        return $this->codePostalLivraison;
    }

    public function setCodePostalLivraison($codePostalLivraison)
    {
        $this->codePostalLivraison = $codePostalLivraison;
        return $this;
    }

    public function getVilleLivraison()
    {
        return $this->villeLivraison;
    }

    public function setVilleLivraison($villeLivraison)
    {
        $this->villeLivraison = $villeLivraison;
        return $this;
    }

    public function getHeureLivraison()
    {
        return $this->heureLivraison;
    }

    public function setHeureLivraison($heureLivraison)
    {
        $this->heureLivraison = $heureLivraison;
        return $this;
    }

    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;
        return $this;
    }

    public function getPretMateriel()
    {
        return $this->pretMateriel;
    }

    public function setPretMateriel($pretMateriel)
    {
        $this->pretMateriel = $pretMateriel;
        return $this;
    }

    public function getRestitutionMateriel()
    {
        return $this->restitutionMateriel;
    }

    public function setRestitutionMateriel($restitutionMateriel)
    {
        $this->restitutionMateriel = $restitutionMateriel;
        return $this;
    }
}
