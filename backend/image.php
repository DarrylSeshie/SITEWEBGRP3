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
    } 
    elseif (isset($_GET['count'])) {
        // Requête GET pour obtenir le nombre total d'utilisateurs
        try {
        
            $totalUsers = $imageManager->count();
    
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

        $imgs = $imageManager->getImages($page, $pageSize);
        echo json_encode($imgs);
    }
}elseif ($http_method === "POST") {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if ($contentType === "application/json") {
        // Traitement des données JSON pour ajouter ou mettre à jour les détails de l'image
        $jsonStr = file_get_contents('php://input');
        $imageArray = json_decode($jsonStr, true);
        if (!empty($imageArray)) {
            if (!empty($imageArray['url_image'])) {
                $image = new Image($imageArray);
                try {
                    $imageManager->addImage($image);
                    echo json_encode($image);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(array("error" => "Erreur lors de l'ajout de l'image : " . $e->getMessage()));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("error" => "L'URL de l'image ne peut pas être vide"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("error" => "Données JSON invalides pour l'ajout d'image"));
        }
    }elseif ($http_method === "POST") {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
        if (strpos($contentType, "multipart/form-data") !== false) {
            if (isset($_FILES['file']) && isset($_POST['nom']) && !empty(trim($_POST['nom']))) {
                $targetDir = "uploads/";
                $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES['file']['name']));
                $targetFile = $targetDir . $fileName;
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    
                if (!in_array($fileType, $allowedTypes)) {
                    http_response_code(400);
                    echo json_encode(["error" => "Type de fichier non autorisé. Seuls les JPG, JPEG, PNG et GIF sont acceptés."]);
                    exit;
                }
    
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    $url = "http://localhost/PROJET_ceREF/backend/" . $targetFile;
                    $image = new Image();
                    $image->setNom($_POST['nom']);
                    $image->setUrlImage($url);
    
                    try {
                        $imageId = $imageManager->addImage($image);
                        echo json_encode([
                            'message' => 'Image téléchargée et enregistrée avec succès',
                            'url' => $url,
                            'name' => $_POST['nom'],
                            'imageId' => $imageId  // Supposant que `addImage()` retourne l'ID de l'image nouvellement créée
                        ]);
                    } catch (PDOException $e) {
                        http_response_code(500);
                        echo json_encode(["error" => "Erreur lors de l'ajout de l'image dans la base de données : " . $e->getMessage()]);
                    }
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Erreur lors du téléchargement du fichier."]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Informations nécessaires non fournies. Veuillez envoyer le fichier et les métadonnées (nom)."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Type de contenu non supporté"]);
        }
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Méthode non supportée"]);
    }
}

 elseif ($http_method === "PUT" || $http_method === "PATCH") {
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
