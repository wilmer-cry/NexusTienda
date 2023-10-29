<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $id_cargo = $_POST['id_cargo'];
    $codigo = $_POST['codigo'];
    $correo = $_POST['correo'];
    $status = $_POST['status'];

    $sql = "INSERT INTO usuarios (nombre, usuario, pass, id_cargo, codigo, correo, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssss", $nombre, $usuario, $pass, $id_cargo, $codigo, $correo, $status);
        if ($stmt->execute()) {
            header("Location: usuarios.php");
            exit;
        } else {
            echo "Error en la inserción de usuario: " . $stmt->error;
        }
        $stmt->close();
    }
} else {
    echo "Acceso no autorizado.";
}
?>
