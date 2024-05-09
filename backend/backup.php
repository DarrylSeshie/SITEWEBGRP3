<?php

require_once 'managers/DBManager.php';

$dbManager = new DBManager();
$connexion = $dbManager->connect();


$http_method = $_SERVER['REQUEST_METHOD'];
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json');




// Chemin de sauvegarde du back up
$backupPath = 'C:\backup_ceref/backup.sql';

// Commande de sauvegarde (utilisation de mysqldump)
$command = "mysqldump --host=$dbHost --user=$dbUsername --password=$dbPassword $dbName > $backupPath";

// Exécution de la commande
exec($command);

// Vérification de l'état de la sauvegarde
if (file_exists($backupPath)) {
    http_response_code(200); // OK
} else {
    http_response_code(500); // Erreur interne du serveur
}
?>
