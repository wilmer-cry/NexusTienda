<?php
session_start();
session_unset();
session_destroy();


header("Location: ../tienda_producto/prod_mostrar.php"); 
exit();
?>
