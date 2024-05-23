<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond to OPTIONS request for CORS preflight
    http_response_code(200);
    exit();
}

require_once 'managers/DBManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbManager = new DBManager();
    $connexion = $dbManager->connect();

    $jsonStr = file_get_contents('php://input');
    $data = json_decode($jsonStr, true);

    if ($data === null) {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid JSON input"));
        exit();
    }
    
    error_log("Received data: " . print_r($data, true));

    if (isset($data['id_produit']) && isset($data['id_utilisateur'])) {
        $id_produit = intval($data['id_produit']);
        $id_utilisateur = intval($data['id_utilisateur']);

        // Check if the entry already exists
        $sqlCheck = "SELECT COUNT(*) FROM participe WHERE id_produit = :id_produit AND id_utilisateur = :id_utilisateur";
        $stmtCheck = $connexion->prepare($sqlCheck);
        $stmtCheck->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
        $stmtCheck->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmtCheck->execute();
        $exists = $stmtCheck->fetchColumn();

        if ($exists) {
            http_response_code(409); // Conflict
            echo json_encode(array("error" => "Duplicate entry: This record already exists"));
        } else {
            // Proceed with insertion if no duplicate is found
            $sql = "INSERT INTO participe (id_produit, id_utilisateur) VALUES (:id_produit, :id_utilisateur)";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(array("message" => "Inscription successful"));
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Database error: " . $stmt->errorInfo()[2]));
            }

            $stmt = null;
        }

        $stmtCheck = null;
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid input"));
    }
    $connexion = null;
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}
?>
