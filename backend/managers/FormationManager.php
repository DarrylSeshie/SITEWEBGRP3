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
    

        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT
        p.*,
        l.nom AS lieu_nom,
        l.batiment AS lieu_locaux,
        l.id_institution AS lieu_id_institution,
        l.id_adresse AS lieu_id_adresse,
        i.url_image AS image_url_image,
        i.nom AS image_nom,
        t.nom AS typeproduit_nom
    FROM
        produit p
    LEFT JOIN
        lieu l ON p.id_lieu = l.id_lieu
    LEFT JOIN
        image i ON p.id_image = i.id_image
    LEFT JOIN
        typeproduit t ON p.id_type_produit = t.id_type_produit
     LIMIT :offset, :pageSize";
     
         
        $produits = [];
     try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);


        foreach ($result as $prodData) {
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

            // Création des objets associés (Lieu, Image, TypeProduit)
            $lieu = new Lieu();
            $lieu->setNom($prodData['lieu_nom']);
            $lieu->setBatiment($prodData['lieu_locaux']);
            $lieu->setIdInstitution($prodData['lieu_id_institution']);
            $lieu->setIdAdresse($prodData['lieu_id_adresse']);
            $prod->setLieu($lieu);

            $image = new Image();
            $image->setUrlImage($prodData['image_url_image']);
            $image->setNom($prodData['image_nom']);
            $prod->setImage($image);

            $typeProduit = new TypeProduit();
            $typeProduit->setNom($prodData['typeproduit_nom']);
            $prod->setTypeProduit($typeProduit);

            $produits[] = $prod;
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $produits;

    }

    




    public function get3ProduitByDate()
{
    $currentDate = date("Y-m-d");

    // Requête SQL avec jointure pour récupérer les 3 produits futurs
    $sql = "
        SELECT
            p.*,
            l.nom AS lieu_nom,
            l.batiment AS lieu_locaux,
            l.id_institution AS lieu_id_institution,
            l.id_adresse AS lieu_id_adresse,
            i.url_image AS image_url_image,
            i.nom AS image_nom,
            t.nom AS typeproduit_nom
        FROM
            produit p
        LEFT JOIN
            lieu l ON p.id_lieu = l.id_lieu
        LEFT JOIN
            image i ON p.id_image = i.id_image
        LEFT JOIN
            typeproduit t ON p.id_type_produit = t.id_type_produit
        WHERE
            p.date_debut > :currentDate
        ORDER BY
            p.date_debut ASC
        LIMIT 3";

    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        $produits = [];

        foreach ($result as $prodData) {
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

            // Création des objets associés (Lieu, Image, TypeProduit)
            $lieu = new Lieu();
            $lieu->setNom($prodData['lieu_nom']);
            $lieu->setBatiment($prodData['lieu_locaux']);
            $lieu->setIdInstitution($prodData['lieu_id_institution']);
            $lieu->setIdAdresse($prodData['lieu_id_adresse']);
            $prod->setLieu($lieu);

            $image = new Image();
            $image->setUrlImage($prodData['image_url_image']);
            $image->setNom($prodData['image_nom']);
            $prod->setImage($image);

            $typeProduit = new TypeProduit();
            $typeProduit->setNom($prodData['typeproduit_nom']);
            $prod->setTypeProduit($typeProduit);

            $produits[] = $prod;
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $produits;
}



    public function getProduitsByname2($page, $pageSize,$nom)
    { 
    
        $produits = [];
        $offset = ($page - 1) * $pageSize;
    
        // Requête SQL avec LIMIT pour pagination
        $sql =  "

        SELECT
        p.*,
        l.nom AS lieu_nom,
        l.batiment AS lieu_locaux,
        l.id_institution AS lieu_id_institution,
        l.id_adresse AS lieu_id_adresse,
        i.url_image AS image_url_image,
        i.nom AS image_nom,
        t.nom AS typeproduit_nom
    FROM
        produit p
    LEFT JOIN
        lieu l ON p.id_lieu = l.id_lieu
    LEFT JOIN
        image i ON p.id_image = i.id_image
    LEFT JOIN
        typeproduit t ON p.id_type_produit = t.id_type_produit
        WHERE titre LIKE :nom LIMIT :offset, :pageSize
        ";
        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
            $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
            $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
            $prep->execute();
            $result = $prep->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($result as $prodData) {
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
    
                // Création des objets associés (Lieu, Image, TypeProduit)
                $lieu = new Lieu();
                $lieu->setNom($prodData['lieu_nom']);
                $lieu->setBatiment($prodData['lieu_locaux']);
                $lieu->setIdInstitution($prodData['lieu_id_institution']);
                $lieu->setIdAdresse($prodData['lieu_id_adresse']);
                $prod->setLieu($lieu);
    
                $image = new Image();
                $image->setUrlImage($prodData['image_url_image']);
                $image->setNom($prodData['image_nom']);
                $prod->setImage($image);
    
                $typeProduit = new TypeProduit();
                $typeProduit->setNom($prodData['typeproduit_nom']);
                $prod->setTypeProduit($typeProduit);
    
                $produits[] = $prod;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        } finally {
            $prep = null;
        }
    
        return $produits;
    
    }
    


    
    public function selectProduitById($prodId){

        $sql = "
        SELECT
        p.id_produit,
        p.titre,
        p.sous_titre,
        p.date_debut,
        p.date_fin,
        p.date_fin_inscription,
        p.descriptif,
        p.objectif,
        p.contenu,
        p.methodologie,
        p.public_cible,
        p.prix,
        p.id_image,
        p.id_lieu,
        p.id_type_produit,
        l.nom AS lieu_nom,
        l.batiment AS lieu_locaux,
        l.id_institution AS lieu_id_institution,
        l.id_adresse AS lieu_id_adresse,
        i.url_image AS image_url_image,
        i.nom AS image_nom,
        t.nom AS typeproduit_nom
    FROM
        Produit p
    LEFT JOIN
        Lieu l ON p.id_lieu = l.id_lieu
    LEFT JOIN
        Image i ON p.id_image = i.id_image
    LEFT JOIN
        TypeProduit t ON p.id_type_produit = t.id_type_produit
    WHERE
        p.id_produit = :prodId
    
    ";
    
        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':prodId', $prodId, PDO::PARAM_INT);
            $prep->execute();
    
            $formationData = $prep->fetch(PDO::FETCH_ASSOC);
    
            if (!$formationData) {
                return null; // Aucun utilisateur trouvé avec cet ID
            }
    
            $form = new Formation([
                'id_produit' => $formationData['id_produit'],
                'titre' => $formationData['titre'],
                'sous_titre' => $formationData['sous_titre'],
                'date_debut' => $formationData['date_debut'],
                'date_fin' => $formationData['date_fin'],
                'date_fin_inscription' => $formationData['date_fin_inscription'],
                'descriptif' => $formationData['descriptif'],
                'objectif' => $formationData['objectif'],
                'contenu' => $formationData['contenu'],
                'methodologie' => $formationData['methodologie'],
                'public_cible' => $formationData['public_cible'],
                'prix' => $formationData['prix'],
                'id_image' => $formationData['id_image'],
                'id_lieu' => $formationData['id_lieu'],
                'id_type_produit' => $formationData['id_type_produit'],
                'lieu' => [
                    'id_lieu' => $formationData['id_lieu'],
                    'nom' => $formationData['lieu_nom'] ?? null,
                    'batiment' => $formationData['lieu_batiment'] ?? null,
                    'locaux' => $formationData['lieu_locaux'] ?? null,
                    'id_institution' => $formationData['lieu_id_institution'] ?? null,
                    'id_adresse' => $formationData['lieu_id_adresse'] ?? null
                ],
                'image' => [
                    'id_image' => $formationData['id_image'],
                    'url_image' => $formationData['image_url_image'] ?? null,
                    'nom' => $formationData['image_nom'] ?? null
                ],
                'typeproduit' => [
                    'id_type_produit' => $formationData['id_type_produit'],
                    'nom' => $formationData['typeproduit_nom'] ?? null
                ]
            ]);
    
            return $form;
        } catch (PDOException $e) {
            throw $e; // Propager l'exception pour la gestion des erreurs
        } finally {
            $prep = null; // Libérer la ressource PDOStatement
        }



 


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

        $prep->execute();

        
        $prod->setIdProduit($this->db->lastInsertId());
        return true;  // Définit l'ID du produit inséré dans l'objet Produit
    } catch (PDOException $e) {
        // En cas d'erreur, renvoyer une réponse d'erreur
        throw $e;
        return false;
    }
    }
}

?>
