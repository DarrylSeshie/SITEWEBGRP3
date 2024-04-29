<?php



class AdresseManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getAdresses($page, $pageSize)
{ 

 $adresses = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM adresse  LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $adresseData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $adresse = new Adresse();
            $adresse->setIdAdresse($adresseData['id_adresse']);
            $adresse->setRueNumero($adresseData['rue_numero']);
            $adresse->setCodePostal($adresseData['code_postal']);
            $adresse->setLocalite($adresseData['localite']);
            $adresse->setPays($adresseData['pays']);
            $adresses[] = $adresse;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $adresses;

}

public function getAdresseByCodeP($page, $pageSize,$nom)
{ 

 $adresses = []; // Initialise un tableau vide pour stocker les objets Adresse

    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM adresse WHERE code_postal LIKE :nom LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $adresseData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $adresse = new Adresse();
            
            $adresse->setIdAdresse($adresseData['id_adresse']);
            $adresse->setRueNumero($adresseData['rue_numero']);
            $adresse->setCodePostal($adresseData['code_postal']);
            $adresse->setLocalite($adresseData['localite']);
            $adresse->setPays($adresseData['pays']);
            $adresses[] = $adresse;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $adresses;

}




  /**
   * @param Adresse $adresse
   */
  public function selectAdresseById($adresseId)
{
    $sql = "SELECT * FROM adresse WHERE id_adresse = :adresseId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':adresseId', $adresseId, PDO::PARAM_INT);
        $prep->execute();

        $adresseData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$adresseData) {
            return null; // Aucun lieu trouvé avec cet ID
        }

        // Création d'un nouvel objet adresse à partir des données récupérées
        $adresseObject = new Adresse($adresseData);

        return $adresseObject;
    } catch (PDOException $e) {
        throw $e; 
    } finally {
        $prep = null; 
    }
}



public function deleteAdresse($id)
{
    $sql = "DELETE FROM adresse WHERE id_adresse = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression adresse : ' . $e->getMessage());
    }
}

 

  public function updateAdresse($adresse)
{
    $sql = "UPDATE adresse SET 
            rue_numero = :rue_numero,
            code_postal = :code_postal,
            localite = :localite,
            pays = :pays
            WHERE id_adresse = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Adresse
        $prep->bindParam(':rue_numero', $adresse->getRueNumero(), PDO::PARAM_STR);
        $prep->bindParam(':code_postal', $adresse->getCodePostal(), PDO::PARAM_STR);
        $prep->bindParam(':localite', $adresse->getLocalite(), PDO::PARAM_STR);
        $prep->bindParam(':pays', $adresse->getPays(), PDO::PARAM_STR);
        $prep->bindParam(':id', $adresse->getIdAdresse(), PDO::PARAM_INT); 

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function addAdresse($adresse)
{
    $sql = "INSERT INTO Adresse (rue_numero, code_postal, localite, pays) 
            VALUES (:rueNumero, :codePostal, :localite, :pays)";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Adresse
        $prep->bindParam(':rueNumero', $adresse->getRueNumero(), PDO::PARAM_STR);
        $prep->bindParam(':codePostal', $adresse->getCodePostal(), PDO::PARAM_INT);
        $prep->bindParam(':localite', $adresse->getLocalite(), PDO::PARAM_STR);
        $prep->bindParam(':pays', $adresse->getPays(), PDO::PARAM_STR);

        $prep->execute();

        $adresse->setId($this->db->lastInsertId());
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null;
    }
}

}