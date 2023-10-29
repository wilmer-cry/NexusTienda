<!DOCTYPE html>
<html>
<head>
    <style>
       
        .direccion-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            line-height: 0.3;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            cursor: pointer;
            transition: background-color 0.3s;
        }

       
        .direccion-card a {
            text-decoration: none;
            color: #0077cc;
        }

       
        .direccion-card input[type="radio"] {
            display: none;
        }

       
        .direccion-card.selected {
            background-color: #0077cc;
            color: #fff;
        }

       
        .row-container {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
<h2>Datos de Facturación</h2>

<form action="finalizar_compra.php" method="POST">
    <label for="nombre_facturacion">Nombre de facturación *</label>
    <input type="text" id="nombre_facturacion" name="nombre_facturacion" required>
    <br><br>

    <label for="nit_facturacion">NIT de facturación *</label>
    <input type="text" id="nit_facturacion" name="nit_facturacion" required>
    <br><br>

    <label for="direccion_facturacion">Dirección de facturación *</label>
    <input type="text" id="direccion_facturacion" name="direccion_facturacion" required>
    <br><br>

    <label for="correo_facturacion">Correo electrónico de facturación *</label>
    <input type="email" id="correo_facturacion" name="correo_facturacion" required>
    <br><br>

    <!-- Agrega más campos según tus necesidades -->

    <?php
    require_once('../login/validar_sesion_iniciada.php');
    require '../base_datos/database.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
    $sql = "SELECT SUM(p.precio * c.cantidad) AS total_a_pagar
            FROM carrito c
            JOIN producto p ON c.sku = p.sku
            WHERE c.codigo = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $_SESSION['codigo']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_items = $row['total_a_pagar'];
        } else {
            $total_items = 0;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

    
    if (isset($_POST['departamento'])) {
        $departamento = $_POST['departamento'];
        $sql = "SELECT precio FROM precio_envio WHERE nombre = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $departamento);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $precio_envio = $row['precio'];
            } else {
                $precio_envio = 0;
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta del precio de envío.";
        }
    }

    
    $total_combinado = $total_items + $precio_envio;

    echo "<p>Cantidad por items: Q " . number_format($total_items, 2) . "</p>";
    if (isset($precio_envio)) {
        echo "<p>Cantidad por envío ($departamento): Q " . number_format($precio_envio, 2) . "</p>";
    }

    
    echo "<p>Total a pagar (items + envio): Q " . number_format($total_combinado, 2) . "</p>";
    ?>

    <input type="submit" value="Continuar a Pago">
    <input type="hidden" name="departamento" value="<?php echo $departamento; ?>">
</form>

</body>
</html>
