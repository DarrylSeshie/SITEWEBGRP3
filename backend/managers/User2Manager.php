<?php

class UserManager
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUsers($page, $pageSize)
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
                r.nom AS role_nom,
                r.giografie AS giografie
            FROM
                utilisateur u
            LEFT JOIN
                Adresse a ON u.id_adresse = a.id_adresse
            LEFT JOIN
                institution i ON u.id_institution = i.id_institution
            LEFT JOIN
                role r ON u.id_role = r.id_role
            WHERE
                u.id_role IN (4, 3, 2)
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

    public function getAllUsers()
    {
        $users = [];

        // Requête SQL pour récupérer tous les utilisateurs avec leurs informations complètes
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
                r.nom AS role_nom,
                u.giografie
            FROM
                utilisateur u
            LEFT JOIN
                Adresse a ON u.id_adresse = a.id_adresse
            LEFT JOIN
                institution i ON u.id_institution = i.id_institution
            LEFT JOIN
                role r ON u.id_role = r.id_role";

        try {
            $prep = $this->db->prepare($sql);
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
                    'giografie' => $userData['giografie'],
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

    // Other methods for UserManager...

    public function selectUserByEmail($userEmail)
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
            r.nom AS role_nom,
            u.giografie
        FROM
            utilisateur u
        LEFT JOIN Adresse a ON u.id_adresse = a.id_adresse
        LEFT JOIN institution i ON u.id_institution = i.id_institution
        LEFT JOIN role r ON u.id_role = r.id_role
        WHERE
           u.email = :userEmail LIMIT 1
        ";
    
        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':userEmail', $userEmail, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour les chaînes
            $prep->execute();
    
            $userData = $prep->fetch(PDO::FETCH_OBJ);
    
            if (!$userData) {
                return null; // Aucun utilisateur trouvé avec cet email
            }
    
            return $userData; // Retournez directement l'objet userData
        } catch (PDOException $e) {
            throw $e; // Propager l'exception pour la gestion des erreurs
        } finally {
            $prep = null; // Libérer la ressource PDOStatement
        }
    }

    public function selectUserById($userId)
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
            r.nom AS role_nom,
            u.giografie
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
                'giografie' => $userData['giografie'],
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

    public function deleteUser($id)
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

    public function updateUser($user)
    {
        $sql = "UPDATE Utilisateur 
        SET  civilite = :civilite,
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
            $prep->bindValue(':civilite', $user-> getCivilite(), PDO::PARAM_STR);
            $prep->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
            $prep->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
            $prep->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $prep->bindValue(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $prep->bindValue(':gsm', $user->getGsm(), PDO::PARAM_STR);
            $prep->bindValue(':TVA', $user-> getTVA(), PDO::PARAM_STR);
            $prep->bindValue(':profession', $user->getProfession(), PDO::PARAM_STR);
            $prep->bindValue(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
            $prep->bindValue(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
            $prep->bindValue(':id_role', $user-> getRole()->getIdRole(), PDO::PARAM_INT);
            $prep->bindValue(':id_institution', $user->getInstitution()->getIdInstitution(), PDO::PARAM_INT);
            $prep->bindValue(':id_adresse', $user->getAddress()->getIdAdresse(), PDO::PARAM_INT);
            $prep->bindValue(':id', $user->getId(), PDO::PARAM_INT); // ID de l'utilisateur à mettre à jour

            $prep->execute();
        } catch (PDOException $e) {
            throw $e; // Propager l'exception pour la gestion des erreurs
        } finally {
            $prep = null; // Libérer la ressource PDOStatement
        }
    }

    public function updateRole(User $user)
    {
        // Début de la transaction
        $this->db->beginTransaction();

        try {
            // Requête SQL pour mettre à jour le rôle de l'utilisateur
            $sql = "
                UPDATE utilisateur u
                LEFT JOIN role r ON u.id_role = r.id_role
                SET u.id_role = :newRoleId
                WHERE u.id_utilisateur = :userId
            ";

            $prep = $this->db->prepare($sql);

            // Récupérer l'identifiant de l'utilisateur et le nouvel identifiant de rôle à partir de l'objet User
            $userId = $user->getId();
            $newRoleId = $user->getIdRole();

            $prep->bindParam(':newRoleId', $newRoleId, PDO::PARAM_INT);
            $prep->bindParam(':userId', $userId, PDO::PARAM_INT);
            $prep->execute();

            // Valider la transaction si tout s'est bien passé
            $this->db->commit();

            // Retourner true pour indiquer que la mise à jour a réussi
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->db->rollBack();
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
            $prep->bindValue(':civilite', $user->getCivilite(), PDO::PARAM_STR);
            $prep->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
            $prep->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
            $prep->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $prep->bindValue(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $prep->bindValue(':gsm', $user->getGsm(), PDO::PARAM_STR);
            $prep->bindValue(':TVA', $user->getTVA(), PDO::PARAM_STR);
            $prep->bindValue(':profession', $user->getProfession(), PDO::PARAM_STR);
            $prep->bindValue(':gsm_pro', $user->getGsmPro(), PDO::PARAM_STR);
            $prep->bindValue(':email_pro', $user->getEmailPro(), PDO::PARAM_STR);
            $prep->bindValue(':id_role', $user->getIdRole(), PDO::PARAM_INT);
            $prep->bindValue(':id_institution', $user->getIdInstitution(), PDO::PARAM_INT);
            $prep->bindValue(':id_adresse', $user->getIdAdresse(), PDO::PARAM_INT);

            $prep->execute();

            $user->setId($this->db->lastInsertId());
            return true; // Succès
        } catch (PDOException $e) {
            throw $e;
            return false;
        } 
    }

    public function count()
    {
        $sql = "SELECT COUNT(*) AS total FROM utilisateur";

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

    public function checkUser($username)
    {
        $user = null;
        $sql = "SELECT * from utilisateur where email=:email";
        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':email', $username, PDO::PARAM_STR);
            $prep->execute();
            $userArr = $prep->fetch(PDO::FETCH_ASSOC);
            $user = new User($userArr);
        } catch (PDOException $e) {
            die($e->getMessage());
        } finally {
            $prep = null;
        }
        return $user;
    }

    public function getUserIdByUsername($username)
    {
        $sql = "SELECT id_utilisateur FROM utilisateur WHERE email = :email";
        $prep = $this->db->prepare($sql);
        $prep->bindParam(':email', $username, PDO::PARAM_STR);
        $prep->execute();
        $result = $prep->fetch(PDO::FETCH_ASSOC);
        return ($result) ? $result['id_utilisateur'] : null;
    }
}
?>