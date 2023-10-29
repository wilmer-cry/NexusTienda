<?php
require_once('../../login/validar_sesion_iniciada.php');
require '../../base_datos/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_recibe = $_POST["nombre"];
    $apellidos_recibe = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $departamento = $_POST["departamento"];
    $municipio = $_POST["municipio"];
    $direccion_exacta = $_POST["direccion"];
    $referencia_indicaciones = $_POST["referencia"];
    $codigo = $_SESSION["codigo"];
    $usuario = $_SESSION["usuario"];

    $sql = "INSERT INTO direcciones_envio (nombre_recibe, apellidos_recibe, telefono, departamento, municipio, direccion_exacta, referencia_indicaciones, codigo, usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la consulta
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssssss", $nombre_recibe, $apellidos_recibe, $telefono, $departamento, $municipio, $direccion_exacta, $referencia_indicaciones, $codigo, $usuario);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro insertado con éxito.";
        } else {
            echo "Error al insertar el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error;
    }
        $mysqli->close();
}
?>
