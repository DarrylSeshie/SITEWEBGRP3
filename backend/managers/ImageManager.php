<?php



class ImageManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getImages($page, $pageSize)
{ 

    $images = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM  image  LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $imageData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $image = new Image();
            $image->setIdimage($imageData['id_image']);
            $image->setUrlImage($imageData['url_image']);
            $image->setNom($imageData['nom']);
            $images[] = $image;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $images;

}
 
public function count()
{
    $sql = "SELECT COUNT(*) AS total FROM image";

    try {
        $prep = $this->db->prepare($sql);
        $prep->execute();
        
        $result = $prep->fetch(PDO::FETCH_ASSOC);
        return $result['total']; // Retourner le nombre total d'utilisateurs

    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}

public function getImagesByName($page, $pageSize,$nom)
{ 

    $images = []; // Initialise un tableau vide pour stocker les objets Adresse

    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM image WHERE nom LIKE :nom LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $imageData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $image = new Image();
            $image->setIdimage($imageData['id_image']);
            $image->setUrlImage($imageData['url_image']);
            $image->setNom($imageData['nom']);
            $images[] = $image;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $images;

}




  /**
   * @param Image $image
   */
  public function selectImageById($imageId)
{
    $sql = "SELECT * FROM image WHERE id_image = :imgId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':imgId', $imageId, PDO::PARAM_INT);
        $prep->execute();

        $imgData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$imgData) {
            return null; // Aucun lieu trouvé avec cet ID
        }

        // Création d'un nouvel objet adresse à partir des données récupérées
        $imgObject = new Image($imgData);

        return $imgObject;
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; 
    }
}



public function deleteImage($id)
{
    $sql = "DELETE FROM image WHERE id_image = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression adresse : ' . $e->getMessage());
    }
}

 

  public function updateImage($img)
{
    $sql = "UPDATE image 
    SET nom = :nom,
            url_image = :url_image
            WHERE id_image = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Adresse
        $prep->bindValue(':url_image', $img->getUrlImage(), PDO::PARAM_STR);
        $prep->bindValue(':nom', $img->getNom(), PDO::PARAM_STR);
        $prep->bindValue(':id', $img->getIdImage(), PDO::PARAM_INT); 

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}


public function addImage($img)
{
    $sql = "INSERT INTO image ( url_image,nom) 
                VALUES (:url_image,:nom)";

    try {
        $prep = $this->db->prepare($sql);

        $prep->bindValue(':url_image', $img->getUrlImage(), PDO::PARAM_STR);
        $prep->bindValue(':nom', $img->getNom(), PDO::PARAM_STR);
      

        $prep->execute();

        
        $img->setIdImage($this->db->lastInsertId());
        
     
        return true; // Succès
    } catch (PDOException $e) {
       // En cas d'erreur, renvoyer une réponse d'erreur
       throw new Exception("Erreur lors de l'ajout image'.", 0, $e);
       return false;
    }
}


}