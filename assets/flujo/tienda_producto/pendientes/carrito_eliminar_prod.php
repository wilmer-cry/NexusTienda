<?php
require_once('../login/validar_sesion_iniciada.php');
require '../base_datos/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($mysqli) {
        $sql = "DELETE FROM carrito WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Producto eliminado con éxito
                header("Location: carrito_compras.php");
                exit();
            } else {
                echo "Error al eliminar el producto del carrito.";
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta.";
        }

        $mysqli->close();
    } else {
        echo "Error en la conexión a la base de datos.";
    }
} else {
    echo "No se proporcionó un ID válido para eliminar el producto.";
}
?>
