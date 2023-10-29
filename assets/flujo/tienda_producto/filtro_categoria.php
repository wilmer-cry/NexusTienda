<?php
session_start(); 
require '../base_datos/database.php';


$categoria_id = $_GET['categoria_id'];


$sql_productos = "SELECT * FROM producto WHERE status='Activo' AND categoria= $categoria_id";
$result_productos = $mysqli->query($sql_productos);

$productos = [];
if ($result_productos->num_rows > 0) {
    while ($row = $result_productos->fetch_assoc()) {
        $productos[] = $row;
    }
}
include'prod_obtener_cat_subcat.php'; 
$mysqli->close();
?>
