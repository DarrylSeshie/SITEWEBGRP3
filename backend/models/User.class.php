<?php
class User
{
    public $id_utilisateur;
    public $civilite;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;
    public $gsm;
    public $TVA;
    public $profession;
    public $gsm_pro;
    public $email_pro;
    public $id_role;
    public $id_institution;
    public $id_adresse;

    public function __construct($array = null)
    {
        if ($array != null) {
            $this->setId($array["id_utilisateur"]);
            $this->setCivilite($array["civilite"]);
            $this->setNom($array["nom"]);
            $this->setPrenom($array["prenom"]);
            $this->setEmail($array["email"]);
            $this->setMotDePasse($array["mot_de_passe"]);
            $this->setGsm($array["gsm"]);
            $this->setTVA($array["TVA"]);
            $this->setProfession($array["profession"]);
            $this->setGsmPro($array["gsm_pro"]);
            $this->setEmailPro($array["email_pro"]);
            $this->setIdRole($array["id_role"]);
            $this->setIdInstitution($array["id_institution"]);
            $this->setIdAdresse($array["id_adresse"]);
        }
    }

    public function getId()
    {
        return $this->id_utilisateur;
    }

    public function setId($id)
    {
        $this->id_utilisateur = intval($id);
    }

    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    public function getGsm()
    {
        return $this->gsm;
    }

    public function setGsm($gsm)
    {
        $this->gsm = $gsm;
    }

    public function getTVA()
    {
        return $this->TVA;
    }

    public function setTVA($TVA)
    {
        $this->TVA = $TVA;
    }

    public function getProfession()
    {
        return $this->profession;
    }

    public function setProfession($profession)
    {
        $this->profession = $profession;
    }

    public function getGsmPro()
    {
        return $this->gsm_pro;
    }

    public function setGsmPro($gsm_pro)
    {
        $this->gsm_pro = $gsm_pro;
    }

    public function getEmailPro()
    {
        return $this->email_pro;
    }

    public function setEmailPro($email_pro)
    {
        $this->email_pro = $email_pro;
    }

    public function getIdRole()
    {
        return $this->id_role;
    }

    public function setIdRole($id_role)
    {
        $this->id_role = $id_role;
    }

    public function getIdInstitution()
    {
        return $this->id_institution;
    }

    public function setIdInstitution($id_institution)
    {
        $this->id_institution = $id_institution;
    }

    public function getIdAdresse()
    {
        return $this->id_adresse;
    }

    public function setIdAdresse($id_adresse)
    {
        $this->id_adresse = $id_adresse;
    }
}
?>

