<?php
require_once('../login/validar_sesion_iniciada.php');
require '../base_datos/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$sql_total_carrito = "SELECT SUM(p.precio * c.cantidad) AS total_a_pagar
                    FROM carrito c
                    JOIN producto p ON c.sku = p.sku
                    WHERE (c.status = 1 OR c.status = 3) AND c.codigo = ?";

$stmt_total_carrito = $mysqli->prepare($sql_total_carrito);

if ($stmt_total_carrito) {
    $stmt_total_carrito->bind_param("s", $_SESSION['codigo']);
    $stmt_total_carrito->execute();
    $result_total_carrito = $stmt_total_carrito->get_result();

    if ($result_total_carrito->num_rows > 0) {
        $row_total_carrito = $result_total_carrito->fetch_assoc();
        $total_items = $row_total_carrito['total_a_pagar'];
    } else {
        $total_items = 0;
    }

    $stmt_total_carrito->close();
} else {
    echo "Error en la preparación de la consulta.";
}


if (isset($_POST['departamento'])) {
    $departamento = $_POST['departamento'];
    $sql_precio_envio = "SELECT precio FROM precio_envio WHERE nombre = ?";
    $stmt_precio_envio = $mysqli->prepare($sql_precio_envio);

    if ($stmt_precio_envio) {
        $stmt_precio_envio->bind_param("s", $departamento);
        $stmt_precio_envio->execute();
        $result_precio_envio = $stmt_precio_envio->get_result();

        if ($result_precio_envio->num_rows > 0) {
            $row_precio_envio = $result_precio_envio->fetch_assoc();
            $precio_envio = $row_precio_envio['precio'];
        } else {
            $precio_envio = 0;
        }

        $stmt_precio_envio->close();
    } else {
        echo "Error en la preparación de la consulta del precio de envío.";
    }
}


$total_combinado = $total_items + $precio_envio;


$nombre_facturacion = $_POST['nombre_facturacion'];
$nit_facturacion = $_POST['nit_facturacion'];
$fecha_actual = date("Y-m-d H:i:s");
$estado = $precio_envio.' precio de envio';

$sql_insert_pedido = "INSERT INTO pedido (detalle, nit, nombre_cliente, id_cliente, total, fecha_carga, estado)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt_insert_pedido = $mysqli->prepare($sql_insert_pedido);

if ($stmt_insert_pedido) {
    $detalle = "NEXUS" . date("YmdHis"); 
    $id_cliente = $_SESSION['codigo'];
    
    $stmt_insert_pedido->bind_param("ssssdss", $detalle, $nit_facturacion, $nombre_facturacion, $id_cliente, $total_combinado, $fecha_actual, $estado);
    $stmt_insert_pedido->execute();
    $pedido_id = $stmt_insert_pedido->insert_id; 
    $stmt_insert_pedido->close();
} else {
    echo "Error al insertar en la tabla pedido.";
}


$sql_select_productos_carrito = "SELECT c.sku, c.cantidad, p.precio, c.status
                                FROM carrito c
                                JOIN producto p ON c.sku = p.sku
                                WHERE (c.status = 1 OR c.status = 3) AND c.codigo = ?";

$stmt_select_productos_carrito = $mysqli->prepare($sql_select_productos_carrito);

if ($stmt_select_productos_carrito) {
    $stmt_select_productos_carrito->bind_param("s", $_SESSION['codigo']);
    $stmt_select_productos_carrito->execute();
    $result_select_productos_carrito = $stmt_select_productos_carrito->get_result();

    
    $sql_insert_pedido_detalle = "INSERT INTO pedido_detalle (cantidad, sku_producto, pedido, precio, total, status, fecha_carga)
                                VALUES (?, ?, ?, ?, ?, 'activo', ?)";

    $stmt_insert_pedido_detalle = $mysqli->prepare($sql_insert_pedido_detalle);

    if ($stmt_insert_pedido_detalle) {
        while ($row_producto_carrito = $result_select_productos_carrito->fetch_assoc()) {
            $cantidad = $row_producto_carrito['cantidad'];
            $sku_producto = $row_producto_carrito['sku'];
            $precio_producto = $row_producto_carrito['precio'];
            $total_producto = $cantidad * $precio_producto;
            $fecha_carga_producto = $fecha_actual;

            $stmt_insert_pedido_detalle->bind_param("isssds", $cantidad, $sku_producto, $detalle, $precio_producto, $total_producto, $fecha_carga_producto);
            $stmt_insert_pedido_detalle->execute();

            
            $sql_restar_inventario = "UPDATE producto SET existencias = existencias - ? WHERE sku = ?";
            $stmt_restar_inventario = $mysqli->prepare($sql_restar_inventario);

            if ($stmt_restar_inventario) {
                $stmt_restar_inventario->bind_param("is", $cantidad, $sku_producto);
                $stmt_restar_inventario->execute();
                $stmt_restar_inventario->close();
            } else {
                echo "Error al restar el inventario.";
            }
        }

        $stmt_insert_pedido_detalle->close();
    } else {
        echo "Error al insertar en la tabla pedido_detalle.";
    }

    $stmt_select_productos_carrito->close();
} else {
    echo "Error en la preparación de la consulta de productos de carrito.";
}


$sql_limpiar_carrito = "DELETE FROM carrito WHERE status = 1 AND codigo = ?";
$stmt_limpiar_carrito = $mysqli->prepare($sql_limpiar_carrito);

if ($stmt_limpiar_carrito) {
    $stmt_limpiar_carrito->bind_param("s", $_SESSION['codigo']);
    $stmt_limpiar_carrito->execute();
    $stmt_limpiar_carrito->close();
} else {
    echo "Error al limpiar el carrito.";
}


header('Location: prod_mostrar.php');
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Aquí puedes agregar los estilos o scripts necesarios -->
</head>
<body>
    <!-- Puedes mostrar un mensaje de confirmación o redireccionar al usuario aquí -->
</body>
</html>
