<?php
require_once 'models/Adresse.class.php';
class Institution
{
    public  int $id_institution;
    public string $nom;
    public string $logo;
    public int $id_adresse;
    public ?Adresse $adresse; // Propriété pour stocker l'objet Adresse associé

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->setIdInstitution($data['id_institution'] ?? null);
            $this->setNom($data['nom'] ?? null);
            $this->setLogo($data['logo'] ?? null);
            $this->setIdAdresse($data['id_adresse'] ?? null);

            if (isset($data['adresse'])) {
                $this->setAddress(new Adresse($data['adresse']));
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
    
    public function getAddress(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAddress(?Adresse $adresse): void
    {
        $this->adresse = $adresse;
    }
}



?>