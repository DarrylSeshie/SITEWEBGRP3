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
  
      // Requête SQL avec JOIN et LIMIT pour pagination
      $sql = "
          SELECT l.*, a.*, i.nom AS institution_nom, i.logo AS institution_logo, i.id_adresse AS institution_id_adresse
          FROM lieu l
          LEFT JOIN adresse a ON l.id_adresse = a.id_adresse
          LEFT JOIN institution i ON l.id_institution = i.id_institution
          LIMIT :offset, :pageSize
      ";
  
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
          $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $lieuData) {
              // Créer un objet Lieu avec les données du lieu
              $lieu = new Lieu($lieuData);
  
              // Créer un objet Adresse avec les données d'adresse associées
              $adresseData = [
                  'id_adresse' => $lieuData['id_adresse'],
                  'rue_numero' => $lieuData['rue_numero'],
                  'code_postal' => $lieuData['code_postal'],
                  'localite' => $lieuData['localite'],
                  'pays' => $lieuData['pays']
              ];
              $adresse = new Adresse($adresseData);
  
              // Créer un objet Institution avec les données d'institution associées
              $institutionData = [
                  'id_institution' => $lieuData['id_institution'],
                  'nom' => $lieuData['institution_nom'],
                  'logo' => $lieuData['institution_logo'],
                  'id_adresse' => $lieuData['institution_id_adresse']
              ];
              $institution = new Institution($institutionData);
  
              // Associer l'adresse et l'institution à l'objet Lieu
              $lieu->setAdresse($adresse);
              $lieu->setInstitution($institution);
  
              // Ajouter l'objet Lieu au tableau $lieux
              $lieux[] = $lieu;
          }
      } catch (PDOException $e) {
          // Gérer l'erreur de requête SQL
          throw $e;
      } finally {
          $prep = null; // Libérer la ressource PDOStatement
      }
  
      return $lieux;
  }
  

 
  public function count()
  {
      $sql = "SELECT COUNT(*) AS total FROM lieu";
  
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
    // Requête SQL avec jointures pour récupérer les données de l'institution et de l'adresse liées au lieu
    $sql = "UPDATE lieu
            LEFT JOIN institution ON lieu.id_institution = institution.id_institution
            LEFT JOIN adresse ON lieu.id_adresse = adresse.id_adresse
            SET lieu.nom = :nom,
                lieu.batiment = :batiment,
                lieu.locaux = :locaux,
                lieu.id_institution = :id_institution,
                lieu.id_adresse = :id_adresse,
                institution.nom = :institution_nom,
                institution.logo = :institution_logo,
                institution.id_adresse = :institution_id_adresse,
                adresse.rue_numero = :rue_numero,
                adresse.code_postal = :code_postal,
                adresse.localite = :localite,
                adresse.pays = :pays
            WHERE lieu.id_lieu = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Lieu et ses relations (Institution et Adresse)
        $prep->bindValue(':nom', $lieu->getNom(), PDO::PARAM_STR);
        $prep->bindValue(':batiment', $lieu->getBatiment(), PDO::PARAM_STR);
        $prep->bindValue(':locaux', $lieu->getLocaux(), PDO::PARAM_STR);
        $prep->bindValue(':id_institution', $lieu->getInstitution()->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindValue(':id_adresse', $lieu->getAdresse()->getIdAdresse(), PDO::PARAM_INT);
        $prep->bindValue(':institution_nom', $lieu->getInstitution()->getNom(), PDO::PARAM_STR);
        $prep->bindValue(':institution_logo', $lieu->getInstitution()->getLogo(), PDO::PARAM_STR);
        $prep->bindValue(':institution_id_adresse', $lieu->getInstitution()->getIdAdresse(), PDO::PARAM_INT);
        $prep->bindValue(':rue_numero', $lieu->getAdresse()->getRueNumero(), PDO::PARAM_STR);
        $prep->bindValue(':code_postal', $lieu->getAdresse()->getCodePostal(), PDO::PARAM_STR);
        $prep->bindValue(':localite', $lieu->getAdresse()->getLocalite(), PDO::PARAM_STR);
        $prep->bindValue(':pays', $lieu->getAdresse()->getPays(), PDO::PARAM_STR);
        $prep->bindValue(':id', $lieu->getIdLieu(), PDO::PARAM_INT); // ID de l'lieu à mettre à jour

        $prep->execute();
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}




public function addLieu($lieu)
{
    $sql = "
        INSERT INTO lieu (nom, batiment, locaux, id_institution, id_adresse) 
        VALUES (:nom, :batiment, :locaux, :id_institution, :id_adresse)
    ";

    try {
        $prep = $this->db->prepare($sql);

        // Récupération des données à partir de l'objet Lieu
        $nom = $lieu->getNom();
        $batiment = $lieu->getBatiment();
        $locaux = $lieu->getLocaux();
        $idInstitution = $lieu->getIdInstitution();
        $idAdresse = $lieu->getIdAdresse();

        // Liaison des paramètres avec les valeurs récupérées
        $prep->bindValue(':nom', $nom, PDO::PARAM_STR);
        $prep->bindValue(':batiment', $batiment, PDO::PARAM_STR);
        $prep->bindValue(':locaux', $locaux, PDO::PARAM_STR);
        $prep->bindValue(':id_institution', $idInstitution, PDO::PARAM_INT);
        $prep->bindValue(':id_adresse', $idAdresse, PDO::PARAM_INT);

        $prep->execute();

        $insertedId = $this->db->lastInsertId();

        // Chargement du lieu inséré en utilisant selectLieuById
        $newLieu = $this->selectLieuById($insertedId);

        return $newLieu;
    } catch (PDOException $e) {
        // Gestion de l'exception en cas d'échec de l'insertion
        throw $e;
    }
}



}