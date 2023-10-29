<?php
$query = "SELECT Id, sku, nombre_producto, Cantidad, Contenido_empaque FROM carrito WHERE cliente = ? AND codigo_cliente = ? AND status=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sss', $usuario, $codigo, $status);
$stmt->execute();
$result = $stmt->get_result();
?>