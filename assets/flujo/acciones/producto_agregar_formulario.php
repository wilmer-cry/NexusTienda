<?php
require '../base_datos/database.php';
session_start();
$codigoperfil = $_SESSION['codigo'];
$sqlCategorias = "SELECT id, nombre FROM categorias";
$resultadoCategorias = $mysqli->query($sqlCategorias);
$categoriasOptions = "";

if ($resultadoCategorias->num_rows > 0) {
    while ($row = $resultadoCategorias->fetch_assoc()) {
        // generacion de las actegorias a seleccionar dentro del fomr
        $categoriasOptions .= '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
}
?>

<?php include '../admin/pg_arriba.php'; ?>	
<?php include '../admin/pg_cabecera.php'; ?>
<div class="row" id="titModulo">
    <h2 style="text-align:center">Agregar Producto</h2>
</div>
<section id="flujo">
    <form action="prod_agg.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios" required>
        <br>

        <label for="descripcion">Descripción:</label>
        <textarea class="texttt" id="descripcion" name="descripcion" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios"></textarea>
        <br>

        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" pattern="^\d+(\.\d{1,2})?$" title="Formato de precio incorrecto. Ejemplo válido: 10 o 10.50" required>
        <br>

        <label for="existencias">Existencias:</label>
        <input type="number" id="existencias" name="existencias" pattern="[0-9]+" title="Solo se permiten números" required>
        <br>

        <label for="especificaciones">Especificaciones:</label>
        <textarea class="texttt" id="especificaciones" name="especificaciones"></textarea>
        <br><br>

        <label for="caracteristicas">Características:</label>
        <textarea class="texttt" id="caracteristicas" name="caracteristicas"></textarea>
        <br><br>

        <label for="contenido_empaque">Contenido de empaque:</label>
        <textarea class="texttt" id="contenido_empaque" name="contenido_empaque"></textarea>
        <br><br>


        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" onchange="getCategoriaSubcategorias(this.value)">
            <?php echo $categoriasOptions; ?>
        </select>
        <br>

        <label for="subcategoria">Subcategoría:</label>
<select id="subcategoria" name="subcategoria">
<?php echo $subcategoriasOptions; ?>
</select>
<br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select>
        <br>

        <label for="foto_principal">Foto Principal:</label>
        <input type="file" name="foto_principal" id="foto_principal" accept="image/*">
        <br><br>

        <label for="foto_uno">Foto Uno:</label>
        <input type="file" name="foto_uno" id="foto_uno" accept="image/*">
        <br><br>

        <label for="foto_dos">Foto Dos:</label>
        <input type="file" name="foto_dos" id="foto_dos" accept="image/*">
        <br><br>

        <label for="foto_tres">Foto Tres:</label>
        <input type="file" name="foto_tres" id="foto_tres" accept="image/*">
        <br><br>

        <input type="submit" value="Agregar Producto">
    </form>

</section>


<?php include '../admin/pg_abajo.php'; ?>
