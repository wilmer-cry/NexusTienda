<?php
require '../base_datos/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $id_cargo = $_POST['id_cargo'];
        $codigo = $_POST['codigo'];
        $correo = $_POST['correo'];
        $status = $_POST['status'];

        
        $sql = "UPDATE usuarios SET nombre = ?, usuario = ?, id_cargo = ?, codigo = ?, correo = ?, status = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssissi", $nombre, $usuario, $id_cargo, $codigo, $correo, $status, $id);
            if ($stmt->execute()) {
                
                header("Location: usuarios.php");
                exit;
            } else {
                echo "Error al actualizar el usuario.";
            }
        } else {
            echo "Error al preparar la declaración.";
        }
    } else {
        echo "ID de usuario no válido.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
