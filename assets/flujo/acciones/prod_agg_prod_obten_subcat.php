<?php
require '../base_datos/database.php';

if (isset($_POST['categoriaId'])) {
    $categoriaId = $_POST['categoriaId'];
    
    
    error_log("Categoría seleccionada: " . $categoriaId);
    
    
    $sqlSubcategorias = "SELECT id_subcategoria, nombre_subcategoria FROM subcategoria WHERE id_categoria = $categoriaId";
    $resultadoSubcategorias = $mysqli->query($sqlSubcategorias);
    
    $subcategoriasOptions = "";
    while ($row = $resultadoSubcategorias->fetch_assoc()) {
        $subcategoriasOptions .= '<option value="' . $row['id_subcategoria'] . '">' . $row['nombre_subcategoria'] . '</option>';
    }
    
    echo $subcategoriasOptions;
}
?>
