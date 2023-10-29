<?php
require '../base_datos/database.php';
session_start();
$codigoperfil = $_SESSION['codigo'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categorias WHERE id = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "Categoría no encontrada.";
            exit();
        }
    }
} else {
    echo "ID de categoría no proporcionado.";
    exit();
}

include '../admin/pg_arriba.php';	
include '../admin/pg_cabecera.php';
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">Editar Categoría</h2>
</div>

<section id="flujo">
    <form action="categorias_procesar_editar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios" required>
        <br>

        <label for="descripcion">Descripción de la Categoría:</label>
        <textarea class="texttt" id="descripcion" name="descripcion" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios"><?php echo $row['descripcion']; ?></textarea>
        <br>

        <input type="submit" value="Guardar Cambios">
    </form>
</section>

<?php include '../admin/pg_abajo.php'; ?>
