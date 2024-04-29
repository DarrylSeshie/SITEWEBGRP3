<?php


require_once 'models/Institution.class.php';
class InstitutionManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getInstitutions($page, $pageSize)
  { 
      $institutions = []; 
      // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
      $offset = ($page - 1) * $pageSize;
  
      $sql = "
          SELECT 
              i.*, 
              a.rue_numero AS adresse_rue_numero, 
              a.code_postal AS adresse_code_postal, 
              a.localite AS adresse_localite, 
              a.pays AS adresse_pays
          FROM 
              institution i
          LEFT JOIN 
              adresse a ON i.id_adresse = a.id_adresse
          LIMIT 
              :offset, :pageSize";
  
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
          $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $institutionData) {
              // Créer un nouvel objet Institution avc db data
              $institution = new Institution();
              $institution->setIdinstitution($institutionData['id_institution']);
              $institution->setNom($institutionData['nom']);
              $institution->setLogo($institutionData['logo']);
              $institution->setIdAdresse($institutionData['id_adresse']);
  
              // Créer un nouvel objet Adresse avec les détails d'adresse associés
              $adresse = new Adresse();
              $adresse->setIdAdresse($institutionData['id_adresse']);
              $adresse->setRueNumero($institutionData['adresse_rue_numero']);
              $adresse->setCodePostal($institutionData['adresse_code_postal']);
              $adresse->setLocalite($institutionData['adresse_localite']);
              $adresse->setPays($institutionData['adresse_pays']);
  
              // Affecter l'objet Adresse à l'institution
              $institution->setAdresse($adresse);
  
              // Ajouter l'objet Institution au tableau $institutions
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
    $sql = "
    
    SELECT 
    i.*, 
    a.rue_numero AS adresse_rue_numero, 
    a.code_postal AS adresse_code_postal, 
    a.localite AS adresse_localite, 
    a.pays AS adresse_pays
FROM 
    institution i
LEFT JOIN 
    adresse a ON i.id_adresse = a.id_adresse

    
     WHERE nom LIKE :nom LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $institutionData) {
            // Créer un nouvel objet Institution avc db data
            $institution = new Institution();
            $institution->setIdinstitution($institutionData['id_institution']);
            $institution->setNom($institutionData['nom']);
            $institution->setLogo($institutionData['logo']);
            $institution->setIdAdresse($institutionData['id_adresse']);

            // Créer un nouvel objet Adresse avec les détails d'adresse associés
            $adresse = new Adresse();
            $adresse->setIdAdresse($institutionData['id_adresse']);
            $adresse->setRueNumero($institutionData['adresse_rue_numero']);
            $adresse->setCodePostal($institutionData['adresse_code_postal']);
            $adresse->setLocalite($institutionData['adresse_localite']);
            $adresse->setPays($institutionData['adresse_pays']);

            // Affecter l'objet Adresse à l'institution
            $institution->setAdresse($adresse);

            // Ajouter l'objet Institution au tableau $institutions
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
      $sql = "
          SELECT 
              i.*, 
              a.rue_numero AS adresse_rue_numero, 
              a.code_postal AS adresse_code_postal, 
              a.localite AS adresse_localite, 
              a.pays AS adresse_pays
          FROM 
              institution i
          LEFT JOIN 
              adresse a ON i.id_adresse = a.id_adresse
          WHERE 
              i.id_institution = :institId";
  
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':institId', $institutionId, PDO::PARAM_INT);
          $prep->execute();
  
          $institutionData = $prep->fetch(PDO::FETCH_ASSOC);
  
          if (!$institutionData) {
              return null; // Aucune institution trouvée avec cet ID
          }
  
          // Création d'un nouvel objet Institution en utilisant les données de la base de données
          $institutionObject = new Institution();
          $institutionObject->setIdinstitution($institutionData['id_institution']);
          $institutionObject->setNom($institutionData['nom']);
          $institutionObject->setLogo($institutionData['logo']);
          $institutionObject->setIdAdresse($institutionData['id_adresse']);
  
          // Création d'un nouvel objet Adresse avec les détails d'adresse associés
          $adresse = new Adresse();
          $adresse->setIdAdresse($institutionData['id_adresse']);
          $adresse->setRueNumero($institutionData['adresse_rue_numero']);
          $adresse->setCodePostal($institutionData['adresse_code_postal']);
          $adresse->setLocalite($institutionData['adresse_localite']);
          $adresse->setPays($institutionData['adresse_pays']);
  
          // Affecter l'objet Adresse à l'objet Institution
          $institutionObject->setAdresse($adresse);
  
          return $institutionObject;
      } catch (PDOException $e) {
          throw $e; // Propager l'exception pour la gestion des erreurs
      } finally {
          $prep = null; // Libérer la ressource PDOStatement
      }
  }
  



public function deleteInstitution2($id)
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


public function deleteInstitution($id)
{
    $sql = "DELETE FROM institution WHERE id_institution = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $prep->execute();

        if ($success) {
            echo "Suppression réussie.";
             return true;
        } else {
            echo "Échec de la suppression.";
             return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    } 
}

 

public function updateInstitution($institution)
{
    $sql = "UPDATE institution 
            SET nom = :nom,
                logo = :logo,
                id_adresse = :id_adresse
            WHERE id_institution = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Institution
        $prep->bindParam(':nom', $institution->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':logo', $institution->getLogo(), PDO::PARAM_STR);
        $prep->bindParam(':id_adresse', $institution->getAdresse()->getIdAdresse(), PDO::PARAM_INT);
        $prep->bindParam(':id', $institution->getIdinstitution(), PDO::PARAM_INT);

        $prep->execute();
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la mise à jour de institution.", 0, $e);
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
    
            // Liaison des paramètres avec les valeurs de l'objet Institution
            $prep->bindParam(':nom', $institution->getNom(), PDO::PARAM_STR);
            $prep->bindParam(':logo', $institution->getLogo(), PDO::PARAM_STR);
            $prep->bindParam(':id_adresse', $institution->getIdAdresse(), PDO::PARAM_INT);
    
            $prep->execute();
    
            // Définir l'ID de l'institution avec l'ID généré par la base de données
            $institutionId = $this->db->lastInsertId();
            $institution->setId($institutionId);
    
            return true; // Succès
    
        } catch (PDOException $e) {
            // En cas d'erreur, renvoyer une réponse d'erreur
            throw new Exception("Erreur lors de l'ajout institution'.", 0, $e);
            return false;
        }
    
    
}





}