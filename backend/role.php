<?php

require_once 'models/Role.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/RoleManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$roleManager = new RoleManager($connexion); // Utilisez le bon nom de classe pour le gestionnaire d'utilisateurs

$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

if ($http_method === "GET") {
    if (isset($_GET['id'])) {
        
    } 
        // Requête GET pour récupérer un utilisateur par ID
        $id = $_GET['id'];
        try {
            $role = $roleManager->getRoleById($id);
            if ($role) {
                http_response_code(200);
                echo json_encode($role);
            } else {
                http_response_code(404);
                echo json_encode(array("error" => "Role non trouvé"));
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(array("error" => $e->getMessage()));
        }
       
} 
?>
