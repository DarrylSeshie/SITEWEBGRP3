<?php



class UserManager
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function getUsers()
{
    $users = []; // Initialise un tableau vide pour stocker les objets User

    $sql = "SELECT * FROM utilisateur";
    try {
        $prep = $this->db->prepare($sql);
        $prep->execute();
        $result = $prep->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $c) {
            $user = new User($c);
            $users[] = $user; // Ajoute l'objet User au tableau $users
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    } finally {
        $prep = null;
    }

    return $users;
}

  /**
   * @param User $user
   */
  public function selectUserById($userId)
{
    $sql = "SELECT * FROM Utilisateur WHERE id_utilisateur = :userId";
    try {
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':userId', $userId, PDO::PARAM_INT);
        $prep->execute();

        // Récupérer le résultat de la requête sous forme de tableau associatif
        $user = $prep->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null; // Aucun utilisateur trouvé avec cet ID
        }

        // Créer un nouvel objet User et définir ses propriétés
        $userObject = new User();
        $userObject->setId($user['id_utilisateur']);
        $userObject->setCivilite($user['civilite']);
        $userObject->setNom($user['nom']);
        $userObject->setPrenom($user['prenom']);
        $userObject->setEmail($user['email']);
        $userObject->setMotDePasse($user['mot_de_passe']);
        $userObject->setGsm($user['gsm']);
        $userObject->setTva($user['TVA']);
        $userObject->setProfession($user['profession']);
        $userObject->setGsmPro($user['gsm_pro']);
        $userObject->setEmailPro($user['email_pro']);
        $userObject->setIdRole($user['id_role']);
        $userObject->setIdInstitution($user['id_institution']);
        $userObject->setIdAdresse($user['id_adresse']);

        return $userObject;
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}

public function selectUsers()
{
    $sql = "SELECT * FROM Utilisateur";
    try {
        $prep = $this->db->prepare($sql);
        $prep->execute();

        // Récupérer tous les résultats de la requête sous forme de tableau associatif
        $users = $prep->fetchAll(PDO::FETCH_ASSOC);

        // Créer un tableau pour stocker les objets User
        $userObjects = [];

        // Parcourir les résultats et créer des objets User pour chaque utilisateur
        foreach ($users as $user) {
            $userObject = new User();
            $userObject->setId($user['id_utilisateur']);
            $userObject->setCivilite($user['civilite']);
            $userObject->setNom($user['nom']);
            $userObject->setPrenom($user['prenom']);
            $userObject->setEmail($user['email']);
            $userObject->setMotDePasse($user['mot_de_passe']);
            $userObject->setGsm($user['gsm']);
            $userObject->setTva($user['TVA']);
            $userObject->setProfession($user['profession']);
            $userObject->setGsmPro($user['gsm_pro']);
            $userObject->setEmailPro($user['email_pro']);
            $userObject->setIdRole($user['id_role']);
            $userObject->setIdInstitution($user['id_institution']);
            $userObject->setIdAdresse($user['id_adresse']);

            // Ajouter l'objet User au tableau
            $userObjects[] = $userObject;
        }

        return $userObjects;
    } catch (PDOException $e) {
        throw $e; // Propager l'exception pour la gestion des erreurs
    } finally {
        $prep = null; // Libérer la ressource PDOStatement
    }
}


  public function deleteUser($id)
  {
    $sql = "DELETE FROM utilisateur WHERE id=:id";
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


  public function updateUser($user)
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



public function addUser($user)
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