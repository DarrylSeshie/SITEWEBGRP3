<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    // Preflight request handling
    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();  
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true; 
        $mail->Username   = 'lamhamdihoussameddine@gmail.com'; 
        $mail->Password   = 'mnfv ntyf pdfb rmot';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('lamhamdihoussameddine@gmail.com', 'Mailer');
        $mail->addAddress('lamhamdihoussameddine@gmail.com');   

        // Content
        $mail->isHTML(false);               
        $mail->Subject = 'Error Report';
        $mail->Body    = $message;

        $mail->send();
        http_response_code(200);
        echo json_encode(['message' => 'Email sent successfully.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => "Failed to send email. Error: {$mail->ErrorInfo}"]);
    }
} else {
    http_response_code(403);
    echo json_encode(['message' => 'Request method not supported.']);
}
?>