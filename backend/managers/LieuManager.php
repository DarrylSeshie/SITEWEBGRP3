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

 $lieux = []; // Initialise un tableau vide pour stocker les objets User

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
            // Créer un nouvel objet User à partir des données de la base de données
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

 $lieux = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
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
            // Créer un nouvel objet User à partir des données de la base de données
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
    $sql = "SELECT * FROM lieu WHERE id_lieu = :lieuId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':lieuId', $lieuId, PDO::PARAM_INT);
        $prep->execute();

        $lieuData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$lieuData) {
            return null; // Aucun lieu trouvé avec cet ID
        }

        // Création d'un nouvel objet User à partir des données récupérées
        $lieuObject = new Lieu($lieuData);

        return $lieuObject;
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}
/*
public function selectLieuById2($lieuId)
{
    $sql = "SELECT lieu.id_lieu, 
                   lieu.nom AS lieu_nom, 
                   lieu.batiment, 
                   lieu.locaux, 
                   institution.id_institution, 
                   institution.nom AS institution_nom, 
                   institution.logo, 
                   adresse.rue_numero, 
                   adresse.code_postal, 
                   adresse.localite, 
                   adresse.pays
            FROM lieu
            JOIN institution ON lieu.id_institution = institution.id_institution
            JOIN adresse ON lieu.id_adresse = adresse.id_adresse
            WHERE lieu.id_lieu = :id";

    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $lieuId, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            
            $lieu = new Lieu();
            $lieu->setIdLieu($result['id_lieu']);
            $lieu->setNom($result['lieu_nom']); 
            $lieu->setBatiment($result['batiment']);
            $lieu->setLocaux($result['locaux']);

          
            $institution = new Institution();
            $institution->setIdInstitution($result['id_institution']);
            $institution->setNom($result['institution_nom']); 
            $institution->setLogo($result['logo']);
          
            $lieu->setInstitution($institution);

            
            $adresse = new Adresse();
            $adresse->setRueNumero($result['rue_numero']);
            $adresse->setCodePostal($result['code_postal']);
            $adresse->setLocalite($result['localite']);
            $adresse->setPays($result['pays']);
            // Associer l'adresse au lieu
            $lieu->setAdresse($adresse);

            return $lieu; 
        } else {
            return null; 
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL de manière appropriée (ex. journal des erreurs)
        error_log('Erreur lors de la récupération du détail du lieu : ' . $e->getMessage());
        throw new Exception('Erreur lors de la récupération du détail du lieu.');
    } finally {
        $prep = null;
    }
}

*/


public function selectLieux()
{
    $sql = "SELECT * FROM lieu";
    try {
        $prep = $this->db->prepare($sql);
        $prep->execute();

        // Récupérer tous les résultats de la requête sous forme de tableau associatif
        $lieux = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Créer un tableau pour stocker les objets User
        $lieuObjects = [];

        // Parcourir les résultats et créer des objets User pour chaque lieu
        foreach ($lieux as $lieu) {
            $lieuObject = new lieu();
            $lieuObject->setIdLieu($lieu['id_lieu']);
            $lieuObject->setNom($lieu['nom']);
            $lieuObject->setBatiment($lieu['batiment']);
            $lieuObject->setLocaux($lieu['locaux']);
            $lieuObject->setIdInstitution($lieu['id_institution']);
            $lieuObject->setIdAdresse($lieu['id_adresse']);
           
            // Ajouter l'objet lieu au tableau
            $lieuObjects[] = $lieuObject;
        }

        return $lieuObjects;
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}


public function deleteLieu($id)
{
    $sql = "DELETE FROM lieu WHERE id_lieu=:id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $success = $prep->execute();

        
        if ($success) {
            return true; // Retourne true si la suppression ok
        } else {
            return false; // Retourne false si la suppression ko
        }
    } catch (PDOException $e) {
        
        error_log('Erreur lors de la suppression du lieu : ' . $e->getMessage());
        throw new Exception('Erreur lors de la suppression du lieu.');
    } finally {
        $prep = null;
    }
}

 /* public function deleteLieu2($id)
  {
    $sql = "DELETE FROM lieu WHERE id_lieu=:id";
    try {
      $prep = $this->db->prepare($sql);
      $prep->bindParam(':id', $id, PDO::PARAM_INT);
      $prep->execute();
    } catch (PDOException $e) {
      die($e->getMessage());
    } finally {
      $prep = null;
    }
  }*/

 
  


  public function updateLieu($lieu)
{
    $sql = "UPDATE lieu SET 
            nom = :nom,
            batiment = :batiment,
            locaux = :locaux,
            id_institution = :id_institution,
            id_adresse = :id_adresse
            WHERE id_lieu = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet User
        $prep->bindParam(':nom', $lieu->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':batiment', $lieu->getBatiment(), PDO::PARAM_STR);
        $prep->bindParam(':locaux', $lieu->getLocaux(), PDO::PARAM_STR);
        $prep->bindParam(':id_institution', $lieu->getIdInstitution(), PDO::PARAM_STR);
        $prep->bindParam(':id_adresse', $lieu->getIdAdresse(), PDO::PARAM_STR);
        $prep->bindParam(':id', $lieu->getIdLieu(), PDO::PARAM_INT); // ID de l'lieu à mettre à jour

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function addLieu($lieu)
{
    $sql = "INSERT INTO lieu(civilite, nom, prenom, email, mot_de_passe, gsm, TVA, profession, gsm_pro, email_pro, id_role, id_institution, id_adresse) 
            VALUES (:civilite, :nom, :prenom, :email, :mot_de_passe, :gsm, :TVA, :profession, :gsm_pro, :email_pro, :id_role, :id_institution, :id_adresse)";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet User
        $prep->bindParam(':civilite', $lieu->getCivilite(), PDO::PARAM_STR);
        $prep->bindParam(':nom', $lieu->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':prenom', $lieu->getPrenom(), PDO::PARAM_STR);
        $prep->bindParam(':email', $lieu->getEmail(), PDO::PARAM_STR);
        $prep->bindParam(':mot_de_passe', $lieu->getMotDePasse(), PDO::PARAM_STR);
        $prep->bindParam(':gsm', $lieu->getGsm(), PDO::PARAM_STR);
        $prep->bindParam(':TVA', $lieu->getTva(), PDO::PARAM_STR);
        $prep->bindParam(':profession', $lieu->getProfession(), PDO::PARAM_STR);
        $prep->bindParam(':gsm_pro', $lieu->getGsmPro(), PDO::PARAM_STR);
        $prep->bindParam(':email_pro', $lieu->getEmailPro(), PDO::PARAM_STR);
        $prep->bindParam(':id_role', $lieu->getIdRole(), PDO::PARAM_INT);
        $prep->bindParam(':id_institution', $lieu->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $lieu->getIdAdresse(), PDO::PARAM_INT);

        $prep->execute();

        $lieu->setId($this->db->lastInsertId());
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null;
    }
}

}