<?php



class LieuManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getLieux($page, $pageSize)
{ 

 $lieux = [];

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM lieu  LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $lieuData) {
            
            $lieu = new Lieu();
            $lieu->setIdLieu($lieuData['id_lieu']);
            $lieu->setNom($lieuData['nom']);
            $lieu->setBatiment($lieuData['batiment']);
            $lieu->setLocaux($lieuData['locaux']);
            // Ajouter l'objet User au tableau $users
            $lieux[] = $lieu;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $lieux;

}

public function getLieuByname2($page, $pageSize,$nom)
{ 

 $lieux = []; 

  
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM lieu WHERE nom LIKE :nom LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $lieuData) {
            
            $lieu = new lieu();
            
            $lieu->setIdLieu($lieuData['id_lieu']);
            $lieu->setNom($lieuData['nom']);
            $lieu->setBatiment($lieuData['batiment']);
            $lieu->setLocaux($lieuData['locaux']);
            $lieu->setIdInstitution($lieuData['id_institution']);
            $lieu->setIdAdresse($lieuData['id_adresse']);
           
            // Ajouter l'objet lieu au tableau $lieus
            $lieux[] = $lieu;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $lieux;

}




  /**
   * @param Lieu $lieu
   */
 

   public function selectLieuById($lieuId)
{
    $sql = "SELECT l.*, a.*, i.nom AS institution_nom, i.logo AS institution_logo, i.id_adresse AS institution_id_adresse
            FROM lieu l
            LEFT JOIN adresse a ON l.id_adresse = a.id_adresse
            LEFT JOIN institution i ON l.id_institution = i.id_institution
            WHERE l.id_lieu = :lieuId";

    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':lieuId', $lieuId, PDO::PARAM_INT);
        $prep->execute();

        $lieuData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$lieuData) {
            return null; 
        }

       
        $lieu = new Lieu($lieuData);
        $adresseData = [
            'id_adresse' => $lieuData['id_adresse'],
            'rue_numero' => $lieuData['rue_numero'], 
            'code_postal' => $lieuData['code_postal'], 
            'localite' => $lieuData['localite'],
            'pays' => $lieuData['pays'] 
        ];
        $adresse = new Adresse($adresseData);
        $lieu->setAdresse($adresse);
        $institutionData = [
            'id_institution' => $lieuData['id_institution'],
            'nom' => $lieuData['institution_nom'], 
            'logo' => $lieuData['institution_logo'], 
            'id_adresse' => $lieuData['institution_id_adresse'] 
        ];
        $institution = new Institution($institutionData);
        $lieu->setInstitution($institution);

        return $lieu;
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}






public function deleteLieu($id)
{
    $sql = "DELETE FROM lieu WHERE id_lieu = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression du lieu : ' . $e->getMessage());
    }
}


  

public function updateLieu($lieu)
{
    $sql = "UPDATE lieu
            SET  nom = :nom,
            batiment = :batiment,
            locaux = :locaux,
            id_institution = :id_institution,
            id_adresse = :id_adresse
            WHERE id_lieu = :id";
    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Lieu
        $prep->bindParam(':nom', $lieu->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':batiment', $lieu->getBatiment(), PDO::PARAM_STR);
        $prep->bindParam(':locaux', $lieu->getLocaux(), PDO::PARAM_STR);
        $prep->bindParam(':id_institution', $lieu->getInstitution()->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $lieu->getAdresse()->getIdAdresse(), PDO::PARAM_INT);
        $prep->bindParam(':id', $lieu->getIdLieu(), PDO::PARAM_INT); // ID de l'lieu à mettre à jour

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}




public function addLieu($lieu)
{
    $sql = "INSERT INTO lieu (nom, batiment, locaux, id_institution, id_adresse) 
            VALUES (:nom, :batiment, :locaux, :id_institution, :id_adresse)";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Lieu
        $prep->bindParam(':nom', $lieu->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':batiment', $lieu->getBatiment(), PDO::PARAM_STR);
        $prep->bindParam(':locaux', $lieu->getLocaux(), PDO::PARAM_STR);
        $prep->bindParam(':id_institution', $lieu->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $lieu->getIdAdresse(), PDO::PARAM_INT);

        $prep->execute();

        $lieuID = $this->db->lastInsertId();

        $lieu->setIdLieu
        ($lieuID);
        return true;
        

    } catch (PDOException $e) {
        throw $e;
        return false ;
    } 
}

}