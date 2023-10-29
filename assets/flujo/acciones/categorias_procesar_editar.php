<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

   $sql = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $nombre, $descripcion, $id);
        if ($stmt->execute()) {
            header('Location: categorias.php?success=1');             
            exit();
        } else {
            header('Location: categorias.php?error=1'); 
            exit();
        }
    }
} else {
    
    header('Location: categorias.php'); 
    exit();
}
