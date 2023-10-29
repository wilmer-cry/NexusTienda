<?php
include "seccion_obt_recomendado.php"
?>

<div class="carousel-container">
    <h5 id="recomendados">Recomendados</h5>
    <div class="carousel">
        <?php foreach ($productoss as $productosr) : ?>
            <div class="product producto-slide">
                <a href="../tienda_producto/mostrar_detalle.php?id=<?php echo $productosr['id']; ?>">
                    <div class="product-image">
                        <img src="../../img_prods/<?php echo $productosr['principal']; ?>" alt="<?php echo $productosr['nombre']; ?>">
                    </div>
                    <h4><?php echo $productosr['nombre']; ?></h4>
                    <p><?php echo $productosr['descripcion']; ?></p>
                    <p id="precio" class="bottom-price">Precio: Q. <?php echo $productosr['precio']; ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<style>
    #recomendados{
        background-color: #FF1A00;
        border-radius: 15px;
        padding: 4px 1px;
        padding-left: 20px;
        margin-right: 75%;
        color: #fff;
        border: 1px solid #CCC;
    }
    
    .carousel-container {
        border: #333;
        width: 98%;
        overflow: hidden;
        position: relative;
        margin-left: 1%;
}

.carousel {
    display: flex;
    transition: transform 1s ease-in-out;
}

.producto-slide {
    flex: 0 0 calc(100% / 6);
    border: 3px solid #EFEFEF;
    padding-right: -500px;
    margin-right: 10px;
}

.product-image {
    max-width: 100%;
    height: auto;
}

</style>

<script>
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
</script>
