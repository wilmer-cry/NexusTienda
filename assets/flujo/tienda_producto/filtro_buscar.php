<?php
session_start(); 

require '../base_datos/database.php';

if (isset($_GET['producto']) && !empty($_GET['producto'])) {
    
    $termino = $_GET['producto'];

    
    $sql_productos = "SELECT * FROM producto WHERE status='Activo' AND (nombre LIKE '%$termino%' OR descripcion LIKE '%$termino%')";
    $result_productos = $mysqli->query($sql_productos);

    $productos = [];
    if ($result_productos->num_rows > 0) {
        while ($row = $result_productos->fetch_assoc()) {
            $productos[] = $row;
        }
    }
} else {
    
    $sql_productos = "SELECT * FROM producto WHERE status='Activo'";
    $result_productos = $mysqli->query($sql_productos);

    $productos = [];
    if ($result_productos->num_rows > 0) {
        while ($row = $result_productos->fetch_assoc()) {
            $productos[] = $row;
        }
    }
}
include'prod_obtener_cat_subcat.php'; 
$mysqli->close();
?>
