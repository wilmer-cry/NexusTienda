<?php
$host = 'srv1166.hstgr.io';
$user = 'u160093759_will';
$password = 'LICETHVALE1wl*';
$database = 'u160093759_store';

global $mysqli;
$mysqli = new mysqli($host, $user, $password, $database);

// Verificar si la conexión fue exitosa
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');
?>
