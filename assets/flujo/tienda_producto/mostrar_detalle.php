<?php
session_start(); 
include('../conf/configuracion.php');

require '../base_datos/database.php';
include 'prod_obtener_cat_subcat.php';
include 'mostrar_detalle_producto.php';
include 'prod_tienda_head_detalle.php';
include 'prod_tienda_header.php';
$idproducto=$_POST['id'];
?>

<div id="container">
    <div id="column1">
        <div id="row1">
            <div class="cell" id="mainCell">
                <img src="<?php echo obtenerImagen($producto_detalle['principal']); ?>" alt="Imagen Principal">
            </div>
        </div>
        <div id="row2">
            <div class="cell" id="image1" onclick="swapImages('image1')">
                <img src="<?php echo obtenerImagen($producto_detalle['foto_uno']); ?>" alt="Imagen 1">
            </div>
            <div class="cell" id="image2" onclick="swapImages('image2')">
                <img src="<?php echo obtenerImagen($producto_detalle['foto_dos']); ?>" alt="Imagen 2">
            </div>
            <div class="cell" id="image3" onclick="swapImages('image3')">
                <img src="<?php echo obtenerImagen($producto_detalle['foto_tres']); ?>" alt="Imagen 3">
            </div>
        </div>
    </div>
    <div id="column2" id="contenido_producto">
        <h1 id="productoname"><?php echo $producto_detalle['nombre']; ?></h1>
        <p><?php echo $producto_detalle['descripcion']; ?></p>
        <p>SKU:  <?php echo $producto_detalle['sku']; ?></p>
        <p>unicamente <?php echo $producto_detalle['existencias']; ?> existencias</p>
        <p id="precio_prod" class="bottom-price">PRECIO: Q<?php echo $producto_detalle['precio']; ?></p>
        <div class="cantidad-input-container">
            <form id="agregarCarritoForm" action="carrito/carrito_agregar_producto.php" method="post">
                <label for="cantidadInput">Cantidad</label>
                <input type="number" id="cantidadInput" name="cantidad" min="1" step="1">
                <input type="hidden" name="sku" value="<?php echo $producto_detalle['sku']; ?>">
                <input type="hidden" name="nombre" value="<?php echo $producto_detalle['nombre']; ?>">
                <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
                <input type="hidden" name="codigo" value="<?php echo $_SESSION['codigo']; ?>">
                <input type="hidden" name="contenido_empaque" value="<?php echo $producto_detalle['contenido_empaque']; ?>">
                <button type="submit" id="agregarCarritoButton">Agregar</button>
            </form>
        </div>
        <br>
        <br>
        <h5>ESPECIFICACIONES:</h5>
        <p><?php echo $producto_detalle['especificaciones']; ?></p>
        <h5>CARACTERISTICAS:</h5>
        <p><?php echo $producto_detalle['caracteristicas']; ?></p>
        <h5>CONTENIDO DE EMPAQUE:</h5>
        <p><?php echo $producto_detalle['contenido_empaque']; ?></p>
    </div>
</div>

<?php
include 'seccion_recomendado.php';
?>

<style>
    .carousel-container {
        border: #333;
        width: 88%;
        overflow: hidden;
        position: relative;
        margin-left: 6%;
        margin-top: 1%;
    }

    .cantidad-input-container {
        display: flex;
        align-items: center;
    }

    .cantidad-input-container label {
        margin-right: 10px;
    }

    .cantidad-input-container input {
        flex: 1;
        width: 50px;
    }

    .cantidad-input-container button {
        margin-left: 10px;
        background-color: #333;
        color: #fff;
    }

    .cantidad-input-container button:hover {
        margin-left: 10px;
        background-color: #ff0000;
        color: #fff;
    }
</style>

<script>
    function swapImages(imageId) {
        var mainImage = document.getElementById("mainCell").getElementsByTagName("img")[0];
        var clickedImage = document.getElementById(imageId).getElementsByTagName("img")[0];

        var mainImageSrc = mainImage.src;
        var clickedImageSrc = clickedImage.src;

        mainImage.src = clickedImageSrc;
        clickedImage.src = mainImageSrc;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const productImages = document.querySelectorAll('.product-image img');
        const desiredWidth = 380;
        const desiredHeight = 217;

        productImages.forEach(img => {
            const canvas = document.createElement('canvas');
            canvas.width = desiredWidth;
            canvas.height = desiredHeight;
            const context = canvas.getContext('2d');
            context.drawImage(img, 0, 0, desiredWidth, desiredHeight);
            img.src = canvas.toDataURL();
        });

        const carousel = document.querySelector('.carousel');
        const products = document.querySelectorAll('.product');
        const groupSize = 6;
        const totalProducts = 12;
        let currentIndex = 0;

        function nextSlide() {
            currentIndex = (currentIndex + 1) % totalProducts;
            updateCarousel();
        }

        function updateCarousel() {
            const offset = -currentIndex * (100 / totalProducts);
            carousel.style.transform = `translateX(${offset}%)`;
        }

        function startCarousel() {
            setInterval(nextSlide, 2000);
        }

        startCarousel();
    });
</script>

</body>
</html>
