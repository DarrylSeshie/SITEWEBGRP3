<?php
class Institution
{
    public $id_institution;
    public $nom;
    public $logo;
    public $id_adresse;
    public $adresse; // Propriété pour stocker l'objet Adresse associé

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setIdInstitution($array["id_institution"]);
            $this->setNom($array["nom"]);
            $this->setLogo($array["logo"]);
            $this->setIdAdresse($array["id_adresse"]);
            
            // Si une adresse est fournie, instancier un objet Adresse
            if (isset($array['adresse'])) {
                $this->setAdresse(new Adresse($array['adresse']));
            }
        }
    }

    public function getIdInstitution()
    {
        return $this->id_institution;
    }

    public function setIdInstitution($id_institution)
    {
        $this->id_institution = intval($id_institution);
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getIdAdresse()
    {
        return $this->id_adresse;
    }

    public function setIdAdresse($id_adresse)
    {
        $this->id_adresse = intval($id_adresse);
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