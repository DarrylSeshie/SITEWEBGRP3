<?php



class TypeProduitManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }
  public function getTypeProduits()
  {
      $Tproduits = []; // Initialise un tableau vide pour stocker les objets Produit
  
      
      $sql = "SELECT * FROM typeproduit";
      try {
          $prep = $this->db->prepare($sql);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $TypproduitData) {
              // Créer un nouvel objet Produit à partir des données de la base de données
              $produit = new TypeProduit(
                  $TypproduitData['id_type_produit'],
                  $TypproduitData['nom']
                 
                 
              );
              // Ajouter le produit à la liste des produits
              $Tproduits[] = $produit;
          }
      } catch (PDOException $e) {
          // Gérer l'erreur de requête SQL
          die($e->getMessage());
      } finally {
          $prep = null;
      }
  
      return $Tproduits;
  }
  

  /**
   * @param Formation $formation
   */
 

public function selectTypeProduitById($prodId)
{
    $sql = "SELECT * FROM typeproduit WHERE id_type_produit = :TprodId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':TprodId', $prodId, PDO::PARAM_INT);
        $prep->execute();

        $produitData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$produitData) {
            return null; // Aucun produit trouvé avec cet ID
        }

        // Création d'un nouvel objet Produit à partir des données récupérées
        $produit = new TypeProduit(
            $produitData['id_type_produit'],
            $produitData['nom']
           
        );

        return $produit;
    } catch (PDOException $e) {
        throw $e; // Lancer l'exception 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function deleteTypeProduit($id)
{
    $sql = "DELETE FROM typeproduit WHERE id_type_produit = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression  : ' . $e->getMessage());
    }
}

 

public function updateTypeProduit($prod)
{
    $sql = "UPDATE produit SET 
            nom = :nom,
            WHERE id_type_produit = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Produit
        $prep->bindParam(':nom', $prod->getTitre(), PDO::PARAM_STR);
        $prep->bindParam(':id', $prod->getIdProduit(), PDO::PARAM_INT);

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Lancer l'exception 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}

public function addTypeProduit($typeProduit)
{
    $sql = "INSERT INTO typeproduit (nom) VALUES (:nom)";

    try {
        $prep = $this->db->prepare($sql);
        $nom = $typeProduit->getNom();

        $prep->bindParam(':nom', $nom, PDO::PARAM_STR);
        $prep->execute();
        // Attribution de l'ID du type de produit inséré à l'objet TypeProduit
        $typeProduit->setIdTypeProduit($this->db->lastInsertId());
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null;
    }
}

}