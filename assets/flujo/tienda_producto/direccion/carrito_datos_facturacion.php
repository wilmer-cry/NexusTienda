<?php
session_start();
require '../../base_datos/database.php';
include '../carrito/pg_head.php';
include '../carrito/pg_header.php';

$direccion_seleccionada = isset($_POST['direccion_seleccionada']) ? $_POST['direccion_seleccionada'] : null;
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : null;
$municipio = isset($_POST['municipio']) ? $_POST['municipio'] : null;
$nombre_recibe = isset($_POST['nombre_recibe']) ? $_POST['nombre_recibe'] : null;
$apellido_recibe = isset($_POST['apellidos_recibe']) ? $_POST['apellidos_recibe'] : null;
$direccion_exacta = isset($_POST['direccion_exacta']) ? $_POST['direccion_exacta'] : null;
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$referencia_indicaciones = isset($_POST['referencia_indicaciones']) ? $_POST['referencia_indicaciones'] : null;


$sql = "SELECT SUM(p.precio * c.cantidad) AS total_a_pagar
        FROM carrito c
        JOIN producto p ON c.sku = p.sku
        WHERE c.Codigo_cliente = ?";

$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $_SESSION['codigo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total_items = $row['total_a_pagar'];
    } else {
        $total_items = 0;
    }

    $stmt->close();
} else {
    echo "Error en la preparación de la consulta.";
}


if (isset($departamento)) {
    $sql = "SELECT precio FROM precio_envio WHERE nombre = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $departamento);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $precio_envio = $row['precio'];
        } else {
            $precio_envio = 0;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta del precio de envío.";
    }
}


$total_combinado = $total_items + $precio_envio;


$cantidad_a_pagar = isset($_POST['cantidad_a_pagar']) ? $_POST['cantidad_a_pagar'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Datos de Facturación</title>
</head>
<body>
    <form id="nuevaDireccionForm" action="../../paypal_config/paypal_config_data.php" method="POST">
        <p><strong>Datos de Facturación</strong></p>
        <label for="nombre_facturacion">Nombre de facturación *</label>
        <input type="text" id="nombre_facturacion" name="nombre_facturacion" required>
        <br><br>
        <label for="nit_facturacion">NIT de facturación *</label>
        <input type="text" id="nit_facturacion" name="nit_facturacion" required>
        <br><br>

        <label for="direccion_facturacion">Dirección de facturación *</label>
        <input type="text" id="direccion_facturacion" name="direccion_facturacion" required>
        <br><br>

        <label for="correo_facturacion">Correo electrónico de facturación *</label>
        <input type="email" id="correo_facturacion" name="correo_facturacion" required>
        <br><br>

        <input type="hidden" name="cantidad_a_pagar" value="<?php echo $total_combinado; ?>">
        <?php
        echo "<p id='derechap'>Cantidad por items: Q " . number_format($total_items, 2) . "</p>";
        if (isset($precio_envio)) {
            echo "<p id='derechap'>Cantidad por envío ($departamento): Q " . number_format($precio_envio, 2) . "</p>";
        }

        
        echo "<p id='derechap'>Total a pagar (items + envío): Q " . number_format($total_combinado, 2) . "</p>";
        ?>

        <input type="submit" value="Continuar a Pago">
    </form>
</body>
</html>
