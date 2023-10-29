<?php
session_start(); 
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login/login.php");
    exit();
}
require '../../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_SESSION['usuario'];
    $codigo = $_SESSION['codigo'];
    $cantidad = $_POST['cantidad'];
    $sku = $_POST['sku'];

    $queryProduct = "SELECT id, nombre, descripcion, contenido_empaque FROM producto WHERE sku = ?";
    $stmtProduct = $mysqli->prepare($queryProduct);
    $stmtProduct->bind_param('s', $sku);
    $stmtProduct->execute();
    $resultProduct = $stmtProduct->get_result();

    if ($resultProduct->num_rows > 0) {
        $productData = $resultProduct->fetch_assoc();
        $productId = $productData['id'];
        $productNombre = $productData['nombre'];
        $productdescripcion = $productData['descripcion'];
        $productempaque = $productData['contenido_empaque'];

        $queryCheck = "SELECT * FROM carrito WHERE sku = ? AND Status = 1 AND Cliente = ? AND Codigo_cliente = ?";
        $stmtCheck = $mysqli->prepare($queryCheck);
        $stmtCheck->bind_param('sss', $sku, $usuario, $codigo);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $queryUpdate = "UPDATE carrito SET Cantidad = Cantidad + ? WHERE sku = ? AND Status = 1 AND Cliente = ? AND Codigo_cliente = ?";
            $stmtUpdate = $mysqli->prepare($queryUpdate);
            $stmtUpdate->bind_param('ssss', $cantidad, $sku, $usuario, $codigo);
            if ($stmtUpdate->execute()) {
                header("Location: ../mostrar_detalle.php?id=" . $productId);
                exit;
            } else {
                echo "Error al actualizar el producto en el carrito.";
            }
        } else {
            $queryInsert = "INSERT INTO carrito (nombre_producto, Descripcion, Cantidad, Contenido_empaque, Cliente, Codigo_cliente, sku, Status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
            $stmtInsert = $mysqli->prepare($queryInsert);
            $stmtInsert->bind_param('sssssss', $productNombre, $productdescripcion, $cantidad, $productempaque, $usuario, $codigo, $sku);

            if ($stmtInsert->execute()) {
                header("Location: ../mostrar_detalle.php?id=" . $productId);
                exit;
            } else {
                echo "Error al agregar el producto al carrito.";
            }
        }
    } else {
        echo "El producto no se encontró en la base de datos.";
    }
} else {
    echo "No se recibieron datos por POST.";
}
?>
