<?php
class Adresse
{
    public $id_adresse;
    public $rue_numero;
    public $code_postal;
    public $localite;
    public $pays;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->setIdAdresse($data['id_adresse'] ?? null);
            $this->setRueNumero($data['rue_numero'] ?? null);
            $this->setCodePostal($data['code_postal'] ?? null);
            $this->setLocalite($data['localite'] ?? null);
            $this->setPays($data['pays'] ?? null);
        }
    }

    public function getIdAdresse()
    {
        return $this->id_adresse;
    }

    public function setIdAdresse($id_adresse)
    {
        $this->id_adresse = intval($id_adresse);
    }

    public function getRueNumero()
    {
        return $this->rue_numero;
    }

    public function setRueNumero($rue_numero)
    {
        $this->rue_numero = $rue_numero;
    }

    public function getCodePostal()
    {
        return $this->code_postal;
    }

    public function setCodePostal($code_postal)
    {
        $this->code_postal = intval($code_postal);
    }

    public function getLocalite()
    {
        return $this->localite;
    }

    public function setLocalite($localite)
    {
        $this->localite = $localite;
    }

    public function getPays()
    {
        return $this->pays;
    }

    public function setPays($pays)
    {
        $this->pays = $pays;
    }
}

?>