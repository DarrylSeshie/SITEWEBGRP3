<?php
require_once 'models/Image.class.php';
require_once 'models/Lieu.class.php';
require_once 'models/TypeProduit.class.php';
require_once 'models/Formation.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/FormationManager.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Réponse à la requête OPTIONS pour permettre les requêtes GET, POST, PUT, PATCH, DELETE
    http_response_code(200);
    exit();
}

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$lieuManager = new FormationManager($connexion);

$http_method = $_SERVER['REQUEST_METHOD'];


if ($http_method === "GET") {
    if (isset($_GET['search'])) {
       
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;
        $search = $_GET['search'];

        $lieux = $lieuManager->getProduitsByname2($page, $pageSize, $search);
        echo json_encode($lieux);
    } elseif (isset($_GET['get3ProduitsByDate'])) {
       
        try {
            $produitsAVenir = $lieuManager->get3ProduitByDate();
            echo json_encode($produitsAVenir);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    } elseif (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        try {
            $lieu = $lieuManager->selectProduitById($id);
            if ($lieu) {
                http_response_code(200);
                echo json_encode($lieu);
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Lieu non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $lieux = $lieuManager->getProduits($page, $pageSize);
        echo json_encode($lieux);
    }
} elseif ($http_method === "POST") {
    
    $jsonStr = file_get_contents('php://input');
    $prodArray = json_decode($jsonStr, true);

    if (!empty($prodArray)) {
        
        $required_keys = ['id_produit', 'titre', 'sous_titre', 'date_debut', 'date_fin', 'date_fin_inscription', 'descriptif', 'objectif', 'contenu', 'methodologie', 'public_cible', 'prix', 'id_image', 'id_lieu', 'id_type_produit'];
        $missing_keys = array_diff($required_keys, array_keys($prodArray));

        if (!empty($missing_keys)) {
            http_response_code(400);
            echo json_encode(array("error" => "Missing required keys: " . implode(", ", $missing_keys)));
            exit;
        }

        $prod = new Formation($prodArray);

        try {
            $lieuManager->addProduit($prod);
            echo json_encode($prod);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => "Erreur lors de l'ajout de formation : " . $e->getMessage()));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "Données de formation invalides."));
    }
} elseif ($http_method === "PUT" || $http_method === "PATCH") {
  
    $jsonStr = file_get_contents('php://input');
    $lieuArray = json_decode($jsonStr, true);
    $lieu = new Formation($lieuArray);

    try {
        $lieuManager->updateProduit($lieu);
        echo json_encode($lieu);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
} elseif ($http_method === "DELETE") {
  
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        try {
            $lieuManager->deleteProduit($id);
            http_response_code(204);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => "Erreur lors de la suppression du lieu : " . $e->getMessage()));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "ID du lieu non fourni"));
    }

} else {
    http_response_code(400);
    echo json_encode(array("error" => "Méthode non implémentée"));
}
?>
