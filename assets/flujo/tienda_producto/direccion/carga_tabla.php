<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion_envio = $_POST["direccion_envio"];
    $departamento = $_POST["departamento"];
    $nombre_recibe = $_POST["nombre_recibe"];
    $apellidos_recibe = $_POST["apellidos_recibe"];
    $direccion_exacta = $_POST["direccion_exacta"];
    $municipio = $_POST["municipio"];
    $referencia_indicaciones = $_POST["referencia_indicaciones"];
    $telefono = $_POST["telefono"];
}
?>
