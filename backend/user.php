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
  $users = $userManager->getUsers();
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
} else if ($http_method == "DELETE") {
  $id = $_GET['id'];
  $userManager->deleteUser($id);
} else if ($http_method == "OPTIONS") {
  http_response_code(200);
} else {
  http_response_code(400);
  echo "Method not implemented";
}




?>