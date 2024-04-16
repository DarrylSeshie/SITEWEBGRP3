<?php



class InstitutionManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getInstitutions($page, $pageSize)
{ 

    $institutions = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM institution  LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $institutionData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $institution = new Institution();
            $institution->setIdinstitution($institutionData['id_institution']);
            $institution->setNom($institutionData['nom']);
            $institution->setLogo($institutionData['logo']);
            $institution->setIdAdresse($institutionData['id_adresse']);
            $institutions[] = $institution;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $institutions;

}

public function getInstitutionsByName($page, $pageSize,$nom)
{ 

 $institutions = []; // Initialise un tableau vide pour stocker les objets Adresse

    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM institution WHERE nom LIKE :nom LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $institutionData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $institution = new Institution();
            
            $institution->setIdinstitution($institutionData['id_institution']);
            $institution->setNom($institutionData['nom']);
            $institution->setLogo($institutionData['logo']);
            $institution->setIdAdresse($institutionData['id_adresse']);
            $institutions[] = $institution;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $institutions;

}




  /**
   * @param Institution $institution
   */
  public function selectInstitutionById($institutionId)
{
    $sql = "SELECT * FROM institution WHERE id_institution = :institId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':institId', $institutionId, PDO::PARAM_INT);
        $prep->execute();

        $institutionData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$institutionData) {
            return null; // Aucun lieu trouvé avec cet ID
        }

        // Création d'un nouvel objet adresse à partir des données récupérées
        $institutionObject = new Institution($institutionData);

        return $institutionObject;
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; 
    }
}



public function deleteInstitution($id)
{
    $sql = "DELETE FROM institution WHERE id_institution = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression adresse : ' . $e->getMessage());
    }
}

 

  public function updateInstitution($institution)
{
    $sql = "UPDATE institution SET 
            nom = :nom,
            logo = :logo,
            id_adresse = :id_adresse,
            WHERE id_institution = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Adresse
        $prep->bindParam(': nom', $institution->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':logo', $institution->getLogo(), PDO::PARAM_STR);
        $prep->bindParam(':id_adresse', $institution->getIdAdresse(), PDO::PARAM_STR);
        $prep->bindParam(':id', $institution->getIdinstitution(), PDO::PARAM_INT); 

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function addInstitution($institution)
{
    $sql = "INSERT INTO institution (nom, logo, id_adresse) 
            VALUES (:nom, :logo, :id_adresse)";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Adresse
        $prep->bindParam(':nom', $institution->getRueNumero(), PDO::PARAM_STR);
        $prep->bindParam(':logo', $institution->getCodePostal(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $institution->getLocalite(), PDO::PARAM_STR);

        $prep->execute();

        $institution->setId($this->db->lastInsertId());
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null;
    }
}

}