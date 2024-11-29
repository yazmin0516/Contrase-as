<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Asegúrate de que el autoload de Composer está incluido

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$contrasena = $data['contrasena'];

// Crear una instancia de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Cambia esto a tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'dianayazminhernandezvargas@gmail.com';  // Tu email
    $mail->Password = 'plwc tjfk somm ecnl';  // Tu contraseña del email o una contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('dianayazminhernandezvargas@gmail.com', 'Diana Hernandez');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Nueva Contraseña Generada';
    $mail->Body    = "Tu nueva contraseña generada es: <strong>$contrasena</strong>";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
?>