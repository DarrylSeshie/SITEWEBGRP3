<?php

class RoleManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    
    public function getRoleById($id_role)
{
    $sql = "SELECT * FROM role WHERE id_role = :id_role";

    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id_role', $id_role, PDO::PARAM_INT);
        $prep->execute();

        $roleData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$roleData) {
            return null; // Aucun rôle trouvé avec cet ID
        }

        $role = new Role($roleData['id_role'], $roleData['nom']);
        return $role;
    } catch (PDOException $e) {
        throw $e; // Gestion des erreurs PDO
    }
}
    
}

?>
