<?php
    include'pg_arriba.php';
?>
    <form action="cambiar_contrasena.php" method="post">
    <h2 id="titulosid">CAMBIAR CONTRASEÑA</h2>
        <label id="registrolabel" for="codigo">Código de Recuperación:</label>
        <input type="text" name="codigo" required><br>
        
        <input type="hidden" name="correo" value="<?php echo isset($_GET['correo']) ? htmlspecialchars($_GET['correo']) : ''; ?>">
        
        <label id="registrolabel" for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" name="nueva_contrasena" required><br>

        <input type="submit" value="Cambiar Contraseña">
    </form>
<?php
    include'pg_abajo.php';
?>
