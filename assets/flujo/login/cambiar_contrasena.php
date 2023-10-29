<?php
include("../base_datos/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo_recuperacion = $_POST["codigo"];
    $correo = $_POST["correo"];
    $nueva_contrasena = md5($_POST["nueva_contrasena"]);

    
    $sql = "SELECT codigo_recuperacion FROM usuarios WHERE correo = '$correo'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codigo_guardado = $row["codigo_recuperacion"];

        if ($codigo_recuperacion === $codigo_guardado) {
            
            $sql = "UPDATE usuarios SET pass = '$nueva_contrasena', codigo_recuperacion = NULL WHERE correo = '$correo'";
            if ($mysqli->query($sql) === TRUE) {
                header("Location: login.php");
            } else {
                echo "Error al cambiar la contraseña: " . $mysqli->error;
                var_dump($codigo_recuperacion, $codigo_guardado);
            }
        } else {
            echo "El código de recuperación no es válido. Inténtelo de nuevo.";
            var_dump($codigo_recuperacion, $codigo_guardado);
        }
    } else {
        echo "No se encontró un código de recuperación para el correo proporcionado: " . $correo;
        var_dump($codigo_recuperacion, $codigo_guardado);
    }
}
?>

            