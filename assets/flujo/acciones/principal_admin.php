<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';


$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1); 


if ($registrosPorPagina === 0) {
    
    $sql = "SELECT * FROM producto";
    $result = $mysqli->query($sql);
} else {
    
    $sql = "SELECT * FROM producto LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}


$totalRegistros = $result->num_rows;


$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1; 
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">PRODUCTOS</h2>
</div>
<section id="flujo">
    <p>todos</p>

        <br>
        <br>
        <br>
        </section>
<?php include '../admin/pg_abajo.php'; ?>
