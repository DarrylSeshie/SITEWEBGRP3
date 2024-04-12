<?php

require_once 'models/User.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/userManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$userManager = new  userManager($connexion);

$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS,GET,POST,DELETE');
header('Content-Type: application/json');

if ($http_method == "GET") {
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 10;

  // Appeler la méthode getUsers avec les paramètres de pagination
  $users = $userManager->getUsers($page, $pageSize);

  echo json_encode($users);
} else if ($http_method == "POST") {
  $jsonStr = file_get_contents('php://input');
  $contactArray = json_decode($jsonStr, true);
  $user = new ($userArray);
  try {
    $userManager->updateUser($user);
    echo json_encode($user);
  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("error" => $e->getMessage()));
  }
}else if ($http_method == "GET" && isset($_GET['nom'])) {
    $nom = $_GET['nom'];
    $users = $userManager->getUsersByName($nom);
    echo json_encode($users);
}
else if ($http_method == "DELETE") {
  $id = $_GET['id'];
  try {
    $userManager->deleteUser($id);
    http_response_code(204); // Réponse indiquant que la ressource a été supprimée avec succès
  } catch (PDOException $e) {
    http_response_code(500); // Erreur interne du serveur
    echo json_encode(array("error" => $e->getMessage()));
  }
}

  else if ($http_method == "GET") {
    $id = $_GET['id'];
    try {
      $userManager->selectUserById($id);
      http_response_code(204); // Réponse indiquant que la ressource a été supprimée avec succès
    } catch (PDOException $e) {
      http_response_code(500); // Erreur interne du serveur
      echo json_encode(array("error" => $e->getMessage()));
    }
  

} else if ($http_method == "OPTIONS") {
  http_response_code(200);
} else {
  http_response_code(400);
  echo "Method not implemented";
}






?>