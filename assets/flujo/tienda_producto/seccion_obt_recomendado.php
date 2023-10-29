<?php
require '../base_datos/database.php';

try {
    $sql_productos = "SELECT * FROM producto WHERE status='Activo' ORDER BY RAND() LIMIT 12";
    $result_productos = $mysqli->query($sql_productos);
    if ($result_productos === false) {
        throw new Exception("Error en la consulta de productos: " . $mysqli->error);
    }
    $productoss = [];
    if ($result_productos->num_rows > 0) {
        while ($row = $result_productos->fetch_assoc()) {
            $productoss[] = $row;
        }
    }
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
