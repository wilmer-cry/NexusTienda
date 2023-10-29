<?php
session_start();
require '../../../vendor/autoload.php';
include("../base_datos/database.php");

if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    $direccion_seleccionada = isset($_POST['direccion_seleccionada']) ? $_POST['direccion_seleccionada'] : null;
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : null;
    $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : null;
    $nombre_recibe = isset($_POST['nombre_recibe']) ? $_POST['nombre_recibe'] : null;
    $apellido_recibe = isset($_POST['apellidos_recibe']) ? $_POST['apellidos_recibe'] : null;
    $direccion_exacta = isset($_POST['direccion_exacta']) ? $_POST['direccion_exacta'] : null;
    $nitFacturaicon = isset($_POST['nit_facturacion']) ? $_POST['nit_facturacion'] : null;
    $correo_facturacion = isset($_POST['correo_facturacion']) ? $_POST['correo_facturacion'] : null;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $referencia_indicaciones = isset($_POST['referencia_indicaciones']) ? $_POST['referencia_indicaciones'] : null;
    $cantidad_a_pagar = isset($_POST['cantidad_a_pagar']) ? $_POST['cantidad_a_pagar'] : '0.01';

    $usuario = $_SESSION['usuario'];
    $codigo = $_SESSION['codigo'];

    $sql = "INSERT INTO pedido (direccion_seleccionada, departamento, municipio, nombre_recibe, apellido_recibe, direccion_exacta, correo_facturacion, telefono, referencia_indicaciones, cantidad_a_pagar, usuario, codigo, paypal_token, status, nit, dire_fac, nom_fac) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $paypal_token = $paymentId;
        $status = 'pendiente entrega';
        $stmt->bind_param("ssssssssssssssss", $direccion_seleccionada, $departamento, $municipio, $nombre_recibe, $apellido_recibe, $direccion_exacta, $correo_facturacion, $telefono, $referencia_indicaciones, $cantidad_a_pagar, $usuario, $codigo, $paypal_token, $status, $nitFacturaicon, $direccion_facturacion, $nombre_facturacion);
        $stmt->execute();
        $stmt->close();

        if ($status == 'pendiente entrega' && $_SESSION['usuario'] != null && $_SESSION['codigo'] != null) {
            $sql_carrito = "SELECT Id, nombre_producto, Descripcion, Cantidad, Fecha_actualizacion, Contenido_empaque, Status, Cliente, Codigo_cliente, sku FROM carrito WHERE Status = 2 AND Cliente = ? AND Codigo_cliente = ?";
            $stmt_carrito = $mysqli->prepare($sql_carrito);
            if ($stmt_carrito) {
                $stmt_carrito->bind_param("ss", $_SESSION['usuario'], $_SESSION['codigo']);
                $stmt_carrito->execute();
                $result_carrito = $stmt_carrito->get_result();
                $stmt_carrito->close();

                $transaccion = $paymentId;
                while ($row_carrito = $result_carrito->fetch_assoc()) {
                    $sql_detalle = "INSERT INTO detalle (nombre_producto, Descripcion, Cantidad, Fecha_actualizacion, Contenido_empaque, Status, Cliente, Codigo_cliente, sku, transaccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt_detalle = $mysqli->prepare($sql_detalle);
                    if ($stmt_detalle) {
                        $stmt_detalle->bind_param("ssisssssss", $row_carrito['nombre_producto'], $row_carrito['Descripcion'], $row_carrito['Cantidad'], $row_carrito['Fecha_actualizacion'], $row_carrito['Contenido_empaque'], $row_carrito['Status'], $row_carrito['Cliente'], $row_carrito['Codigo_cliente'], $row_carrito['sku'], $transaccion);
                        $stmt_detalle->execute();
                        $stmt_detalle->close();
                    }
                }
            }
        }
        header("Location: ../tienda_producto/prod_mostrar.php");
        exit;
    } else {
        echo "Error al insertar los datos en la tabla pedido.";
    }
} else {
    echo "El pago en PayPal no se completó correctamente.";
}
?>