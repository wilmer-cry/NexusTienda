<?php
require '../base_datos/database.php';
session_start();
$codigoperfil = $_SESSION['codigo'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            // Manejo de error si no se encuentra el usuario
            echo "Usuario no encontrado.";
            exit();
        }
    }
} else {
    // Manejo de error si no se proporciona el ID
    echo "ID de usuario no proporcionado.";
    exit();
}
?>

<?php include '../admin/pg_arriba.php'; ?>	
<?php include '../admin/pg_cabecera.php'; ?>
<div class="row" id="titModulo">
    <h2 style="text-align:center">Editar Usuario</h2>
</div>
<section id="flujo">
    <form action="usuarios_procesar_editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nombre">Nombre del Usuario:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios" required>
        <br>

        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>" required>
        <br>

        <label for="id_cargo">ID de Cargo:</label>
        <input type="text" id="id_cargo" name="id_cargo" value="<?php echo $row['id_cargo']; ?>" required>
        <br>

        <label for "codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" value="<?php echo $row['codigo']; ?>" required>
        <br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $row['correo']; ?>" required>
        <br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo $row['status']; ?>" required>
        <br>

        <input type="submit" value="Guardar Cambios">
    </form>
</section>

<?php include '../admin/pg_abajo.php'; ?>
