<?php
require_once 'models/User.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/UserManager.php';
require_once 'jwt_utils.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$userManager = new UserManager($connexion);


$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS,GET,POST,DELETE,PUT');
header('Content-Type: application/json');

if ($http_method == "POST") {
  $jsonStr = file_get_contents('php://input');
  $loginObj = json_decode($jsonStr, true);
  if ($loginObj != null && isset($loginObj['username']) && isset($loginObj['password'])) {
    $username = $loginObj['username'];
    $password = $loginObj['password'];
    $user = $userManager->checkUser($username);
    if ($user != null) {
      //$ok = password_verify($password, $user->getMotDePasse());
      $ok = password_verify($password, password_hash($user->getMotDePasse(),PASSWORD_BCRYPT));
      if (!$ok) {
        http_response_code(400);
        echo json_encode(array("error" => "Bad username/password"));
      } else {
        $token = generateJWT($username);
        echo json_encode(array("access_token" => $token));
      }
    }
  } else {
    http_response_code(400);
    echo "Username/Password is mandatory";
  }
  
} else if ($http_method == "OPTIONS") {
  http_response_code(200);
} else {
  http_response_code(400);
  echo "Method not implemented";
}
?>