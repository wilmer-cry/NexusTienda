<?php
require '../../../vendor/autoload.php';
include("../base_datos/database.php");

if (!empty($_POST)) {
    $direccion_seleccionada = isset($_POST['direccion_seleccionada'])   ? $_POST['direccion_seleccionada'] : null;
    $departamento           = isset($_POST['departamento'])             ? $_POST['departamento'] : null;
    $municipio              = isset($_POST['municipio'])                ? $_POST['municipio'] : null;
    $nombre_recibe          = isset($_POST['nombre_recibe'])            ? $_POST['nombre_recibe'] : null;
    $apellido_recibe        = isset($_POST['apellidos_recibe'])         ? $_POST['apellidos_recibe'] : null;
    $direccion_exacta       = isset($_POST['direccion_exacta'])         ? $_POST['direccion_exacta'] : null;
    $nitFacturaicon         = isset($_POST['nit_facturacion'])          ? $_POST['nit_facturacion'] : null;
    $correo_facturacion     = isset($_POST['correo_facturacion'])       ? $_POST['correo_facturacion'] : null;
    $nombre_facturacion     = isset($_POST['nombre_facturacion'])       ? $_POST['nombre_facturacion'] : null;
    $direccion_facturacion  = isset($_POST['direccion_facturacion'])    ? $_POST['direccion_facturacion'] : null;
    
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
    $referencia_indicaciones = isset($_POST['referencia_indicaciones']) ? $_POST['referencia_indicaciones'] : null;
    $cantidad_a_pagar = isset($_POST['cantidad_a_pagar']) ? $_POST['cantidad_a_pagar'] : '0.01';

    // Verificar si el cliente con el NIT existe
    $sql = "SELECT id FROM clientes WHERE nit = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $nitFacturaicon);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // El cliente no existe, realizamos una inserción
            $stmt->close();
            $sql = "INSERT INTO clientes (nombre, nit, direccion_facturacion) VALUES (?, ?, ?)";
            $stmt = $mysqli->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $nombre_facturacion, $nitFacturaicon, $direccion_facturacion);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            // El cliente existe, actualizamos la columna "cargas"
            $stmt->bind_result($clienteId);
            $stmt->fetch();
            $stmt->close();

            $sql = "UPDATE clientes SET cargas = cargas + 1 WHERE id = ?";
            $stmt = $mysqli->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $clienteId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    // Configuración de la API de PayPal
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AZRjDZbqtv6aV3gJGdh6j8nQp8knhXaOToXk9R1q6x5XcXTW4cJYuG9bou-a5XqY8Fav1DkhP0qnkwiZ',     // Reemplaza con tu Client ID
            'ENUjYDPKcemaiUn9zltUaglJ_29ynzONnQlF8rf9PiCcUHMGeWLrHAelhELWSL9754vqkpbSFEJOqVlv'         // Reemplaza con tu Secret
        )
    );

    // Crea un pago en PayPal
    $payment = new \PayPal\Api\Payment();
    $payment->setIntent("sale")
        ->setPayer(
            new \PayPal\Api\Payer(['payment_method' => 'paypal'])
        )
        ->setTransactions([
            (new \PayPal\Api\Transaction())
                ->setAmount(new \PayPal\Api\Amount(['total' => $cantidad_a_pagar, 'currency' => 'USD']))
        ])
        ->setRedirectUrls(
            new \PayPal\Api\RedirectUrls([
                'return_url' => 'https://www.grupolotostore.com/finalsistemas/assets/flujo/paypal_config/realizado.php',  // Reemplaza con la URL de retorno exitoso
                'cancel_url' => 'https://www.grupolotostore.com/finalsistemas/assets/flujo/paypal_config/cancelado.php'  // Reemplaza con la URL de retorno cancelado
            ])
        );

    // Crea el pago en PayPal
    try {
        $payment->create($apiContext);

        // Redirecciona al usuario a la página de PayPal para completar la transacción
        header('Location: ' . $payment->getApprovalLink());
    } catch (Exception $ex) {
        // Manejo de errores, puedes imprimir el mensaje de error o realizar otras acciones
        die($ex);
    }
} else {
    // Manejo de la falta de datos POST, puedes redirigir al usuario a una página de error o realizar otras acciones
    echo "No se han recibido datos POST.";
}
?>
