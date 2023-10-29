<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';

$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1); 
if ($registrosPorPagina === 0) {
    $sql = "SELECT id, direccion_seleccionada, nombre_recibe, apellido_recibe, cantidad_a_pagar, paypal_token FROM pedido";
    $result = $mysqli->query($sql);
} else {
    $sql = "SELECT id, direccion_seleccionada, nombre_recibe, apellido_recibe, cantidad_a_pagar, paypal_token FROM pedido LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}
$totalRegistros = $result->num_rows;

$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1; ?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">PEDIDOS</h2>
</div>
<section id="flujo">
    <p id="parrafo"><a id="parrafotesxt" href="agregar_pedido.php">Nuevo Pedido</a></p>
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
                <th>Dirección</th>
                <th>Nombre Recibe</th>
                <th>Apellido Recibe</th>
                <th>Cantidad a Pagar</th>
                <th>Acciones</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["direccion_seleccionada"] . "</td>";
            echo "<td>" . $row["nombre_recibe"] . "</td>";
            echo "<td>" . $row["apellido_recibe"] . "</td>";
            echo "<td>" . $row["cantidad_a_pagar"] . "</td>";

            echo "<td>
            <a href='pedido_ver.php?id=" . $row["id"] . "'><button>Ver</button></a>
            <a href='pedido_detalle.php?token=" . $row['paypal_token'] . "'><button>Detalle</button></a>
        </td>";
        echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron pedidos.";
    }
    ?>
    <br>
    <br>
    <br>
</section>
<?php include '../admin/pg_abajo.php'; ?>
