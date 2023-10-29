<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';


$registrosPorPagina = isset($_GET['registros']) ? (int)$_GET['registros'] : 10;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * ($registrosPorPagina > 0 ? $registrosPorPagina : 1); 


if ($registrosPorPagina === 0) {
    
    $sql = "SELECT id, nombre, usuario, id_cargo, codigo, correo, status FROM usuarios WHERE status='2'";
    $result = $mysqli->query($sql);
} else {
    
    $sql = "SELECT id, nombre, usuario, id_cargo, codigo, correo, status FROM usuarios  WHERE status='2' LIMIT $inicio, $registrosPorPagina";
    $result = $mysqli->query($sql);
}


$totalRegistros = $result->num_rows;


$totalPaginas = $registrosPorPagina > 0 ? ceil($totalRegistros / $registrosPorPagina) : 1; 
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">USUARIOS INACTIVOS</h2>
</div>
<section id="flujo">
    <p id="parrafo"><a id="parrafotesxt" href="usuarios_agregar_formulario.php">Nuevo Usuario</a> <a id="parrafotesxt" href="usuarios_inactivos.php">U. Inactivos</a><a id="parrafotesxt" href="usuarios_administrativos.php">Administrativos</a></p>

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
            <th>Nombre</th>
            <th>Usuario</th>
            <th>ID de Cargo</th>
            <th>Código</th>
            <th>Correo</th>
            <th>Status</th>
            <th>Acciones</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["usuario"] . "</td>";
        echo "<td>" . $row["id_cargo"] . "</td>";
        echo "<td>" . $row["codigo"] . "</td>";
        echo "<td>" . $row["correo"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        echo "<td>
            <a href='usuarios_editar_formulario.php?id=" . $row["id"] . "'><button>Editar</button></a>
            <button onclick='confirmarEliminacion(" . $row["id"] . ")'>Eliminar</button>
        </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron usuarios.";
}
?>
<br>
<br>
<br>

<script>
function confirmarEliminacion(usuarioId) {
    if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
        
        window.location.href = 'usuarios_eliminar.php?id=' + usuarioId;
    }
}
</script>

<?php include '../admin/pg_abajo.php'; ?>
