<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, OPTIONS, DELETE");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'managers/DBManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();
$currentDate = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id_utilisateur'])) {
        $id_utilisateur = intval($_GET['id_utilisateur']);
        $sql = "SELECT *, 
                CASE 
                    WHEN :currentDate < produit.date_debut THEN 'future'
                    WHEN :currentDate BETWEEN produit.date_debut AND produit.date_fin THEN 'in process'
                    WHEN :currentDate > produit.date_fin THEN 'past'
                END AS status
                FROM participe
                JOIN produit ON produit.id_produit = participe.id_produit 
                JOIN utilisateur ON utilisateur.id_utilisateur = participe.id_utilisateur
                WHERE participe.id_utilisateur = :id_utilisateur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':currentDate', $currentDate);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    } else {
        $sql = "SELECT *, 
                CASE 
                    WHEN :currentDate < date_debut THEN 'future'
                    WHEN :currentDate BETWEEN date_debut AND date_fin THEN 'in process'
                    WHEN :currentDate > date_fin THEN 'past'
                END AS status
                FROM participe
                JOIN produit ON produit.id_produit = participe.id_produit
                JOIN utilisateur ON utilisateur.id_utilisateur = participe.id_utilisateur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':currentDate', $currentDate);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $stmt = null;
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['id_utilisateur']) && isset($_GET['id_produit'])) {
        $id_utilisateur = intval($_GET['id_utilisateur']);
        $id_produit = intval($_GET['id_produit']);

        // Check if the record exists
        $checkSql = "SELECT COUNT(*) FROM participe WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit";
        $checkStmt = $connexion->prepare($checkSql);
        $checkStmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $checkStmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
        $checkStmt->execute();
        $recordExists = $checkStmt->fetchColumn();

        if ($recordExists) {
            $sql = "DELETE FROM participe WHERE id_utilisateur = :id_utilisateur AND id_produit = :id_produit";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(array("message" => "Record deleted successfully"));
            } else {
                http_response_code(500);
                echo json_encode(array("error" => "Failed to delete record"));
            }

            $stmt = null;
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Record not found"));
        }

        $checkStmt = null;
    } else {
        http_response_code(400);
        echo json_encode(array("error" => "Invalid input"));
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}

$connexion = null;
?>
