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


public function getRoles($page, $pageSize)
{ 

 $roles = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM role  LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $roleData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $role = new Role();
            $role->setIdrole($roleData['id_role']);
            $role->setNom($roleData['nom']);
            $roles[] = $role;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $roles;

}

    
}

?>
