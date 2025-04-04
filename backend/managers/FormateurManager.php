<?php



class FormateurManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

 
  public function getFormateurs($page, $pageSize)
  {
      $users = [];
  
      // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
      $offset = ($page - 1) * $pageSize;
  
      // Requête SQL avec jointures pour récupérer les utilisateurs avec leurs informations complètes
      $sql = "
          SELECT
              u.id_utilisateur,
              u.civilite,
              u.nom,
              u.prenom,
              u.email,
              u.mot_de_passe,
              u.gsm,
              u.TVA,
              u.profession,
              u.gsm_pro,
              u.email_pro,
              u.id_role,
              u.id_institution,
              u.id_adresse,
              a.rue_numero AS adresse_rue_numero,
              a.code_postal AS adresse_code_postal,
              a.localite AS adresse_localite,
              a.pays AS adresse_pays,
              i.nom AS institution_nom,
              i.logo AS institution_logo,
              i.id_adresse AS institution_id_adresse,
              r.nom AS role_nom
          FROM
              utilisateur u
          LEFT JOIN
              Adresse a ON u.id_adresse = a.id_adresse
          LEFT JOIN
              institution i ON u.id_institution = i.id_institution
          LEFT JOIN
              role r ON u.id_role = r.id_role
          WHERE
              u.id_role IN (3)
          LIMIT :offset, :pageSize";
  
      try {
          $prep = $this->db->prepare($sql);
          $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
          $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
          $prep->execute();
          $result = $prep->fetchAll(PDO::FETCH_ASSOC);
  
          foreach ($result as $userData) {
              // Créer un nouvel objet User en utilisant les données récupérées
              $user = new User([
                  'id_utilisateur' => $userData['id_utilisateur'],
                  'civilite' => $userData['civilite'],
                  'nom' => $userData['nom'],
                  'prenom' => $userData['prenom'],
                  'email' => $userData['email'],
                  'mot_de_passe' => $userData['mot_de_passe'],
                  'gsm' => $userData['gsm'],
                  'TVA' => $userData['TVA'],
                  'profession' => $userData['profession'],
                  'gsm_pro' => $userData['gsm_pro'],
                  'email_pro' => $userData['email_pro'],
                  'id_role' => $userData['id_role'],
                  'id_institution' => $userData['id_institution'],
                  'id_adresse' => $userData['id_adresse'],
                  'adresse' => [
                      'id_adresse' => $userData['id_adresse'],
                      'rue_numero' => $userData['adresse_rue_numero'],
                      'code_postal' => $userData['adresse_code_postal'],
                      'localite' => $userData['adresse_localite'],
                      'pays' => $userData['adresse_pays']
                  ],
                  'institution' => [
                      'id_institution' => $userData['id_institution'],
                      'nom' => $userData['institution_nom'],
                      'logo' => $userData['institution_logo'],
                      'id_adresse' => $userData['institution_id_adresse']
                  ],
                  'role' => [
                      'id_role' => $userData['id_role'],
                      'nom' => $userData['role_nom']
                  ]
              ]);
  
              // Ajouter l'objet User créé au tableau $users
              $users[] = $user;
          }
      } catch (PDOException $e) {
          throw $e; // Propager l'exception pour la gestion des erreurs
      } finally {
          $prep = null; // Libérer la ressource PDOStatement
      }
  
      return $users;
  }




  
