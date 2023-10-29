<?php

session_start(); 
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login/login.php");
    exit();
}

require '../../base_datos/database.php';
include 'pg_head.php';
include 'pg_header.php';
include 'carrito_mostrar_producto_act.php';

?>

<div class="container">
    <div class="column">
        <br>
        <br>
        <br>
        <a href="../direccion/direccion_seleccion.php"><button id="botonpagar">Proceder a pagar</button></a>
        <br>
        <br>
        <div class="row">
            <table id="tablaCarrito">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>PRODUCTO</th>
                        <th>CANTIDAD</th>
                        <th>CONTENIDO</th>
                        <th>PRECIO U.</th>
                        <th>SUBTOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                    <tbody>
                        <?php 

                        $total_a_pagar = 0; 

                        if ($result !== null && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                
                                $sku = $row['sku'];
                                $query = "SELECT precio FROM producto WHERE sku = ?";
                                $stmt = $mysqli->prepare($query);
                                $stmt->bind_param("s", $sku);
                                $stmt->execute();
                                $priceResult = $stmt->get_result();

                                if ($priceResult->num_rows > 0) {
                                    $priceRow = $priceResult->fetch_assoc();
                                    $precio_unitario = $priceRow['precio'];
                                } else {
                                    $precio_unitario = 0; 
                                }

                                
                                $subtotal = $precio_unitario * $row['Cantidad'];

                                echo "<tr>";
                                echo "<td>" . $row['sku'] . "</td>";
                                echo "<td>" . $row['nombre_producto'] . "</td>";
                                echo "<td id='cellcantidad'>
                                    <form method='post'>
                                        <input id='ingresocantidadnueva' type='number' name='new_quantity' value='" . $row['Cantidad'] . "'>
                                        <input type='hidden' name='product_id' value='" . $row['Id'] . "'>
                                        <button id='botonActualziar'type='submit' name='update_quantity'>Actualizar</button>
                                    </form>
                                </td>";
                                echo "<td>" . $row['Contenido_empaque'] . "</td>";
                                
                                echo "<td>Q " . number_format($precio_unitario, 2) . "</td>";
                                
                                echo "<td>Q " . number_format($subtotal, 2) . "</td>";
                                echo "<td id='accioneselim'>
                                    <a id='eliminarRegistro' href='eliminar_producto.php?id=" . $row['Id'] . "'>Eliminar</a>
                                </td>";
                                echo "</tr>";

                                $total_a_pagar += $subtotal; 
                            }
                        } else {
                            echo "No se encontraron resultados en la consulta.";
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <!-- Muestra el Total a Pagar fuera de la tabla -->
        <div class="total-pagar"><p id="totalpagarcant">Total a Pagar: Q <?php echo number_format($total_a_pagar, 2); ?> + envio</p></div>
    </div>
</div>
</body>
</html>
