<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreSubcategoria = $_POST['nombre_subcategoria'];
    $idCategoria = $_POST['id_categoria'];
    if (!empty($nombreSubcategoria) && !empty($idCategoria)) {
        $stmt = $mysqli->prepare("INSERT INTO subcategoria (nombre_subcategoria, id_categoria) VALUES (?, ?)");
        $stmt->bind_param("si", $nombreSubcategoria, $idCategoria);
        if ($stmt->execute()) {   
            header("Location: subcategorias.php");
            exit;
        } else {
            
            echo "Error al agregar la subcategoría. Por favor, inténtalo de nuevo.";
        }
        $stmt->close();
    } else {
        echo "Por favor, completa todos los campos.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>
