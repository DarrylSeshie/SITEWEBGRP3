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
        // Vérifier si tous les champs requis sont renseignés
        if (
            empty($user->getCivilite()) ||
            empty($user->getNom()) ||
            empty($user->getPrenom()) ||
            empty($user->getEmail()) ||
            empty($user->getMotDePasse()) ||
            empty($user->getGsm()) ||
            empty($user->getTVA()) ||
            empty($user->getProfession()) ||
            empty($user->getAddress()->getRueNumero()) ||
            empty($user->getAddress()->getCodePostal()) ||
            empty($user->getAddress()->getLocalite()) ||
            empty($user->getAddress()->getPays())
        ) {
            // Si un champ requis est vide, retourner false
            return false;
        }

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

            $hashedPassword = password_hash($user->getMotDePasse(), PASSWORD_DEFAULT);

            // Insérer l'institution si elle est définie
            $institutionId = null;
            if ($user->getIdInstitution() && $user->getIdInstitution() != -1) {
                $institutionId = $user->getIdInstitution();
            } else if ($user->getInstitution() && !empty($user->getInstitution()->getNom())) {
                $institution = $user->getInstitution();
                $sqlInstitution =  "INSERT INTO institution (nom, logo, id_adresse) 
                VALUES (:nom, :logo, :id_adresse)";
                $prepInstitution = $this->db->prepare($sqlInstitution);
                $prepInstitution->bindValue(':nom', $institution->getNom(), PDO::PARAM_STR);
                $prepInstitution->bindValue(':logo', $institution->getLogo(), PDO::PARAM_STR);
                $prepInstitution->bindValue(':id_adresse', $adresseId, PDO::PARAM_INT);
                $prepInstitution->execute();
                $institutionId = $this->db->lastInsertId();
            }

            // Insérer l'utilisateur avec l'ID de l'adresse et l'ID de l'institution
            $sqlUser = "INSERT INTO Utilisateur (civilite, nom, prenom, email, mot_de_passe, gsm, TVA, profession, gsm_pro, email_pro, id_role, id_adresse, id_institution) 
                        VALUES (:civilite, :nom, :prenom, :email, :mot_de_passe, :gsm, :TVA, :profession, :gsm_pro, :email_pro, :id_role, :id_adresse, :id_institution)";
            $prepUser = $this->db->prepare($sqlUser);
            // Liaisons pour les autres propriétés de l'utilisateur
            $prepUser->bindValue(':civilite', $user->getCivilite(), PDO::PARAM_STR);
            $prepUser->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
            $prepUser->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
            $prepUser->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $prepUser->bindValue(':mot_de_passe', $hashedPassword, PDO::PARAM_STR);
            $prepUser->bindValue(':gsm', $user->getGsm(), PDO::PARAM_STR);
            $prepUser->bindValue(':TVA', $user->getTVA(), PDO::PARAM_STR);
            $prepUser->bindValue(':profession', $user->getProfession(), PDO::PARAM_STR);
            $prepUser->bindValue(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
            $prepUser->bindValue(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
            // Liaison pour l'ID de rôle fixé à 4
            $idRole = 4; // Définir l'ID de rôle à 4
            $prepUser->bindValue(':id_role', $idRole, PDO::PARAM_INT);
            // Liaison pour l'ID de l'adresse associée à l'utilisateur
            $prepUser->bindValue(':id_adresse', $adresseId, PDO::PARAM_INT);
            // Liaison pour l'ID de l'institution associée à l'utilisateur
            $prepUser->bindValue(':id_institution', $institutionId, PDO::PARAM_INT);
            $prepUser->execute();
            $user->setId($this->db->lastInsertId());

            return true;
        } catch (PDOException $e) {
            throw $e;
            return false;
        } finally {
            // Libérer les ressources
            $prepAdresse = null;
            $prepUser = null;
            $prepInstitution = null;
        }
    }
}
?>
