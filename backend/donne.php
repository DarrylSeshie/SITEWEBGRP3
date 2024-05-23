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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id_utilisateur'])) {
        $id_utilisateur = intval($_GET['id_utilisateur']);
        $sql = "SELECT *
                FROM donne
                JOIN produit ON produit.id_produit = donne.id_produit 
                JOIN utilisateur ON utilisateur.id_utilisateur = donne.id_utilisateur
                WHERE donne.id_utilisateur = :id_utilisateur";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    } else {
        $sql = "SELECT *
                FROM donne
                JOIN produit ON produit.id_produit = donne.id_produit
                JOIN utilisateur ON utilisateur.id_utilisateur = donne.id_utilisateur";
        $stmt = $connexion->prepare($sql);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);

    $stmt = null;
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}

$connexion = null;
?>
