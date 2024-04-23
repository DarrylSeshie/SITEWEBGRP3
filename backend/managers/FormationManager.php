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
        $produits = [];

        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT * FROM produit LIMIT :offset, :pageSize";
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $produitData) {
            $produit = new Formation($produitData);
            $produits[] = $produit;
        }

        return $produits;
    }

    public function getProduitsByName($page, $pageSize, $nom)
    {
        $produits = [];
        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT * FROM produit WHERE titre LIKE :nom OR sous_titre LIKE :nom LIMIT :offset, :pageSize";
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $produitData) {
            $produit = new Formation($produitData);
            $produits[] = $produit;
        }

        return $produits;
    }


    public function getProduitsByname2($page, $pageSize,$nom)
    { 
    
        $produits = [];
        $offset = ($page - 1) * $pageSize;
    
        // Requête SQL avec LIMIT pour pagination
        $sql =  "SELECT * FROM produit WHERE titre LIKE :nom LIMIT :offset, :pageSize";
        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
            $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
            $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
            $prep->execute();
            $result = $prep->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($result as $prodData) {
                // Créer un nouvel objet User à partir des données de la base de données
                $prod = new Formation();
                $prod->setIdProduit($prodData['id_produit']);
                $prod->setTitre($prodData["titre"]);
                $prod->setSousTitre($prodData["sous_titre"]);
                $prod->setDateDebut($prodData["date_debut"]);
                $prod->setDateFin($prodData["date_fin"]);
                $prod->setDateFinInscription($prodData["date_fin_inscription"]);
                $prod->setDescriptif($prodData["descriptif"]);
                $prod->setObjectif($prodData["objectif"]);
                $prod->setContenu($prodData["contenu"]);
                $prod->setMethodologie($prodData["methodologie"]);
                $prod->setPublicCible($prodData["public_cible"]);
                $prod->setPrix($prodData["prix"]);
                $prod->setIdImage($prodData["id_image"]);
                $prod->setIdLieu($prodData["id_lieu"]);
                $prod->setIdTypeProduit($prodData["id_type_produit"]);


                // Ajouter l'objet User au tableau $users
                $produits[] = $prod;
            }
        } catch (PDOException $e) {
            // Gérer l'erreur de requête SQL
            die($e->getMessage());
        } finally {
            $prep = null;
        }
    
        return $produits;
    
    }
    




    public function selectProduitById($prodId)
    {
        $sql = "SELECT * FROM produit WHERE id_produit = :prodId";
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':prodId', $prodId, PDO::PARAM_INT);
        $prep->execute();
        $produitData = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$produitData) {
            return null; // Aucun produit trouvé avec cet ID
        }

        return new Formation($produitData);
    }

    public function deleteProduit($id)
    {
        $sql = "DELETE FROM produit WHERE id_produit = :id";
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':id', $id, PDO::PARAM_INT);
        $prep->execute();
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
        $prep->bindValue(':titre', $prod->getTitre(), PDO::PARAM_STR);
        $prep->bindValue(':sous_titre', $prod->getSousTitre(), PDO::PARAM_STR);
        $prep->bindValue(':date_debut', $prod->getDateDebut(), PDO::PARAM_STR);
        $prep->bindValue(':date_fin', $prod->getDateFin(), PDO::PARAM_STR);
        $prep->bindValue(':date_fin_inscription', $prod->getDateFinInscription(), PDO::PARAM_STR);
        $prep->bindValue(':descriptif', $prod->getDescriptif(), PDO::PARAM_STR);
        $prep->bindValue(':objectif', $prod->getObjectif(), PDO::PARAM_STR);
        $prep->bindValue(':contenu', $prod->getContenu(), PDO::PARAM_STR);
        $prep->bindValue(':methodologie', $prod->getMethodologie(), PDO::PARAM_STR);
        $prep->bindValue(':public_cible', $prod->getPublicCible(), PDO::PARAM_STR);
        $prep->bindValue(':prix', $prod->getPrix(), PDO::PARAM_INT);
        $prep->bindValue(':id_image', $prod->getIdImage(), PDO::PARAM_INT);
        $prep->bindValue(':id_lieu', $prod->getIdLieu(), PDO::PARAM_INT);
        $prep->bindValue(':id_type_produit', $prod->getIdTypeProduit(), PDO::PARAM_INT);
        $prep->bindValue(':id', $prod->getIdProduit(), PDO::PARAM_INT);

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
    }

    
    public function addProduit($prod)
    {
        $sql = "INSERT INTO produit (titre, sous_titre, date_debut, date_fin, date_fin_inscription, descriptif, objectif, contenu, methodologie, public_cible, prix, id_image, id_lieu, id_type_produit) 
            VALUES (:titre, :sous_titre, :date_debut, :date_fin, :date_fin_inscription, :descriptif, :objectif, :contenu, :methodologie, :public_cible, :prix, :id_image, :id_lieu, :id_type_produit)";

        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet Produit
        $prep->bindValue(':titre', $prod->getTitre(), PDO::PARAM_STR);
        $prep->bindValue(':sous_titre', $prod->getSousTitre(), PDO::PARAM_STR);
        $prep->bindValue(':date_debut', $prod->getDateDebut(), PDO::PARAM_STR);
        $prep->bindValue(':date_fin', $prod->getDateFin(), PDO::PARAM_STR);
        $prep->bindValue(':date_fin_inscription', $prod->getDateFinInscription(), PDO::PARAM_STR);
        $prep->bindValue(':descriptif', $prod->getDescriptif(), PDO::PARAM_STR);
        $prep->bindValue(':objectif', $prod->getObjectif(), PDO::PARAM_STR);
        $prep->bindValue(':contenu', $prod->getContenu(), PDO::PARAM_STR);
        $prep->bindValue(':methodologie', $prod->getMethodologie(), PDO::PARAM_STR);
        $prep->bindValue(':public_cible', $prod->getPublicCible(), PDO::PARAM_STR);
        $prep->bindValue(':prix', $prod->getPrix(), PDO::PARAM_INT);
        $prep->bindValue(':id_image', $prod->getIdImage(), PDO::PARAM_INT);
        $prep->bindValue(':id_lieu', $prod->getIdLieu(), PDO::PARAM_INT);
        $prep->bindValue(':id_type_produit', $prod->getIdTypeProduit(), PDO::PARAM_INT);

        $prep->execute();

        $prod->setIdProduit($this->db->lastInsertId()); // Définit l'ID du produit inséré dans l'objet Produit
    }
}

?>
