<?php

class RegistrationManager
{

  private $db;

  public function saveUser($user)
{
    try {

        // Insérer l'adresse
        $sqlAdresse = "INSERT INTO adresse (rue_numero, code_postal, localite, pays) VALUES (:rue_numero, :code_postal, :localite, :pays)";
        $prepAdresse = $this->db->prepare($sqlAdresse);
        $prepAdresse->bindParam(':rue_numero', $user->getAdresse()->getRueNumero(), PDO::PARAM_STR);
        $prepAdresse->bindParam(':code_postal', $user->getAdresse()->getCodePostal(), PDO::PARAM_INT);
        $prepAdresse->bindParam(':localite', $user->getAdresse()->getLocalite(), PDO::PARAM_STR);
        $prepAdresse->bindParam(':pays', $user->getAdresse()->getPays(), PDO::PARAM_STR);
        $prepAdresse->execute();
        $adresseId = $this->db->lastInsertId();

        // Insérer l'utilisateur avec l'ID de l'adresse
        $sqlUser = "INSERT INTO users (civilite, nom, prenom, email, mot_de_passe, gsm, TVA, profession, gsm_pro, email_pro, id_role, id_institution, adresse_id) 
                    VALUES (:civilite, :nom, :prenom, :email, :mot_de_passe, :gsm, :TVA, :profession, :gsm_pro, :email_pro, :id_role, :id_institution, :adresse_id)";
        $prepUser = $this->db->prepare($sqlUser);
        // Liaisons pour les autres propriétés de l'utilisateur
        $prepUser->bindParam(':civilite', $user->getCivilite(), PDO::PARAM_STR);
        $prepUser->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
        $prepUser->bindParam(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $prepUser->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $prepUser->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
        $prepUser->bindParam(':gsm', $user->getGsm(), PDO::PARAM_STR);
        $prepUser->bindParam(':TVA', $user->getTVA(), PDO::PARAM_STR);
        $prepUser->bindParam(':profession', $user->getProfession(), PDO::PARAM_STR);
        $prepUser->bindParam(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
        $prepUser->bindParam(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
        // Liaison pour l'ID de rôle fixé à 4
        $idRole = 4; // Définir l'ID de rôle à 4
        $prepUser->bindParam(':id_role', $idRole, PDO::PARAM_INT);
        //$prepUser->bindParam(':id_institution', $user->getIdInstitution(), PDO::PARAM_INT);
        // Liaison pour l'ID de l'adresse associée à l'utilisateur
        $prepUser->bindParam(':adresse_id', $adresseId, PDO::PARAM_INT);
        $prepUser->execute();
        $user->setIdUtilisateur($this->db->lastInsertId());
        
      } catch (PDOException $e) {
        throw $e;
      } finally {
        $prep = null;
      }
    }

  
}
