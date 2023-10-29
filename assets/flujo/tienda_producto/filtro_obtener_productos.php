<?php
require '../base_datos/database.php';

try {
    
    $sql_productos = "SELECT * FROM producto WHERE status='Activo'";
    $result_productos = $mysqli->query($sql_productos);
    if ($result_productos === false) {
        throw new Exception("Error en la consulta de productos: " . $mysqli->error);
    }
    $productos = [];
    if ($result_productos->num_rows > 0) {
        while ($row = $result_productos->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    include 'prod_obtener_cat_subcat.php';
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>