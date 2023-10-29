<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';
?>

<div class="row" id="titModulo">
    <h2 style="text-align:center">NUEVO USUARIO</h2>
</div>
<section id="flujo">
    <form action="usuarios_procesar_agregar.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" pattern="[A-Za-z0-9\s]+" title="Solo se permiten letras, números y espacios" required>
        <br>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required>
        <br>

        <label for="id_cargo">ID de Cargo:</label>
        <input type="text" id="id_cargo" name="id_cargo" pattern="[0-9]+" title="Solo se permiten números" required>
        <br>

        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" pattern="[0-9]+" title="Solo se permiten números" required>
        <br>

        <input type="submit" value="Guardar Usuario">
    </form>
</section>
<?php include '../admin/pg_abajo.php'; ?>
