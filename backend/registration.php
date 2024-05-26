<?php
require_once 'models/User.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/RegistrationManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$registrationManager = new RegistrationManager($connexion);


$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS,GET,POST,DELETE');
header('Content-Type: application/json');



if ($http_method == "POST") {
  $jsonStr = file_get_contents('php://input');
  $userArray = json_decode($jsonStr, true);
  $user = new User($userArray);
  try {
    $userManager->saveUser($user);
    echo json_encode($user);
  } catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("error" => $e->getMessage()));
  }
}
