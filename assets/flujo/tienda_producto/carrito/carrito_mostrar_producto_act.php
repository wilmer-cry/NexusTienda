<?php
$usuario = $_SESSION['usuario'];
$codigo = $_SESSION['codigo'];
$status = '1';
echo '<br>';

$result = null;
include 'carrito_mostrar_producto_consulta.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['update_quantity'])) {
        $newQuantity = $_POST['new_quantity'];
        $productId = $_POST['product_id'];

        
        $sku = ''; 
        $getSkuQuery = "SELECT sku FROM carrito WHERE Id = ?";
        $getSkuStmt = $mysqli->prepare($getSkuQuery);
        $getSkuStmt->bind_param('i', $productId);
        $getSkuStmt->execute();
        $skuResult = $getSkuStmt->get_result();

        if ($skuResult && $skuRow = $skuResult->fetch_assoc()) {
            $sku = $skuRow['sku'];
        }

        
        $existencia = 0;
        $existenciaQuery = "SELECT existencias FROM producto WHERE sku = ?";
        $existenciaStmt = $mysqli->prepare($existenciaQuery);
        $existenciaStmt->bind_param('s', $sku);
        $existenciaStmt->execute();
        $existenciaResult = $existenciaStmt->get_result();
                
        
        if ($existenciaResult && $existenciaRow = $existenciaResult->fetch_assoc()) {$existencia = $existenciaRow['existencias'];}
        if ($newQuantity <= 0) {
            echo "<p id='mensajeNoAct'>Número incorrecto. Debe ser mayor que cero.</p>";
            include 'carrito_mostrar_producto_consulta.php';
        } elseif ($newQuantity <= $existencia) {
            $updateQuery = "UPDATE carrito SET Cantidad = ? WHERE Id = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param('ii', $newQuantity, $productId);
            $updateStmt->execute();
            echo "<p id='mensajeAct'>Cantidad actualizada con éxito</p>";
            include 'carrito_mostrar_producto_consulta.php';
        } else {
            echo "<p id='mensajeNoAct'>La cantidad supera las existencias</p>";
            include 'carrito_mostrar_producto_consulta.php';
    }
    }
}
?>      