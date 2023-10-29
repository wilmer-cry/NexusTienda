<?php
require '../base_datos/database.php';
session_start();
$codigoperfil = $_SESSION['codigo'];


function guardarImagen($nombreCampo, $nombre)
{
    $nombreArchivo = $_FILES[$nombreCampo]['name'];
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    $nuevoNombre = generarNombreUnico() . '.' . $extension;
    $ruta = '../../img_prods/' . $nuevoNombre;

    while (file_exists($ruta)) {
        $nuevoNombre = generarNombreUnico() . '.' . $extension;
        $ruta = '../../img_prods/' . $nuevoNombre;
    }

    move_uploaded_file($_FILES[$nombreCampo]['tmp_name'], $ruta);
    return $nuevoNombre;
}

function generarNombreUnico()
{
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $nombreUnico = '';
    for ($i = 0; $i < 10; $i++) {
        $nombreUnico .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $nombreUnico;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST["id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $existencias = $_POST["existencias"];
    $categoria = $_POST["categoria"];
    $status = $_POST["status"];
    
    
    $sql_select = "SELECT principal, especificaciones, foto_uno, foto_dos, foto_tres FROM producto WHERE id = ?";
    $stmt_select = $mysqli->prepare($sql_select);
    $stmt_select->bind_param("i", $id_producto);
    $stmt_select->execute();
    $stmt_select->bind_result($foto_principal_actual, $especificaciones_actual, $foto_uno_actual, $foto_dos_actual, $foto_tres_actual);
    $stmt_select->fetch();
    $stmt_select->close();

    
    if (!empty($_FILES['foto_principal']['name'])) {
        
        if ($foto_principal_actual != 'imagen_por_defecto.jpg' && file_exists('../../img_prods/' . $foto_principal_actual)) {
            unlink('../../img_prods/' . $foto_principal_actual);
        }
        $foto_principal = guardarImagen('foto_principal', $nombre);
    } else {
        
        $foto_principal = $foto_principal_actual;
    }
    
    
    if (!empty($_FILES['especificaciones']['name'])) {
        
        if ($especificaciones_actual != '' && file_exists('../../img_prods/' . $especificaciones_actual)) {
            unlink('../../img_prods/' . $especificaciones_actual);
        }
        $especificaciones = guardarImagen('especificaciones', $nombre);
    } else {
        
        $especificaciones = $especificaciones_actual;
    }

    
    $foto_uno = $foto_uno_actual;
    $foto_dos = $foto_dos_actual;
    $foto_tres = $foto_tres_actual;

    if (!empty($_FILES['foto_uno']['name'])) {
        
        if ($foto_uno_actual != '' && file_exists('../../img_prods/' . $foto_uno_actual)) {
            unlink('../../img_prods/' . $foto_uno_actual);
        }
        $foto_uno = guardarImagen('foto_uno', $nombre);
    }

    if (!empty($_FILES['foto_dos']['name'])) {
        
        if ($foto_dos_actual != '' && file_exists('../../img_prods/' . $foto_dos_actual)) {
            unlink('../../img_prods/' . $foto_dos_actual);
        }
        $foto_dos = guardarImagen('foto_dos', $nombre);
    }

    if (!empty($_FILES['foto_tres']['name'])) {
        
        if ($foto_tres_actual != '' && file_exists('../../img_prods/' . $foto_tres_actual)) {
            unlink('../../img_prods/' . $foto_tres_actual);
        }
        $foto_tres = guardarImagen('foto_tres', $nombre);
    }

    $sql_update = "UPDATE producto SET nombre = ?, descripcion = ?, precio = ?, existencias = ?, categoria = ?, status = ?, principal = ?, especificaciones = ?, foto_uno = ?, foto_dos = ?, foto_tres = ? WHERE id = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param("ssdisssssssi", $nombre, $descripcion, $precio, $existencias, $categoria, $status, $foto_principal, $especificaciones, $foto_uno, $foto_dos, $foto_tres, $id_producto);

    if ($stmt_update->execute()) {
        echo "Producto actualizado con éxito.";
    } else {
        echo "Error al actualizar el producto: " . $stmt_update->error;
    }
    $stmt_update->close();
    $mysqli->close();
}
?>