public function count()
{
    $sql = "SELECT COUNT(*) AS total FROM utilisateur WHERE  id_role = 3";

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
  
  
public function getFormateursByname2($page, $pageSize,$nom)
{ 

 $users = []; // Initialise un tableau vide pour stocker les objets User

    // Calculer le décalage (offset) en fonction du numéro de page et de la taille de la page
    $offset = ($page - 1) * $pageSize;

    // Requête SQL avec LIMIT pour pagination
    $sql = "SELECT * FROM utilisateur WHERE nom LIKE :nom AND  id_role = 3 LIMIT :offset, :pageSize";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':offset', $offset, PDO::PARAM_INT);
        $prep->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
        $prep->bindValue(':nom', '%' . $nom . '%', PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $userData) {
            // Créer un nouvel objet User à partir des données de la base de données
            $user = new User();
            $user->setId($userData['id_utilisateur']);
            $user->setCivilite($userData['civilite']);
            $user->setNom($userData['nom']);
            $user->setPrenom($userData['prenom']);
            $user->setEmail($userData['email']);
            $user->setGsm($userData['gsm']);
            $user->setProfession($userData['profession']);
            $user->setIdAdresse($userData[ 'id_adresse'] );
            $user->setIdInstitution($userData[ 'id_institution'] );
            $user->setTVA($userData[ 'TVA'] );
            // Ajouter l'objet User au tableau $users
            $users[] = $user;
        }
    } catch (PDOException $e) {
        // Gérer l'erreur de requête SQL
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $users;

}




  /**
   * @param User $user
   */

   public function selectFormateurById($userId)
   {
       $sql = "
       SELECT
           u.id_utilisateur,
           u.civilite,
           u.nom,
           u.prenom,
           u.email,
           u.mot_de_passe,
           u.gsm,
           u.TVA,
           u.profession,
           u.gsm_pro,
           u.email_pro,
           u.id_role,
           u.id_institution,
           u.id_adresse,
           a.rue_numero AS adresse_rue_numero,
           a.code_postal AS adresse_code_postal,
           a.localite AS adresse_localite,
           a.pays AS adresse_pays,
           i.nom AS institution_nom,
           i.logo AS institution_logo,
           i.id_adresse AS institution_id_adresse,
           r.nom AS role_nom
       FROM
           utilisateur u
           LEFT JOIN Adresse a ON u.id_adresse = a.id_adresse
       LEFT JOIN
           institution i ON u.id_institution = i.id_institution
       LEFT JOIN
           role r ON u.id_role = r.id_role
       WHERE
           u.id_utilisateur = :userId
   ";
   
       try {
           $prep = $this->db->prepare($sql);
           $prep->bindParam(':userId', $userId, PDO::PARAM_INT);
           $prep->execute();
   
           $userData = $prep->fetch(PDO::FETCH_ASSOC);
   
           if (!$userData) {
               return null; // Aucun utilisateur trouvé avec cet ID
           }
   
           // Création d'un nouvel objet User en utilisant les données appropriées avec gestion des clés
           $user = new User([
               'id_utilisateur' => $userData['id_utilisateur'],
               'civilite' => $userData['civilite'],
               'nom' => $userData['nom'],
               'prenom' => $userData['prenom'],
               'email' => $userData['email'],
               'mot_de_passe' => $userData['mot_de_passe'],
               'gsm' => $userData['gsm'],
               'TVA' => $userData['TVA'],
               'profession' => $userData['profession'],
               'gsm_pro' => $userData['gsm_pro'],
               'email_pro' => $userData['email_pro'],
               'id_role' => $userData['id_role'],
               'id_institution' => $userData['id_institution'],
               'id_adresse' => $userData['id_adresse'],
               'adresse' => [
                   'id_adresse' => $userData['id_adresse'],
                   'rue_numero' => $userData['adresse_rue_numero'] ?? null,
                   'code_postal' => $userData['adresse_code_postal'] ?? null,
                   'localite' => $userData['adresse_localite'] ?? null,
                   'pays' => $userData['adresse_pays'] ?? null
               ],
               'institution' => [
                   'id_institution' => $userData['id_institution'],
                   'nom' => $userData['institution_nom'] ?? null,
                   'logo' => $userData['institution_logo'] ?? null,
                   'id_adresse' => $userData['institution_id_adresse'] ?? null
               ],
               'role' => [
                   'id_role' => $userData['id_role'],
                   'nom' => $userData['role_nom'] ?? null
               ]
           ]);
   
           return $user;
       } catch (PDOException $e) {
           throw $e; // Propager l'exception pour la gestion des erreurs
       } finally {
           $prep = null; // Libérer la ressource PDOStatement
       }
   }
   // methode ok mais trop long
   
   


  public function deleteFormateur($id)
  {
    $sql = "DELETE FROM utilisateur WHERE id_utilisateur=:id";
    try {
      $prep = $this->db->prepare($sql);
      $prep->bindParam(':id', $id, PDO::PARAM_INT);
      $prep->execute();
    } catch (PDOException $e) {
      die($e->getMessage());
    } finally {
      $prep = null;
    }
  }


  public function updateFormateur($user)
{
    $sql = "UPDATE Utilisateur SET 
            civilite = :civilite,
            nom = :nom,
            prenom = :prenom,
            email = :email,
            mot_de_passe = :mot_de_passe,
            gsm = :gsm,
            TVA = :TVA,
            profession = :profession,
            gsm_pro = :gsm_pro,
            email_pro = :email_pro,
            id_role = :id_role,
            id_institution = :id_institution,
            id_adresse = :id_adresse
            WHERE id_utilisateur = :id";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet User
        $prep->bindParam(':civilite', $user->getCivilite(), PDO::PARAM_STR);
        $prep->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $prep->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $prep->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
        $prep->bindParam(':gsm', $user->getGsm(), PDO::PARAM_STR);
        $prep->bindParam(':TVA', $user->getTva(), PDO::PARAM_STR);
        $prep->bindParam(':profession', $user->getProfession(), PDO::PARAM_STR);
        $prep->bindParam(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
        $prep->bindParam(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
        $prep->bindParam(':id_role', $user->getIdRole(), PDO::PARAM_INT);
        $prep->bindParam(':id_institution', $user->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $user->getIdAdresse(), PDO::PARAM_INT);
        $prep->bindParam(':id', $user->getId(), PDO::PARAM_INT); // ID de l'utilisateur à mettre à jour

        $prep->execute();
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}



public function addFormateur($user)
{
    $sql = "INSERT INTO Utilisateur(civilite, nom, prenom, email, mot_de_passe, gsm, TVA, profession, gsm_pro, email_pro, id_role, id_institution, id_adresse) 
            VALUES (:civilite, :nom, :prenom, :email, :mot_de_passe, :gsm, :TVA, :profession, :gsm_pro, :email_pro, :id_role, :id_institution, :id_adresse)";

    try {
        $prep = $this->db->prepare($sql);

        // Liaison des paramètres avec les valeurs de l'objet User
        $prep->bindParam(':civilite', $user->getCivilite(), PDO::PARAM_STR);
        $prep->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
        $prep->bindParam(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $prep->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $prep->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
        $prep->bindParam(':gsm', $user->getGsm(), PDO::PARAM_STR);
        $prep->bindParam(':TVA', $user->getTva(), PDO::PARAM_STR);
        $prep->bindParam(':profession', $user->getProfession(), PDO::PARAM_STR);
        $prep->bindParam(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
        $prep->bindParam(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
        $prep->bindParam(':id_role', $user->getIdRole(), PDO::PARAM_INT);
        $prep->bindParam(':id_institution', $user->getIdInstitution(), PDO::PARAM_INT);
        $prep->bindParam(':id_adresse', $user->getIdAdresse(), PDO::PARAM_INT);

        $prep->execute();

        $user->setId($this->db->lastInsertId());
    } catch (PDOException $e) {
        throw $e;
    } finally {
        $prep = null;
    }
}

}