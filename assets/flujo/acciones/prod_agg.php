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

function guardarImagenPrincipal($nombreCampo, $nombre)
{
    $nombreArchivo = $_FILES[$nombreCampo]['name'];
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    $nuevoNombre = $nombre . '.' . $extension;
    $ruta = '../../img_prods/' . $nuevoNombre;

    if (!file_exists($ruta)) {
        move_uploaded_file($_FILES[$nombreCampo]['tmp_name'], $ruta);
    } else {
        $nombreUnico = generarNombreUnico() . '.' . $extension;
        $ruta = '../../img_prods/' . $nombreUnico;
        move_uploaded_file($_FILES[$nombreCampo]['tmp_name'], $ruta);
        $nuevoNombre = $nombreUnico;
    }

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
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $existencias = $_POST["existencias"];
    $categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"]; 
    $status = $_POST["status"];
    $especificaciones = $_POST["especificaciones"];
    $caracteristicas = $_POST["caracteristicas"];
    $contenido_empaque = $_POST["contenido_empaque"];

    
    $sku = "NEXUS-" . date('YmdHis') . $categoria;

    
    if (!empty($_FILES['foto_principal']['name'])) {
        $foto_principal = guardarImagenPrincipal('foto_principal', $nombre);
    } else {
        $foto_principal = 'imagen_por_defecto.jpg'; 
    }
    
    $foto_uno = guardarImagen('foto_uno', $nombre);
    $foto_dos = guardarImagen('foto_dos', $nombre);
    $foto_tres = guardarImagen('foto_tres', $nombre);

    $sql = "INSERT INTO producto (sku, nombre, descripcion, precio, existencias, categoria, subcategoria, status, principal, especificaciones, caracteristicas, contenido_empaque, foto_uno, foto_dos, foto_tres, id_carga) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssdisssssssssss", $sku, $nombre, $descripcion, $precio, $existencias, $categoria, $subcategoria, $status, $foto_principal, $especificaciones, $caracteristicas, $contenido_empaque, $foto_uno, $foto_dos, $foto_tres, $codigoperfil);

    if ($stmt->execute()) {
        echo "Producto agregado con éxito.";
    } else {
        echo "Error al agregar el producto: " . $stmt->error;
    }
    $stmt->close();
    $mysqli->close();
}
?>
