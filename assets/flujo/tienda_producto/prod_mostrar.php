
<?php 
session_start(); 
    include'filtro_obtener_productos.php'; 
    include'prod_tienda_head.php'; 
    include'prod_tienda_header.php';
    include'seccion_baner.php';
    
?>
<div class="container">
    <div class="column">
        <div class="row">
            <?php 
            include'seccion_recomendado.php';
            include'mostrar_productos.php'; 
            ?>
        </div>
    </div>
</div>
</body>
</html>
