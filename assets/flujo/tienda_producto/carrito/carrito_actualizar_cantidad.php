<?php
session_start();
require '../../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nuevaCantidad = $_POST['cantidad'];
    $status = '1';

    // Verifica las existencias de producto en la base de datos antes de actualizar
    $queryExistencias = "SELECT existencias FROM producto WHERE Id = ?";
    $stmtExistencias = $mysqli->prepare($queryExistencias);
    $stmtExistencias->bind_param('i', $id);
    $stmtExistencias->execute();
    $resultExistencias = $stmtExistencias->get_result();
    $existencias = $resultExistencias->fetch_assoc()['existencias'];

    if ($nuevaCantidad <= $existencias) {
        $queryUpdate = "UPDATE carrito SET Cantidad = ? WHERE Id = ? AND status = ?";
        $stmtUpdate = $mysqli->prepare($queryUpdate);
        $stmtUpdate->bind_param('iis', $nuevaCantidad, $id, $status);

        if ($stmtUpdate->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'existencias_excedidas';
    }
} else {
    echo 'method_not_allowed';
}
?>
