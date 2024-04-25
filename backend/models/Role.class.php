<?php
class Role
{
    private $id_role;
    private $nom;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->setIdRole($data['id_role'] ?? null);
            $this->setNom($data['nom'] ?? null);
            
        }
       
    }

    public function getIdRole()
    {
        return $this->id_role;
    }

    public function setIdRole($id_role)
    {
        $this->id_role = intval ( $id_role );
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}
