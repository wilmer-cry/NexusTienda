<?php
require '../base_datos/database.php';
session_start();
$codigoperfil = $_SESSION['codigo'];
?>

<?php include '../admin/pg_arriba.php'; ?>	
<?php include '../admin/pg_cabecera.php'; ?>
<div class="row" id="titModulo">
    <h2 style="text-align:center">Agregar Categoría</h2>
</div>
<section id="flujo">
    <form action="categorias_procesar_insert.php" method="POST">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" id="nombre" name="nombre" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios" required>
        <br>

        <label for="descripcion">Descripción de la Categoría:</label>
        <textarea class="texttt" id="descripcion" name="descripcion" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios"></textarea>
        <br>

        <input type="submit" value="Agregar Categoría">
    </form>
</section>

<?php include '../admin/pg_abajo.php'; ?>
