<?php
require_once 'models/User.class.php';
require_once 'models/Formation.class.php';

class Donne {

    
    public $id_utilisateur;
    public $id_produit;


    public function __construct(?array $array = null)
    {
        if ($array != null) {
            $this->setIdProduit($array["id_produit"]);
            $this->setIdUtilisateur($array["id_utilisateur"]);
           
        }
    }


    public function getIdUtilisateurr() {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }
    

    public function getIdProduit() {
        return $this->id_produit;
    }

    public function setIdProduit($id_produit) {
        $this->id_produit = $id_produit;
    }

  




}


?>