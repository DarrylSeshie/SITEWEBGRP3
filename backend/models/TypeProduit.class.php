<?php

class TypeProduit {
    public $id_type_produit;
    public $nom;

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setIdTypeProduit($array["id_type_produit"]);
            $this->setNom($array["nom"]);
        }
    }


    public function getIdTypeProduit() {
        return $this->id_type_produit;
    }

    public function setIdTypeProduit($id_type_produit) {
        $this->id_type_produit = intval($id_type_produit) ;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }
}


?>