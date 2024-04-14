<?php
class Lieu
{
    public $id_lieu;
    public $nom;
    public $batiment;
    public $locaux;
    public $id_institution;
    public $id_adresse;
    public $institution; // Propriété pour stocker l'objet Institution associé
    public $adresse; // Propriété pour stocker l'objet Adresse associé

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setIdLieu($array["id_lieu"]);
            $this->setNom($array["nom"]);
            $this->setBatiment($array["batiment"]);
            $this->setLocaux($array["locaux"]);
            $this->setIdInstitution($array["id_institution"]);
            $this->setIdAdresse($array["id_adresse"]);
            
            // Si une institution est fournie, instancier un objet Institution
            if (isset($array['institution'])) {
                $this->setInstitution(new Institution($array['institution']));
            }
            
            // Si une adresse est fournie, instancier un objet Adresse
            if (isset($array['adresse'])) {
                $this->setAdresse(new Adresse($array['adresse']));
            }
        }
    }

    public function getIdLieu()
    {
        return $this->id_lieu;
    }

    public function setIdLieu($id_lieu)
    {
        $this->id_lieu = intval($id_lieu);
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getBatiment()
    {
        return $this->batiment;
    }

    public function setBatiment($batiment)
    {
        $this->batiment = $batiment;
    }

    public function getLocaux()
    {
        return $this->locaux;
    }

    public function setLocaux($locaux)
    {
        $this->locaux = $locaux;
    }

    public function getIdInstitution()
    {
        return $this->id_institution;
    }

    public function setIdInstitution($id_institution)
    {
        $this->id_institution = intval($id_institution);
    }

    public function getIdAdresse()
    {
        return $this->id_adresse;
    }

    public function setIdAdresse($id_adresse)
    {
        $this->id_adresse = intval($id_adresse);
    }
    
    public function getInstitution()
    {
        return $this->institution;
    }

    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }
    
    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }
}

?>