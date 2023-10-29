<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';

$categorias = $mysqli->query("SELECT id, nombre FROM categorias");
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">NUEVA SUBCATEGORÍA</h2>
</div>
<section id="flujo">
    <form action="subcategoria_procesar_agregar.php" method="POST">
        <label for="nombre_subcategoria">Nombre de la Subcategoría:</label>
        <input type="text" id="nombre_subcategoria" name="nombre_subcategoria" required>
        <br>

        <label for="id_categoria">Categoría:</label>
        <select id="id_categoria" name="id_categoria">
            <?php
            while ($categoria = $categorias->fetch_assoc()) {
                echo "<option value='" . $categoria["id"] . "'>" . $categoria["nombre"] . "</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Guardar Subcategoría">
    </form>
</section>
<?php include '../admin/pg_abajo.php'; ?>
