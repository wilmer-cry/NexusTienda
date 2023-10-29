<?php 
session_start(); 

try {

    
    $product_id = $_GET['id'];

    $sql_producto_detalle = "SELECT * FROM producto WHERE id = $product_id";
    $result_producto_detalle = $mysqli->query($sql_producto_detalle);
    if ($result_producto_detalle === false) {
        throw new Exception("Error en la consulta de detalles del producto: " . $mysqli->error);
    }
    
    $producto_detalle = $result_producto_detalle->fetch_assoc();
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


function obtenerImagen($imagen) {
    $imagenPorDefecto = 'imagen_por_defecto.jpg'; 
    if (!empty($imagen) && file_exists("../../img_prods/$imagen")) {
        return "../../img_prods/$imagen";
    } else {
        return "../../img_prods/$imagenPorDefecto";
    }
}
?>