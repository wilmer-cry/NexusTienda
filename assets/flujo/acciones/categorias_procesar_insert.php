<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $sql = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $nombre, $descripcion);
        if ($stmt->execute()) {
            header('Location: categorias_agregar_formulario.php?success=1'); 
            exit();
        } else {
            
            header('Location: categorias_agregar_formulario.php?error=1'); 
            exit();
        }
    }
} else {
    
    header('Location: categorias_agregar_formulario.php'); 
    exit();
}
?>
