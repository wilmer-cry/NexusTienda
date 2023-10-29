<?php 
foreach ($productos as $producto) : ?>
    <div class="product">
        <a href="../tienda_producto/mostrar_detalle.php?id=<?php echo $producto['id']; ?>">
            <div class="product-image">
                <img src="../../img_prods/<?php echo $producto['principal']; ?>" alt="<?php echo $producto['nombre']; ?>">
            </div>
            <h4 class="product-name"><?php echo $producto['nombre']; ?></h4>
            <p class="product-description"><?php echo $producto['descripcion']; ?></p>
        </a>
        <p id="precio" class="bottom-price">Precio: Q. <?php echo $producto['precio']; ?></p>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productImages = document.querySelectorAll('.product-image img');
        const productNames = document.querySelectorAll('.product-name');
        const productDescriptions = document.querySelectorAll('.product-description');

        productNames.forEach(h4 => {
            h4.style.minHeight = '25px';
        });

        productDescriptions.forEach(p => {
            p.style.minHeight = '50px';
        });
    });
</script>
