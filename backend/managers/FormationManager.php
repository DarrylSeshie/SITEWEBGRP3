<?php



class FormationManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }
  public function getProduits($page, $pageSize)
  {
      $produits = []; // Initialise un tableau vide pour stocker les objets Produit
  
      // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
      $offset = ($page - 1) * $pageSize;
  
      // Requête SQL avec LIMIT pour pagination
      $sql = "SELECT * FROM produit LIMIT :offset, :pageSize";
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
          $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $produitData) {
              // Créer un nouvel objet Produit à partir des données de la base de données
              $produit = new Formation(
                  $produitData['id_produit'],
                  $produitData['titre'],
                  $produitData['sous_titre'],
                  $produitData['date_debut'],
                  $produitData['date_fin'],
                  $produitData['date_fin_inscription'],
                  $produitData['descriptif'],
                  $produitData['objectif'],
                  $produitData['contenu'],
                  $produitData['methodologie'],
                  $produitData['public_cible'],
                  $produitData['prix'],
                  $produitData['id_image'],
                  $produitData['id_lieu'],
                  $produitData['id_type_produit']
              );
              // Ajouter le produit à la liste des produits
              $produits[] = $produit;
          }
      } catch (PDOException $e) {
          // Gérer l'erreur de requête SQL
          die($e->getMessage());
      } finally {
          $prep = null;
      }
  
      return $produits;
  }
  
  public function getProduitsByName($page, $pageSize, $nom)
  {
      $produits = []; // Initialise tb 
  
      $offset = ($page - 1) * $pageSize;
  
      // Requête SQL avec LIMIT pour pagination
      $sql = "SELECT * FROM produit WHERE titre LIKE :nom OR sous_titre LIKE :nom LIMIT :offset, :pageSize";
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
          $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
          $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $produitData) {
              // Créer un nouvel objet Produit à partir des données de la base de données
              $produit = new Formation(
                  $produitData['id_produit'],
                  $produitData['titre'],
                  $produitData['sous_titre'],
                  $produitData['date_debut'],
                  $produitData['date_fin'],
                  $produitData['date_fin_inscription'],
                  $produitData['descriptif'],
                  $produitData['objectif'],
                  $produitData['contenu'],
                  $produitData['methodologie'],
                  $produitData['public_cible'],
                  $produitData['prix'],
                  $produitData['id_image'],
                  $produitData['id_lieu'],
                  $produitData['id_type_produit']
              );
              // Ajouter le produit à la liste des produits
              $produits[] = $produit;
          }
      } catch (PDOException $e) {
          die($e->getMessage());
      } finally {
          $prep = null;
      }
  
      return $produits;
  }
  


  /**
   * @param Formation $formation
   */
 

public function selectProduitById($prodId)
{
    $sql = "SELECT * FROM produit WHERE id_produit = :imgId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':imgId', $prodId, PDO::PARAM_INT);
        $prep->execute();

        $produitData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$produitData) {
            return null; // Aucun produit trouvé avec cet ID
        }

        // Création d'un nouvel objet Produit à partir des données récupérées
        $produit = new Formation(
            $produitData['id_produit'],
            $produitData['titre'],
            $produitData['sous_titre'],
            $produitData['date_debut'],
            $produitData['date_fin'],
            $produitData['date_fin_inscription'],
            $produitData['descriptif'],
            $produitData['objectif'],
            $produitData['contenu'],
            $produitData['methodologie'],
            $produitData['public_cible'],
            $produitData['prix'],
            $produitData['id_image'],
            $produitData['id_lieu'],
            $produitData['id_type_produit']
        );

        return $produit;
    } catch (PDOException $e) {
        throw $e; // Lancer l'exception 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function deleteProduit($id)
{
    $sql = "DELETE FROM produit WHERE id_produit = :id";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
    } catch (PDOException $e) {
        // Gérer l'erreur de suppression du lieu
        throw new PDOException('Erreur lors de la suppression  : ' . $e->getMessage());
    }
}

 

