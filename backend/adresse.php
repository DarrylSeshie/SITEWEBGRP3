<?php

require_once 'models/Adresse.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/AdresseManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$adresseManager = new AdresseManager($connexion); // Utilisez le bon nom de classe pour le gestionnaire d'utilisateurs

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

        $adresses = $adresseManager->getAdresseByCodeP($page, $pageSize, $search);
        echo json_encode($adresses);
    } elseif (isset($_GET['id'])) {
        // Requête GET pour récupérer un utilisateur par ID
        $id = $_GET['id'];
        try {
            $adresse = $adresseManager->selectAdresseById($id);
            if ($adresse) {
                http_response_code(200);
                echo json_encode($adresse);
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Lieu non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    } 
    elseif (isset($_GET['count'])) {
        // Requête GET pour obtenir le nombre total d'utilisateurs
        try {
        
            $totalUsers = $adresseManager->count();
    
            http_response_code(200);
            echo json_encode(['total' => $totalUsers]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }else {
        // Requête GET pour récupérer tous les utilisateurs avec pagination
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $adresses = $adresseManager->getAdresses($page, $pageSize);
        echo json_encode($adresses);
    }
} elseif ($http_method === "POST") {
    // Requête POST pour ajouter un nouvel utilisateur
    $jsonStr = file_get_contents('php://input');
    $adresseArray = json_decode($jsonStr, true);
    $adresse = new Adresse($adresseArray);

    try {
        $adresseManager->addAdresse($adresse); // Utilisez la méthode addUser pour insérer l'utilisateur
        echo json_encode($adresse); // Répondre avec les données de l'utilisateur ajouté
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
} elseif ($http_method === "PUT" || $http_method === "PATCH") {
    // Requête PUT ou PATCH pour mettre à jour un utilisateur existant
    $jsonStr = file_get_contents('php://input');
    $adresseArray = json_decode($jsonStr, true);
    $adresse = new Adresse($adresseArray);

    try {
        $adresseManager->updateAdresse($adresse); 
        echo json_encode($adresse); // Répondre avec les données de l'utilisateur mis à jour
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
}   elseif ($http_method === "DELETE") {
    // Requête DELETE pour supprimer un lieu par ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        try {
            $adresseManager->deleteAdresse($id);
            http_response_code(204); // Succès sans contenu
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => "Erreur lors de la suppression du lieu : " . $e->getMessage()));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "ID du lieu non fourni"));
    }
}
 elseif ($http_method === "OPTIONS") {
    http_response_code(200);
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Méthode non implémentée"));
}
?>
