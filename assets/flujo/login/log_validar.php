<?php
session_start();
$usuario = $_POST['usuario'];
$contrasena = $_POST['pass'];

// configuracion de base de datos :)
include("../base_datos/database.php");
$statusss='1';
$consulta = "SELECT * FROM usuarios WHERE usuario = ? AND status= ?";
$stmt = $mysqli->prepare($consulta);
$stmt->bind_param("ss", $usuario, $statusss);
$stmt->execute();
$resultado = $stmt->get_result();
$filas = $resultado->fetch_assoc();

if ($filas && $filas['pass'] === md5($contrasena)) {
    // La contraseña es válida
    $_SESSION['usuario'] = $usuario;
    $_SESSION['codigo'] = $filas['codigo'];
    $_SESSION['id_usuario'] = $filas['id_usuario'];
    $_SESSION['nombre_usuario'] = $filas['nombre_usuario'];
    $_SESSION['correo'] = $filas['correo'];
    $_SESSION['id_cargo']=$filas['id_cargo'];

    //PODEMOS GENERAR ROLES DESDE ADMINS EN ESTA PARTRE

    if (isset($filas['id_cargo']) && $filas['id_cargo'] == 1) {
        header("Location: ../acciones/producto_mostrar_todos.php");
        exit();
    } elseif (isset($filas['id_cargo']) && $filas['id_cargo'] == 2) {
        header("Location: ../tienda_producto/principal_admin.php");
        exit();
    } else {
        include'../login/cerrar_sesion.php';
        header("Location: login.php");
        exit();
    }
} else {
    // La contraseña es incorrecta o el usuario no existe
    include("login.php");
    echo "<br><br><h1 class='bad'>ERROR EN LA AUTENTIFICACION</h1>";
}

$stmt->close();
$mysqli->close();
?>
