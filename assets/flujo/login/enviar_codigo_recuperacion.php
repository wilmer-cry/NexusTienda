<?php

include("../base_datos/database.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    
    $sql = "SELECT correo FROM usuarios WHERE correo = '$correo'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        
        $codigo_recuperacion = "REC-" . uniqid();

        
        $sql = "UPDATE usuarios SET codigo_recuperacion = '$codigo_recuperacion' WHERE correo = '$correo'";
        if ($mysqli->query($sql) === TRUE) {
            
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->Host = 'smtp.titan.email'; 
            $mail->Port = 465; 
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'activacion@grupolotostore.com'; 
            $mail->Password = 'LICETHVALE1wl*'; 

            
            $mail->setFrom('activacion@grupolotostore.com');
            $mail->addAddress($correo);

            
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Cuenta';
            $mail->Body = 'Hemos recibido una solicitud para recuperar tu cuenta en nuestro sitio web. Para continuar, utiliza el siguiente código de recuperación:<br><br>Código: ' . $codigo_recuperacion;

            
            if ($mail->send()) {
                
                header("Location: cambiar_contrasena_form.php?correo=$correo");
                exit;
            } else {
                echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
            }
        } else {
            echo "Error al generar el código de recuperación: " . $mysqli->error;
        }
    } else {
        echo "No se encontró un usuario con ese correo en nuestra base de datos.";
    }
}
?>
