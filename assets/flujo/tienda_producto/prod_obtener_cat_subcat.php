<?php 
$sql_categorias = "SELECT * FROM categorias";
$result_categorias = $mysqli->query($sql_categorias);

$categorias = [];
if ($result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$sql_subcategorias = "SELECT * FROM subcategoria";
$result_subcategorias = $mysqli->query($sql_subcategorias);

$subategorias = [];
if ($result_subcategorias->num_rows > 0) {
    while ($row = $result_subcategorias->fetch_assoc()) {
        $subcategorias[] = $row;
    }
}
?>