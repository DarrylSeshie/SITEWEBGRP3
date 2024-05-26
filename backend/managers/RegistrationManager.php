<?php

class RegistrationManager
{
  private $db;
  public function __construct($db)
  {
    $this->db = $db;
  }

  public function saveUser($user)
  {
    try {
        // Insérer l'adresse
        $sqlAdresse = "INSERT INTO Adresse (rue_numero, code_postal, localite, pays) 
                       VALUES (:rueNumero, :codePostal, :localite, :pays)";
        $prepAdresse = $this->db->prepare($sqlAdresse);
        $prepAdresse->bindValue(':rueNumero', $user->getAddress()->getRueNumero(), PDO::PARAM_STR);
        $prepAdresse->bindValue(':codePostal', $user->getAddress()->getCodePostal(), PDO::PARAM_INT);
        $prepAdresse->bindValue(':localite', $user->getAddress()->getLocalite(), PDO::PARAM_STR);
        $prepAdresse->bindValue(':pays', $user->getAddress()->getPays(), PDO::PARAM_STR);
        $prepAdresse->execute();
        $adresseId = $this->db->lastInsertId();

        // Insérer l'utilisateur avec l'ID de l'adresse
        $sqlUser = "INSERT INTO Utilisateur (civilite, nom, prenom, email, mot_de_passe, gsm, TVA, profession, gsm_pro, email_pro, id_role, id_adresse) 
                    VALUES (:civilite, :nom, :prenom, :email, :mot_de_passe, :gsm, :TVA, :profession, :gsm_pro, :email_pro, :id_role, :id_adresse)";
        $prepUser = $this->db->prepare($sqlUser);
        // Liaisons pour les autres propriétés de l'utilisateur
        $prepUser->bindValue(':civilite', $user->getCivilite(), PDO::PARAM_STR);
        $prepUser->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
        $prepUser->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $prepUser->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $prepUser->bindValue(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
        $prepUser->bindValue(':gsm', $user->getGsm(), PDO::PARAM_STR);
        $prepUser->bindValue(':TVA', $user->getTVA(), PDO::PARAM_STR);
        $prepUser->bindValue(':profession', $user->getProfession(), PDO::PARAM_STR);
        $prepUser->bindValue(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
        $prepUser->bindValue(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
        // Liaison pour l'ID de rôle fixé à 4
        $idRole = 4; // Définir l'ID de rôle à 4
        $prepUser->bindValue(':id_role', $idRole, PDO::PARAM_INT);
        //$prepUser->bindValue(':id_institution', $user->getIdInstitution(), PDO::PARAM_INT); // Cette ligne est commentée, assurez-vous qu'elle n'est pas nécessaire
        // Liaison pour l'ID de l'adresse associée à l'utilisateur
        $prepUser->bindValue(':id_adresse', $adresseId, PDO::PARAM_INT);
        $prepUser->execute() ;
        $user->setId($this->db->lastInsertId());

        return true;
    } catch (PDOException $e) {
        throw $e;
        return false;
    } finally {
        // Libérer les ressources
        $prepAdresse = null;
        $prepUser = null;
    }
  }
}
