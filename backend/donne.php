<?php
require_once 'models/User.class.php';
require_once 'models/Formation.class.php';
require_once 'models/Donne.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/DonneManager.php'; // Assurez-vous que ce fichier existe et que la classe est correctement définie

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$donneManager = new DonneManager($connexion);

// Définition des en-têtes CORS
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

$http_method = $_SERVER['REQUEST_METHOD'];

if ($http_method === "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($http_method === "GET") {
    if (isset($_GET['id'])) {
        // Requête GET pour récupérer un utilisateur par ID
        $id = intval($_GET['id']);
        try {
            $user = $donneManager->getDonneForm($id);
            if ($user) {
                http_response_code(200);
                echo json_encode($user);
            
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Utilisateur non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "ID non fourni"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("error" => "Méthode non implémentée"));
}
?>
