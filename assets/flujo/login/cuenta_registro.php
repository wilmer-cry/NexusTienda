<?php
    include'pg_arriba.php';
?>
    <form action="cuenta_registro_procesar.php" method="post">
        <h2 id="titulosid">CREAR CUENTA</h2>
<br>
        <label id="registrolabel" for="nombre">Nombre Completo:</label>
        <input type="text" name="nombre" required><br>

        <label id="registrolabel" for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required><br>

        <label id="registrolabel" for="pass">Contraseña:</label>
        <input type="password" name="pass" required><br>

        <label id="registrolabel" for="pass_confirm">Confirmar Contraseña:</label>
        <input type="password" name="pass_confirm" required><br>

        <input type="submit" value="Registrarse">
    </form>
<?php
    include'pg_abajo.php';
?>