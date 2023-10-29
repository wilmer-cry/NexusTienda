<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM categorias WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header('Location: categorias.php?deleted=1'); exit();
        } else {
            header('Location: categorias.php?error=1');            exit();
        }
    }
} else {
    header('Location: categorias.php');     
    exit();
}
?>
