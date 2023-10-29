<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';


if(isset($_GET['token'])){
    $token = $_GET['token'];
    
    
    $sql = "SELECT * FROM detalle WHERE transaccion = '$token'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Nombre Producto</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Fecha Actualización</th>
                <th>Contenido del Empaque</th>
                <th>Status</th>
                <th>Cliente</th>
                <th>Código Cliente</th>
                <th>SKU</th>
                <th>Precio Unitario</th>
                <th>Transacción</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Id"] . "</td>";
            echo "<td>" . $row["nombre_producto"] . "</td>";
            echo "<td>" . $row["Descripcion"] . "</td>";
            echo "<td>" . $row["Cantidad"] . "</td>";
            echo "<td>" . $row["Fecha_actualizacion"] . "</td>";
            echo "<td>" . $row["Contenido_empaque"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "<td>" . $row["Cliente"] . "</td>";
            echo "<td>" . $row["Codigo_cliente"] . "</td>";
            echo "<td>" . $row["sku"] . "</td>";
            echo "<td>" . $row["precio_uniad"] . "</td>";
            echo "<td>" . $row["transaccion"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron detalles para el token: $token";
    }
} else {
    echo "No se ha proporcionado un token.";
}

include '../admin/pg_abajo.php';
?>
