<?php
    include'pg_arriba.php';
?>
    
    <form action="enviar_codigo_recuperacion.php" method="post">
    <h2 id="titulosid">Recuperar Cuenta</h2>
        <label id="registrolabel" for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required><br>
        <input type="submit" value="Enviar Código de Recuperación">
    </form>
<?php
    include'pg_abajo.php';
?>
        