public function updateProduit($prod)
{
    $sql = "UPDATE produit SET 
            titre = :titre,
            sous_titre = :sous_titre,
            date_debut = :date_debut,
            date_fin = :date_fin,
            date_fin_inscription = :date_fin_inscription,
            descriptif = :descriptif,
            objectif = :objectif,
            contenu = :contenu,
            methodologie = :methodologie,
            public_cible = :public_cible,
            prix = :prix,
            id_image = :id_image,
            id_lieu = :id_lieu,
            id_type_produit = :id_type_produit
            WHERE id_produit = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Produit
        $prep->bindParam(':titre', $prod->getTitre(), PDO::PARAM_STR);
        $prep->bindParam(':sous_titre', $prod->getSousTitre(), PDO::PARAM_STR);
        $prep->bindParam(':date_debut', $prod->getDateDebut(), PDO::PARAM_STR);
        $prep->bindParam(':date_fin', $prod->getDateFin(), PDO::PARAM_STR);
        $prep->bindParam(':date_fin_inscription', $prod->getDateFinInscription(), PDO::PARAM_STR);
        $prep->bindParam(':descriptif', $prod->getDescriptif(), PDO::PARAM_STR);
        $prep->bindParam(':objectif', $prod->getObjectif(), PDO::PARAM_STR);
        $prep->bindParam(':contenu', $prod->getContenu(), PDO::PARAM_STR);
        $prep->bindParam(':methodologie', $prod->getMethodologie(), PDO::PARAM_STR);
        $prep->bindParam(':public_cible', $prod->getPublicCible(), PDO::PARAM_STR);
        $prep->bindParam(':prix', $prod->getPrix(), PDO::PARAM_INT);
        $prep->bindParam(':id_image', $prod->getIdImage(), PDO::PARAM_INT);
        $prep->bindParam(':id_lieu', $prod->getIdLieu(), PDO::PARAM_INT);
        $prep->bindParam(':id_type_produit', $prod->getIdTypeProduit(), PDO::PARAM_INT);
        $prep->bindParam(':id', $prod->getIdProduit(), PDO::PARAM_INT);

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Lancer l'exception 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}


public function addProduit($prod)
{
    $sql = "INSERT INTO produit (titre, sous_titre, date_debut, date_fin, date_fin_inscription, descriptif, objectif, contenu, methodologie, public_cible, prix, id_image, id_lieu, id_type_produit) 
            VALUES (:titre, :sous_titre, :date_debut, :date_fin, :date_fin_inscription, :descriptif, :objectif, :contenu, :methodologie, :public_cible, :prix, :id_image, :id_lieu, :id_type_produit)";

    try {
        $prep = $this->db->prepare($sql);

        // Récupération des valeurs à partir de l'objet Produit
        $titre = $prod->getTitre();
        $sous_titre = $prod->getSousTitre();
        $date_debut = $prod->getDateDebut();
        $date_fin = $prod->getDateFin();
        $date_fin_inscription = $prod->getDateFinInscription();
        $descriptif = $prod->getDescriptif();
        $objectif = $prod->getObjectif();
        $contenu = $prod->getContenu();
        $methodologie = $prod->getMethodologie();
        $public_cible = $prod->getPublicCible();
        $prix = $prod->getPrix();
        $id_image = $prod->getIdImage();
        $id_lieu = $prod->getIdLieu();
        $id_type_produit = $prod->getIdTypeProduit();

        // Liaison des paramètres avec les valeurs de l'objet Produit
        $prep->bindParam(':titre', $titre, PDO::PARAM_STR);
        $prep->bindParam(':sous_titre', $sous_titre, PDO::PARAM_STR);
        $prep->bindParam(':date_debut', $date_debut, PDO::PARAM_STR);
        $prep->bindParam(':date_fin', $date_fin, PDO::PARAM_STR);
        $prep->bindParam(':date_fin_inscription', $date_fin_inscription, PDO::PARAM_STR);
        $prep->bindParam(':descriptif', $descriptif, PDO::PARAM_STR);
        $prep->bindParam(':objectif', $objectif, PDO::PARAM_STR);
        $prep->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $prep->bindParam(':methodologie', $methodologie, PDO::PARAM_STR);
        $prep->bindParam(':public_cible', $public_cible, PDO::PARAM_STR);
        $prep->bindParam(':prix', $prix, PDO::PARAM_INT);
        $prep->bindParam(':id_image', $id_image, PDO::PARAM_INT);
        $prep->bindParam(':id_lieu', $id_lieu, PDO::PARAM_INT);
        $prep->bindParam(':id_type_produit', $id_type_produit, PDO::PARAM_INT);

        $prep->execute();

        $prod->setIdProduit($this->db->lastInsertId()); // Définit l'ID du produit inséré dans l'objet Produit
    } catch (PDOException $e) {
        throw $e; // Lancer l'exception 
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



}