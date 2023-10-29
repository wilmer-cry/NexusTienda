<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">EDITAR PRODUCTO PRODUCTOS</h2>
</div>
<section id="flujo">
<?php
    
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_producto = $_GET['id'];
        
        $sql = "SELECT * FROM producto WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            ?>
            <form action="producto_update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>
                <label for="precio">Precio:</label>
                <input type="text" name="precio" value="<?php echo $row['precio']; ?>"><br>
                <label for="existencias">Existencias:</label>
                <input type="text" name="existencias" value="<?php echo $row['existencias']; ?>"><br>
                <label for="categoria">Categoría:</label>
                <input type="text" name="categoria" value="<?php echo $row['categoria']; ?>"><br>
                <label for="status">Status:</label>
                <input type="text" name="status" value="<?php echo $row['status']; ?>"><br>
                <label for="especificaciones">Especificaciones:</label>
                <input type="file" name="especificaciones"><br>
                <label for="foto_principal">Foto Principal:</label>
                <input type="file" name="foto_principal"><br>
                <label for="foto_uno">Foto Uno:</label>
                <input type="file" name="foto_uno"><br>
                <label for="foto_dos">Foto Dos:</label>
                <input type="file" name="foto_dos"><br>
                <label for="foto_tres">Foto Tres:</label>
                <input type="file" name="foto_tres"><br>
                <img src="../../img_prods/<?php echo $row['principal']; ?>" alt="<?php echo $row['nombre']; ?>" width="200"><br>
                <input type="hidden" name="imagen_actual_especificaciones" value="<?php echo $row['especificaciones']; ?>">
                <input type="hidden" name="imagen_actual_principal" value="<?php echo $row['principal']; ?>">
                <input type="hidden" name="imagen_actual_foto_uno" value="<?php echo $row['foto_uno']; ?>">
                <input type="hidden" name="imagen_actual_foto_dos" value="<?php echo $row['foto_dos']; ?>">
                <input type="hidden" name="imagen_actual_foto_tres" value="<?php echo $row['foto_tres']; ?>">
                <input type="submit" value="Guardar Cambios">
                <a href="producto_mostrar_todos.php" id="botonesformms">Cancelar</a>
            </form>
            <br>
            <br>
            <br>
            <br>
    <?php
        } else {
            echo "Producto no encontrado.";
        }
        $stmt->close();
    } else {
        echo "ID de producto no válido.";
    }
 include '../admin/pg_abajo.php'; ?>