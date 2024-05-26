<?php
require_once 'vendor/autoload.php';
require_once 'models/User.class.php';
require_once 'models/Adresse.class.php';
require_once 'models/Institution.class.php';
require_once 'models/Role.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/UserManager.php';
require_once 'jwt_utils.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$userManager = new UserManager($connexion);

$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE, PUT');
header('Content-Type: application/json');

try {
    if ($http_method === "POST") {
        $jsonStr = file_get_contents('php://input');
        $loginObj = json_decode($jsonStr, true);

        if ($loginObj === null || !isset($loginObj['username']) || !isset($loginObj['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Username/Password is mandatory"]);
            exit;
        }

        $username = $loginObj['username'];
        $password = $loginObj['password'];
        $user = $userManager->checkUser($username);

        if ($user === null) {
            http_response_code(404);
            echo json_encode(["error" => "User not found"]);
            exit;
        }

        if (!password_verify($password, $user->getMotDePasse())) {
            http_response_code(401);
            echo json_encode(["error" => "Bad username/password"]);
            exit;
        } else {
            $userId = $userManager->getUserIdByUsername($username);
            if ($userId !== null) {
                $token = generateJWT($username, $userId);
                echo json_encode(["access_token" => $token, "userId" => $userId]);
            }
        }

    } elseif ($http_method === "OPTIONS") {
        http_response_code(200);
    } elseif ($http_method === "GET") {
        if (isset($_GET['email'])) {
            $token = validateJWT(); // Validate JWT and get the token payload
            $email = $token->email; // Get the email from the decoded token
            try {
                $user = $userManager->selectUserByEmail($email);
                if ($user) {
                    http_response_code(200);
                    echo json_encode($user); // Return a single user object
                } else {
                    http_response_code(404);
                    echo json_encode(array("error" => "Utilisateur non trouvé"));
                }
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(array("error" => $e->getMessage()));
            }
        }
    } else {
        http_response_code(405);
        echo json_encode(["error" => "Method not implemented"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
