<?php
include '../admin/pg_arriba.php';
include '../admin/pg_cabecera.php';
require '../base_datos/database.php';
?>
<style>
    #titModulo {
        text-align: left;
        align-items: left;
        align-content: left;
    }

    #flujo form{
        text-align: left;
        font-size:12px;
    }

    #flujo form span{ 
        text-align: right;
        font-size:12px;
    }


    #flujo img {
        display: block;
    }
    
    #flujo span, #flujo strong {
        line-height: 0.3;
    }
    #botonEditar{
        margin-left: 43%;
        margin-right: 43%;
        width: 100%;
        padding: 5px 70px;
        background-color: #333;
        color:  #fff;
        font-size:12px;
        border-radius: 10px;
        text-decoration: none;
    }
    #botonEditar:hover{
        margin-left: 43%;
        margin-right: 43%;
        width: 100%;
        padding: 5px 70px;
        background-color: #28B463;
        color:  #fff;
        font-size:12px;
        border-radius: 10px;
        text-decoration: none;
    }

    #formVolver button{
        margin-top: 7px;
        margin-left: 32%;
        margin-left: 32%;
        width: 38%;
        padding: 5px 70px;
        background-color: #28B463;
        color:  #fff;
        font-size:12px;
        border-radius: 10px;
        text-decoration: none;}

        #formVolver button:hover{
        margin-top: 7px;
        margin-left: 32%;
        margin-left: 32%;
        width: 38%;
        padding: 5px 70px;
        background-color: #ff0000;
        color:  #fff;
        font-size:12px;
        border-radius: 10px;
        text-decoration: none;}
        .flujoInformacion{
            margin-bottom: 50px;
        }

</style>

<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto = $_GET['id'];

    $sql = "SELECT * FROM producto WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        echo '<div class="row" id="titModulo">';
        echo '<h2 style="text-align:center">DETALLES DEL PRODUCTO</h2>';
        echo '</div>';

        echo '<section class="flujoInformacion" id="flujo">';
        echo '<form>';
        echo '<strong>ID de Carga:</strong> <span>' . $row['id_carga'] . '</span><br>';   
        echo '<strong>NOMBRE:            </strong> <span>' . $row['nombre'] . '</span><br>';
        echo '<strong>SKU:               </strong> <span>' . $row['sku'] . '</span><br>';
        echo '<strong>Descripción:       </strong> <span>' . $row['descripcion'] . '</span><br>';
        echo '<strong>Precio:            </strong> <span>' . $row['precio'] . '</span><br>';
        echo '<strong>Existencias:       </strong> <span>' . $row['existencias'] . '</span><br>';
        echo '<strong>Categoría:         </strong> <span>' . $row['categoria'] . '</span><br>';
        echo '<strong>Subcategoría:      </strong> <span>' . $row['subcategoria'] . '</span><br>';
        echo '<strong>Status:            </strong> <span>' . $row['status'] . '</span><br>';
        echo '<strong>Creación:          </strong> <span>' . $row['fecha_creacion'] . '</span><br>';
        echo '<strong>Actualización:     </strong> <span>' . $row['fecha_actualizacion'] . '</span><br>';
        echo '<strong>Especificaciones:  </strong> <span>' . $row['especificaciones'] . '</span><br>';
        echo '<strong>Características:   </strong> <span>' . $row['caracteristicas'] . '</span><br>';
        echo '<strong>Contenido:         </strong> <span>' . $row['contenido_empaque'] . '</span><br>';

        echo '<strong>Imagen Principal:</strong> <img src="../../img_prods/' . $row['principal'] . '" alt="' . $row['nombre'] . '" width="200"><br>';
        echo '<strong>Foto Uno:</strong> <img src="../../img_prods/' . $row['foto_uno'] . '" alt="' . $row['nombre'] . '" width="100"><br>';
        echo '<strong>Foto Dos:</strong> <img src="../../img_prods/' . $row['foto_dos'] . '" alt="' . $row['nombre'] . '" width="100"><br>';
        echo '<strong>Foto Tres:</strong> <img src="../../img_prods/' . $row['foto_tres'] . '" alt="' . $row['nombre'] . '" width="100"><br>';
        echo '</form>';
        echo '<a id="botonEditar" href="producto_edit.php?id=' . $row['id'] . '">Editar</a>';
        echo '<form id="formVolver" method="get" action="producto_mostrar_todos.php">';
        echo '<button type="submit">Volver</button>';
        echo '</form>';
        echo '</section>';
    } else {
        echo 'Producto no encontrado.';
    }
    $stmt->close();
} else {
    echo 'ID de producto no válido.';
}
include '../admin/pg_abajo.php';
?>
