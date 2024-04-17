<?php

class Formation {
    private $id_produit;
    private $titre;
    private $sous_titre;
    private $date_debut;
    private $date_fin;
    private $date_fin_inscription;
    private $descriptif;
    private $objectif;
    private $contenu;
    private $methodologie;
    private $public_cible;
    private $prix;
    private $id_image;
    private $id_lieu;
    private $id_type_produit;

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setIdProduit($array["id_produit"]);
            $this->setTitre($array["titre"]);
            $this->setSousTitre($array["sous_titre"]);
            $this->setDateDebut($array["date_debut"]);
            $this->setDateFin($array["date_fin"]);
            $this->setDateFinInscription($array["date_fin_inscription"]);
            $this->setDescriptif($array["descriptif"]);
            $this->setObjectif($array["objectif"]);
            $this->setContenu($array["contenu"]);
            $this->setMethodologie($array["methodologie"]);
            $this->setPublicCible($array["pubic_cible"]);
            $this->setPrix($array["prix"]);
            $this->setIdImage($array["id_image"]);
            $this->setIdLieu($array["id_lieu"]);
            $this->setIdTypeProduit($array["id_type_produit"]);
        }
    }



    public function getIdProduit() {
        return $this->id_produit;
    }

    public function setIdProduit($id_produit) {
        $this->id_produit = $id_produit;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function getSousTitre() {
        return $this->sous_titre;
    }

    public function setSousTitre($sous_titre) {
        $this->sous_titre = $sous_titre;
    }

    public function getDateDebut() {
        return $this->date_debut;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function getDateFinInscription() {
        return $this->date_fin_inscription;
    }

    public function setDateFinInscription($date_fin_inscription) {
        $this->date_fin_inscription = $date_fin_inscription;
    }

    public function getDescriptif() {
        return $this->descriptif;
    }

    public function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    public function getObjectif() {
        return $this->objectif;
    }

    public function setObjectif($objectif) {
        $this->objectif = $objectif;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function getMethodologie() {
        return $this->methodologie;
    }

    public function setMethodologie($methodologie) {
        $this->methodologie = $methodologie;
    }

    public function getPublicCible() {
        return $this->public_cible;
    }

    public function setPublicCible($public_cible) {
        $this->public_cible = $public_cible;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getIdImage() {
        return $this->id_image;
    }

    public function setIdImage($id_image) {
        $this->id_image = $id_image;
    }

    public function getIdLieu() {
        return $this->id_lieu;
    }

    public function setIdLieu($id_lieu) {
        $this->id_lieu = $id_lieu;
    }

    public function getIdTypeProduit() {
        return $this->id_type_produit;
    }

    public function setIdTypeProduit($id_type_produit) {
        $this->id_type_produit = $id_type_produit;
    }
}


?>