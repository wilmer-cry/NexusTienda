<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';


$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1); 


if ($registrosPorPagina === 0) {
    
    $sql = "SELECT * FROM producto WHERE status='Activo'";
    $result = $mysqli->query($sql);
} else {
    
    $sql = "SELECT * FROM producto WHERE status='Activo' LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}


$totalRegistros = $result->num_rows;


$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1; 
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">PRODUCTOS</h2>
</div>
<section id="flujo">
    <p id="parrafo"><a id="parrafotesxt" href="producto_agregar_formulario.php">Nuevo P.</a><a id="parrafotesxt" href="productos_inactivos.php">P. Inactivos</a></p>

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
                <th>ID</th>
                <th>SKU</th>
                <th>NOMBRE</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO</th>
                <th>EXISTENCIA</th>

                <th>STATUS</th>


                <th>CARACTERISTICAS</th>

                <th>ACCIONES</th>
              </tr>";

              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["sku"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>" . $row["existencias"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";


                echo "<td>" . $row["caracteristicas"] . "</td>";
                
                echo "<td>
                <a href='producto_mas.php?id=" . $row["id"] . "'><button>Más</button></a>
                <a href='producto_edit.php?id=" . $row["id"] . "'><button>Edit.</button></a>
                <button onclick='desactivarProducto(" . $row["id"] . ")'>Desct.</button>
                
                <button onclick='eliminarProducto(" . $row["id"] . ")'>Elim.</button>
            </td>";
            echo "</tr>";
            
            }
            echo "</table>";
        } else {
            echo "No se encontraron productos.";
        }
        ?>
        <br>
        <br>
        <br>
        </section>
<?php include '../admin/pg_abajo.php'; ?>
