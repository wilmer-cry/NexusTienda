<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql = "SELECT id FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            
            $deleteSql = "DELETE FROM usuarios WHERE id = ?";
            $deleteStmt = $mysqli->prepare($deleteSql);

            if ($deleteStmt) {
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();
                $deleteStmt->close();

                
                header("Location: usuarios.php");
                exit;
            } else {
                echo "Error al preparar la declaración de eliminación.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        $stmt->close();
    } else {
        echo "Error al preparar la declaración de verificación.";
    }
} else {
    echo "Método de solicitud no válido o ID de usuario no proporcionado.";
}
?>
