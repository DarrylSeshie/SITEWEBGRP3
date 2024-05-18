<?php
require_once 'models/Image.class.php';
require_once 'models/Lieu.class.php';
require_once 'models/TypeProduit.class.php';
require_once 'models/Formation.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/FormationManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$lieuManager = new FormationManager($connexion); 

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

        $lieux = $lieuManager->getProduitsByname2($page, $pageSize, $search);
        echo json_encode($lieux);
    } elseif (isset($_GET['get3ProduitsByDate'])) {
        // Requête GET pour récupérer les 3 produits à venir
        try {
            $produitsAVenir = $lieuManager->get3ProduitByDate();
            echo json_encode($produitsAVenir);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    }
    elseif (isset($_GET['id'])) {
        // Requête GET pour récupérer un utilisateur par ID
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
    }
    elseif (isset($_GET['count'])) {
        // Requête GET pour obtenir le nombre total d'utilisateurs
        try {
        
            $totalUsers = $lieuManager->count();
    
            http_response_code(200);
            echo json_encode(['total' => $totalUsers]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        // Requête GET pour récupérer tous les utilisateurs avec pagination
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $lieux = $lieuManager->getProduits($page, $pageSize);
        echo json_encode($lieux);
    }
} elseif ($http_method === "POST") {
    // Requête POST pour ajouter un nouvel utilisateur
    $jsonStr = file_get_contents('php://input');
    $prodArray = json_decode($jsonStr, true);

    if (!empty($prodArray)) {
    $prod = new Formation($prodArray);

    try {
        $lieuManager->addProduit($prod); // Utilisez la méthode addUser pour insérer l'utilisateur
        echo json_encode($prod); // Répondre avec les données de l'utilisateur ajouté
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => "Erreur lors de l'ajout de formation : " . $e->getMessage()));
    }
} else {
    // Si les données JSON sont vides ou invalides
    http_response_code(400);
    echo json_encode(array("error" => "Données JSON invalides pour l'ajout formation"));
}
} elseif ($http_method === "PUT" || $http_method === "PATCH") {
    // Requête PUT ou PATCH pour mettre à jour un utilisateur existant
    $jsonStr = file_get_contents('php://input');
    $lieuArray = json_decode($jsonStr, true);
    $lieu = new Formation($lieuArray);

    try {
        $lieuManager->updateProduit($lieu); // Utilisez la méthode updateUser pour mettre à jour l'utilisateur
        echo json_encode($lieu); // Répondre avec les données de l'utilisateur mis à jour
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
}  elseif ($http_method === "DELETE") {
    // Requête DELETE pour supprimer un lieu par ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        try {
            $lieuManager->deleteProduit($id);
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
