<?php

require_once 'models/Institution.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/InstitutionManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$institutionManager = new InstitutionManager($connexion); // Utilisez le bon nom de classe pour le gestionnaire d'utilisateurs

$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

if ($http_method === "GET") {
    if (isset($_GET['search'])) {
        // Requête GET pour la recherche par nom
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
        $search = $_GET['search'];

        $institution = $institutionManager->getInstitutionsByName($page, $pageSize, $search);
        echo json_encode($institution);
    } elseif (isset($_GET['id'])) {
        // Requête GET pour récupérer un utilisateur par ID
        $id = $_GET['id'];
        try {
            $institution = $institutionManager->selectinstitutionById($id);
            if ($institution) {
                http_response_code(200);
                echo json_encode($institution);
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Lieu non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    }  elseif (isset($_GET['count'])) {
        // Requête GET pour obtenir le nombre total d'utilisateurs
        try {
        
            $totalUsers = $institutionManager->count();
    
            http_response_code(200);
            echo json_encode(['total' => $totalUsers]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    else {
        // Requête GET pour récupérer tous les utilisateurs avec pagination
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $institutions = $institutionManager->getInstitutions($page, $pageSize);
        echo json_encode($institutions);
    }
} elseif ($http_method === "POST") {
    
    // Récupérer les données JSON et l'URL de l'image
$jsonStr = file_get_contents('php://input');
$institutionArray = json_decode($jsonStr, true);

if (!empty($institutionArray)) {
    // Créer un nouvel objet Institution à partir des données JSON
    $institution = new Institution($institutionArray);

    // Récupérer l'URL de l'image depuis les données JSON
    $imageUrl = $institutionArray['logo'];

    // Stocker l'URL de l'image dans l'objet Institution (si besoin)
    $institution->setLogo($imageUrl);

    try {
        // Ajouter l'institution à la base de données via le gestionnaire
        $institutionManager->addInstitution($institution);

        // Répondre avec les données de l'institution ajoutée
        echo json_encode($institution);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, renvoyer un code HTTP 500 avec un message d'erreur
        http_response_code(500);
        echo json_encode(array("error" => "Erreur lors de l'ajout de l'institution : " . $e->getMessage()));
    }
} else {
    // Si les données JSON sont vides ou invalides
    http_response_code(400);
    echo json_encode(array("error" => "Données JSON invalides pour l'ajout d'institution"));
}
} elseif ($http_method === "PUT" || $http_method === "PATCH") {
    // Requête PUT ou PATCH pour mettre à jour un utilisateur existant
    $jsonStr = file_get_contents('php://input');
    $institutionArray = json_decode($jsonStr, true);
    $institution = new Institution($institutionArray);

    try {
        $institutionManager->updateInstitution($institution); 
        echo json_encode($institution); // Répondre avec les données de l'utilisateur mis à jour
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
}  elseif ($http_method === "DELETE") {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        try {
            $success = $institutionManager->deleteInstitution($id);

            if ($success) {
                http_response_code(204); // Succès sans contenu
            } else {
                http_response_code(404); // Élément non trouvé (ou autre code approprié en fonction du cas d'échec)
                echo json_encode(array("error" => "La suppression de l'institution a échoué"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => "Erreur lors de la suppression de l'institution : " . $e->getMessage()));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "ID de l'institution non fourni"));
    }
}
 elseif ($http_method === "OPTIONS") {
    http_response_code(200);
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Méthode non implémentée"));
}
?>
