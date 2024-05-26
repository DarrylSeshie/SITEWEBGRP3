<?php
require_once 'models/Adresse.class.php';
require_once 'models/Institution.class.php';
require_once 'models/Role.class.php';

class User
{
    public int $id_utilisateur;
    public string $civilite;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $mot_de_passe;
    public string $gsm;
    public string $TVA;
    public string $profession;
    public string $gsm_pro;
    public string $email_pro;
    public int $id_role;
    public int $id_institution;
    public int $id_adresse;
    public ?Adresse $adresse;
    public ?Institution $institution;
    public ?Role $role;
    public ?string $giografie;

    public function __construct(?array $array = null)
    {
        if ($array !== null) {
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
            $this->setGiografie($array["giografie"] ?? '');

            if (isset($array['adresse'])) {
                $this->setAddress(new Adresse($array['adresse']));
            }

            if (isset($array['institution'])) {
                $this->setInstitution(new Institution($array['institution']));
            }

            if (isset($array['role'])) {
                $this->setRole(new Role($array['role']));
            }
        }
    }

    public function getId(): int
    {
        return $this->id_utilisateur;
    }

    public function setId(int $id): void
    {
        $this->id_utilisateur = $id;
    }

    public function getCivilite(): string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): void
    {
        $this->civilite = $civilite;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMotDePasse(): string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): void
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    public function getGsm(): string
    {
        return $this->gsm;
    }

    public function setGsm(string $gsm): void
    {
        $this->gsm = $gsm;
    }

    public function getTVA(): string
    {
        return $this->TVA;
    }

    public function setTVA(string $TVA): void
    {
        $this->TVA = $TVA;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): void
    {
        $this->profession = $profession;
    }

    public function getGsmPro(): string
    {
        return $this->gsm_pro;
    }

    public function setGsmPro(string $gsm_pro): void
    {
        $this->gsm_pro = $gsm_pro;
    }

    public function getEmailPro(): string
    {
        return $this->email_pro;
    }

    public function setEmailPro(string $email_pro): void
    {
        $this->email_pro = $email_pro;
    }

    public function getIdRole(): int
    {
        return $this->id_role;
    }

    public function setIdRole(int $id_role): void
    {
        $this->id_role = $id_role;
    }

    public function getIdInstitution(): int
    {
        return $this->id_institution;
    }

    public function setIdInstitution(int $id_institution): void
    {
        $this->id_institution = $id_institution;
    }

    public function getIdAdresse(): int
    {
        return $this->id_adresse;
    }

    public function setIdAdresse(int $id_adresse): void
    {
        $this->id_adresse = $id_adresse;
    }

    public function getAddress(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAddress(?Adresse $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): void
    {
        $this->institution = $institution;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): void
    {
        $this->role = $role;
    }

    public function getGiografie(): string
    {
        return $this->giografie;
    }

    public function setGiografie(string $giografie): void
    {
        $this->giografie = $giografie;
    }
}
?>