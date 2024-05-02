<?php

require_once 'models/Image.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/ImageManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$imageManager = new ImageManager($connexion); // Utilisez le bon nom de classe pour le gestionnaire d'utilisateurs

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

        $img = $imageManager->getImagesByName($page, $pageSize, $search);
        echo json_encode($img);
    } elseif (isset($_GET['id'])) {
        // Requête GET pour récupérer un utilisateur par ID
        $id = $_GET['id'];
        try {
            $img = $imageManager->selectImageById($id);
            if ($img) {
                http_response_code(200);
                echo json_encode($img);
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Image non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        // Requête GET pour récupérer tous les utilisateurs avec pagination
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

        $imgs = $imageManager->getImages($page, $pageSize);
        echo json_encode($imgs);
    }
} elseif ($http_method === "POST") {
     // Récupérer les données JSON et l'URL de l'image
$jsonStr = file_get_contents('php://input');
$imageArray = json_decode($jsonStr, true);

if (!empty($imageArray)) {
    // Créer un nouvel objet Image à partir des données JSON
    $image = new Image($imageArray);

    // Récupérer l'URL de l'image depuis les données JSON
    $imageUrl = $imageArray['url_image'];

    // Stocker l'URL de l'image dans l'objet Image (si besoin)
    $image->setUrlImage($imageUrl);

    try {
        // Ajouter l'image à la base de données via le gestionnaire
        $imageManager->addImage($image);

        // Répondre avec les données de l'image ajoutée
        echo json_encode($image);
    } catch (PDOException $e) {
        // En cas d'erreur PDO, renvoyer un code HTTP 500 avec un message d'erreur
        http_response_code(500);
        echo json_encode(array("error" => "Erreur lors de l'ajout de l'image : " . $e->getMessage()));
    }
} else {
    // Si les données JSON sont vides ou invalides
    http_response_code(400);
    echo json_encode(array("error" => "Données JSON invalides pour l'ajout d'image "));
}
} elseif ($http_method === "PUT" || $http_method === "PATCH") {
    // Requête PUT ou PATCH pour mettre à jour un utilisateur existant
    $jsonStr = file_get_contents('php://input');
    $imgArray = json_decode($jsonStr, true);
    $img = new Image($imgArray);

    try {
        $imageManager->updateImage($img); 
        echo json_encode($img); // Répondre avec les données de l'utilisateur mis à jour
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("error" => $e->getMessage()));
    }
}  elseif ($http_method === "DELETE") {
    // Requête DELETE pour supprimer un lieu par ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($id !== null) {
        try {
            $imageManager->deleteImage($id);
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
