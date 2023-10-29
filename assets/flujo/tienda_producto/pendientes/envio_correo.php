<?php
session_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

// Configuración de PHPMailer
$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->Host = 'smtp.titan.email'; // Servidor SMTP
$mail->Port = 465; // Puerto SMTP
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Username = 'pago@grupolotostore.com'; // usersmt SMTP
$mail->Password = 'LICETHVALE1wl*'; // passss SMTP

try {
    // Destinatario
    $mail->setFrom('pago@grupolotostore.com');
    $mail->addAddress('wilmer.wen66@gmail.com');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Pago Pedido';
    $mail->Body = 'Prueba correo de dark';

    // Enviar el correo
    $mail->send();
    echo 'El correo se ha enviado correctamente.';
} catch (Exception $e) {
    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
}
?>
