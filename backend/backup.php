<?php
// Inclure la classe DBManager
require_once 'managers/DBManager.php';

// Autoriser les requêtes CORS depuis le domaine Angular
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Vérifier la méthode de la requête (pour les requêtes OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Répondre avec succès (200 OK) pour les pré-vérifications CORS
    http_response_code(200);
    exit();
}

// Informations de connexion à la base de données
$dbHost = '127.0.0.1';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ceref';
$backup_file = 'C:/backup_ceref/backup.sql';
$command = "mysqldump --user={$dbUsername} --password={$dbPassword} --host={$dbHost} {$dbName} > {$backup_file}"; // Commande de sauvegarde (utilisation de mysqldump)

   
    // Exécuter la commande de sauvegarde
    exec($command, $output, $returnVar);
    if ($returnVar === 0) {
        // Exportation réussie
        http_response_code(200);
        echo json_encode(['message' => 'Export de la base de données réussi']);
    } else {
        // Échec de l'exportation
        http_response_code(500);
        echo json_encode(['message' => 'Échec de l\'export de la base de données']);
    }


// Déconnexion de la base de données (si nécessaire)
$dbManager = new DBManager();
$dbManager->disconnect();

exit();
?>
