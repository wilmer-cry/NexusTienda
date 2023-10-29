<?php
include("../base_datos/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["codigo"]) && isset($_POST["correo"])) {
        $codigo_ingresado = $_POST["codigo"];
        $correo = $_POST["correo"];

        
        if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $correo = mysqli_real_escape_string($mysqli, $correo);
            $codigo_ingresado = mysqli_real_escape_string($mysqli, $codigo_ingresado);

            
            $sql = "SELECT codigo FROM valida_codigo WHERE correo = '$correo' AND codigo = '$codigo_ingresado'";
            $result = $mysqli->query($sql);

            if ($result) {
                if ($result->num_rows > 0) {
                    
                    $update_sql = "UPDATE usuarios SET status = 1 WHERE correo = '$correo'";
                    if ($mysqli->query($update_sql) === TRUE) {
                        echo '<script type="text/javascript">alert("Tu cuenta ha sido creada.");</script>';
                        header("Location: login.php");
                        exit();
                    } else {
                        
                        error_log("Error al activar la cuenta: " . $mysqli->error);
                    }
                } else {
                    
                    $error_message = "El código ingresado no coincide con el código de seguridad. Inténtelo de nuevo.";
                }
            } else {
                
                error_log("Error en la consulta SQL: " . $mysqli->error);
            }
        } else {
            
            $error_message = "El formato del correo electrónico es incorrecto.";
        }
    }
}

$mysqli->close();
?>

<?php include 'pg_arriba.php'; ?>

<form action="validar_codigo.php" method="post">
    <h2 id="titulosid">VALIDAR CÓDIGO</h2>
    <br>
    <?php if (isset($error_message)) : ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <label id="registrolabel" for="codigo">Código de Seguridad:</label>
    <input type="text" name="codigo" required><br>

    <input type="hidden" name="correo" value="<?php echo isset($_GET['correo']) ? htmlspecialchars($_GET['correo']) : ''; ?>">
    <input type="submit" value="Validar">
</form>

<?php include 'pg_abajo.php'; ?>
