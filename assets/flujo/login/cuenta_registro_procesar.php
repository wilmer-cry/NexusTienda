<?php

include("../base_datos/database.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $pass = md5($_POST["pass"]);
    $pass_confirm = md5($_POST["pass_confirm"]);

    
    if ($pass != $pass_confirm) {
        echo "Las contraseñas no coinciden. Por favor, inténtelo de nuevo.";
    } else {
        
        $codigo_seguridad = "NEXUS-" . date("YmjHis");
        $codigo_cliente = "CLIENT-" . date("YmjHis");

        
        $id_cargo = 2; 
        $status = 2; 
        $sql = "INSERT INTO usuarios (nombre, usuario, pass, id_cargo, codigo, correo, status) VALUES ('$nombre', '$correo', '$pass', $id_cargo, '$codigo_cliente', '$correo', '$status')";

        if ($mysqli->query($sql) === TRUE) {
            
            $sql = "INSERT INTO valida_codigo (codigo, correo) VALUES ('$codigo_seguridad', '$correo')";
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
                $mail->Subject = 'CODIGO DE SEGURIDAD';
                $mail->Body = 'Tu código de seguridad es: ' . $codigo_seguridad.' por tu seguridad no compartas este codigo con nadie';

                
                if ($mail->send()) {
                    header("Location: validar_codigo.php?correo=$correo");
                    echo "Registro exitoso. Tu código de seguridad es: $codigo_seguridad";
                } else {
                    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
                }
            } else {
                echo "Error al registrar el código de seguridad: " . $mysqli->error;
            }
        } else {
            echo "Error al registrar: " . $mysqli->error;
        }
    }
}


$mysqli->close();
?>
