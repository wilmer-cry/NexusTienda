<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';

$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1);

if ($registrosPorPagina === 0) {
    $sql = "SELECT id_subcategoria, nombre_subcategoria, id_categoria, fecha_creacion, fecha_actualizacion FROM subcategoria";
    $result = $mysqli->query($sql);
} else {
    $sql = "SELECT id_subcategoria, nombre_subcategoria, id_categoria, fecha_creacion, fecha_actualizacion FROM subcategoria LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}

$totalRegistros = $result->num_rows;

$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1;
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">SUBCATEGORÍAS</h2>
</div>
<section id="flujo">
    <!-- Botón para crear una nueva subcategoría -->
    <p id="parrafo"><a id="parrafotesxt" href="subcategoria_agregar_formulario.php">Nueva Subcategoría</a></p>

    <!-- Opciones de paginación -->
    <p id="paginado">Mostrar <a href="?registros=10">10</a>&nbsp; 
        <a href="?registros=25">25</a> &nbsp;
        <a href="?registros=50">50</a> &nbsp;
        <a href="?registros=100">100</a> &nbsp;
        <a href="?registros=500">500</a> &nbsp;
        <a href="?registros=1000">1000</a> &nbsp;
        <a href="?registros=0">Todos</a> por página</p>

    <?php
    if ($totalRegistros > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID Subcategoría</th>
                <th>Nombre Subcategoría</th>
                <th>ID Categoría</th>
                <th>Fecha de Creación</th>
                <th>Fecha de Actualización</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_subcategoria"] . "</td>";
            echo "<td>" . $row["nombre_subcategoria"] . "</td>";
            echo "<td>" . $row["id_categoria"] . "</td>";
            echo "<td>" . $row["fecha_creacion"] . "</td>";
            echo "<td>" . $row["fecha_actualizacion"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron subcategorías.";
    }
    ?>
    <br>
    <br>
    <br>

    <?php include '../admin/pg_abajo.php'; ?>
