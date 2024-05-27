<?php
require_once 'models/User.class.php';
require_once 'models/Adresse.class.php';
require_once 'models/Institution.class.php';
require_once 'models/Role.class.php';
require_once 'managers/DBManager.php';
require_once 'managers/RegistrationManager.php';

// Initialisation des gestionnaires de base de données et d'enregistrement
$dbManager = new DBManager();
$connexion = $dbManager->connect();
$registrationManager = new RegistrationManager($connexion);

header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');

// Détermination de la méthode HTTP
$http_method = $_SERVER['REQUEST_METHOD'];



if ($http_method === "POST") {
  // Requête POST pour ajouter un nouvel utilisateur
  $jsonStr = file_get_contents('php://input');
  $userArray = json_decode($jsonStr, true);

  if (!empty($userArray) && is_array($userArray)) {
      // Vérification de l'adresse e-mail
      if (filter_var($userArray['email'], FILTER_VALIDATE_EMAIL)) {
          // Validation réussie, création de l'objet User
          $user = new User($userArray);

          try {
              // Enregistrement de l'utilisateur
              $registrationManager->saveUser($user);
              // Répondre avec les données de l'utilisateur ajouté
              echo json_encode($user);
          } catch (PDOException $e) {
              // Erreur lors de l'enregistrement dans la base de données
              http_response_code(500);
              echo json_encode(array("error" => $e->getMessage()));
          }
      } else {
          // Si l'adresse e-mail est invalide
          http_response_code(400);
          echo json_encode(array("error" => "Adresse e-mail invalide"));
      }
  } else {
      // Si les données JSON sont vides ou invalides
      http_response_code(400);
      echo json_encode(array("error" => "Données JSON invalides pour l'ajout d'utilisateur"));
  }

} elseif ($http_method === "OPTIONS") {
 
  http_response_code(200);
  
} else {
  http_response_code(400);
  echo json_encode(array("error" => "Méthode non implémentée"));
}

