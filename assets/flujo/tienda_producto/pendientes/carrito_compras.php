
<?php
    require_once('../login/validar_sesion_iniciada.php');
    include 'filtro_obtener_productos.php'; 
    include '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    
    <link rel="icon"       href="../../img/fav.png" >
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/header_tienda.css">
    <link rel="stylesheet" href="../../css/cuerpo_tienda.css">
    <link rel="stylesheet" href="../../css/cats.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>'; 
    include 'prod_tienda_header.php';
?>

<div class="container">
    <div class="column">
        <div class="row">
                <style>
                    #tabla_carrito {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    #tabla_carrito, #tabla_carrito th, #tabla_carrito td {
                        border: 1px solid #ccc;
                    }

                    #tabla_carrito th, #tabla_carrito td {
                        padding: 8px;
                        text-align: left;
                        font-size: 11px;
                    }

                    #tabla_carrito th {
                        background-color: #f2f2f2;
                        font-size: 11px;
                    }

                    /* Estilos para los botones */
                    #tabla_carrito a {
                        text-decoration: none;
                        padding: 5px 10px;
                        margin: 2px;
                        border-radius: 10px;
                        background-color: #f2f2f2;
                        color: #333;
                    }
                    #tabla_carrito a:hover {
                        text-decoration: none;
                        padding: 5px 10px;
                        margin: 2px;
                        border-radius: 10px;
                        background-color: #ff0000;
                        color: #fff;
                    }

                    #tabla_carrito th a:hover {
                        background-color: #555;
                        color: #fff;
                    }
                    .boton-pagar{
                        padding: 10px 10px;
                        border-radius: 10px;
                        background-color: #333;
                        color: #fff;
                    }
                    .boton-pagar:hover{
                        padding: 10px 10px;
                        border-radius: 10px;
                        background-color: #ff0000;
                        color: #fff;
                    }
                </style>


                <?php
                require '../base_datos/database.php';

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['codigo'])) {
                    $codigo = $_SESSION['codigo'];
                    if ($mysqli) {
                        $sql = "SELECT * FROM carrito WHERE codigo = ?";
                        $stmt = $mysqli->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $codigo);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            echo "<table border='1' id='tabla_carrito'>
                                <tr>
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Usuario</th>
                                    <th>Código</th>
                                    <th>Contenido del Empaque</th>
                                    <th>Acciones</th> <!-- Columna para botones de acción -->
                                </tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['sku'] . "</td>
                                    <td>" . $row['nombre'] . "</td>
                                    <td>" . $row['cantidad'] . "</td>
                                    <td>" . $row['usuario'] . "</td>
                                    <td>" . $row['codigo'] . "</td>
                                    <td>" . $row['contenido_empaque'] . "</td>
                                    <td>
                                    <a href='carrito_eliminar_prod.php?id=" . $row['id'] . "'>Eliminar</a>
                                    </td>
                                </tr>";
                            }
                            echo "</table";
                            $stmt->close();
                        } else {
                            echo "Error en la preparación de la consulta.";
                        }
                        $mysqli->close();
                    } else {
                        echo "Error en la conexión a la base de datos.";
                    }
                } else {
                    echo "La variable de sesión 'codigo' no está definida.";
                }
                ?>
                 <div style="text-align: center; margin-top: 20px;">
                <a href="pago_seleccion_envio.php" class="boton-pagar">Comprar</a>
 

                    
                </p>
            </div>
            <br>
                <br>
                <h4><strong>INSTRUCCIONES PARA DEPOSITAR</strong></h4>
                <p>Tienes 24 horas para realizar tu pago y enviar comprobante, de lo contrario no podemos asegurar la disponibilidad del producto.
                   Te enviaremos un correo con un botón para subir tu boleta o pantallazo de transferencia. o bien puedes enviar tu comprobante a nuestro <strong>Whatsapp: +502 4758-8070</strong></p>
                <br>
                   <p>Cuentas monetarias de Nexus Guatemala SA:</p>    
                <p>Banco Industrial: <strong>1440041372</strong></p>       
                <p>Banrural:         <strong>3723013881</strong></p>        
                <p>G&T:              <strong>06600331055</strong></p>        
        </div>
    </div>
</div>
</body>
</html>
