<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';

$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1);

if ($registrosPorPagina === 0) {
    $sql = "SELECT id, nombre, nit, direccion_facturacion, fecha_creacion, fecha_actualizacion, cargas FROM clientes";
    $result = $mysqli->query($sql);
} else {
    $sql = "SELECT id, nombre, nit, direccion_facturacion, fecha_creacion, fecha_actualizacion, cargas FROM clientes LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}

$totalRegistros = $result->num_rows;

$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1;
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">CLIENTES</h2>
</div>
<section id="flujo">
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
                <th>ID</th>
                <th>Nombre</th>
                <th>NIT</th>
                <th>Dirección de Facturación</th>
                <th>Fecha de Creación</th>
                <th>Fecha de Actualización</th>
                <th>Cargas</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["nit"] . "</td>";
            echo "<td>" . $row["direccion_facturacion"] . "</td>";
            echo "<td>" . $row["fecha_creacion"] . "</td>";
            echo "<td>" . $row["fecha_actualizacion"] . "</td>";
            echo "<td>" . $row["cargas"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron clientes.";
    }
    ?>
    <br>
    <br>
    <br>

    <?php include '../admin/pg_abajo.php'; ?>
