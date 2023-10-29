<header>
        <div class="logo">
            <img src="../../img/logo.png" alt="Logo de la Empresa">
        </div>
        <nav>
            <ul>
            </ul>
        </nav>
        <div class="search-cart">
            <form action="prod_buscar.php" method="GET">
                <input type="text" name="producto" placeholder="Buscar productos">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <div>
            <?php
                echo "<img src='$imagen_path' alt='$pokemon_name' height='50'>";
            ?>
        </div>
            <a href="carrito_compras.php"><i class="<html lang="es">"></i></a>
        </div>
        <div class="login">
<?php
if (isset($_SESSION['usuario']) && isset($_SESSION['codigo'])) {
    echo '<a href="../login/login.php" class="get-started-btn scrollto">ENTRAR</a>';
} else {
    echo '<a href="../login/login.php" class="get-started-btn scrollto">INICIAR</a>';
}
?>
        </div>
    </header>
    <div id="header" class="fixed-top">
    <div class="containerd d-flex align-items-center justify-content-lg-between">
        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto" href="prod_mostrar.php">Principal</a></li>
                <li class="dropdown"><a href="#"><span>Categorias</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                    <?php foreach ($categorias as $categoria) : ?>
                    <li class="dropdown"><a href="#"><span><?php echo $categoria['nombre']; ?></span> <i class="bi bi-chevron-right"></i></a>
                        <ul>
                            <?php foreach ($subcategorias as $subcategoria) : ?>
                                <?php if ($subcategoria['id_categoria'] == $categoria['id']) : ?>
                                    <li><a href="prod_filtro_subcat.php?subcategoria_id=<?php echo $subcategoria['id_subcategoria']; ?>"><?php echo $subcategoria['nombre_subcategoria']; ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
                    </ul>
                </li> 
                <li>        
                <?php
if (isset($_SESSION['usuario']) && isset($_SESSION['codigo'])) {
    echo '<a href="../login/cerrar_sesion.php">Cerrar sesión</a>';
}
?>
        </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->
    </div>
</div><!-- End Header -->
<style>
    #header {
        transition: all 0.5s;
        z-index: 997;
        padding: 0px 0;
        background-color: #000000a1;
        text-align: center;
        padding-right: 20px;
        padding-left: 20px;
    }

    #header.header-scrolled,
    #header.header-inner-pages {
        background: rgba(0, 0, 0, 0.8);
    }

    /* Agrega estilos para los elementos del menú */
    .navbar ul {
        margin: 0;
        padding: 0;
        display: flex;
        list-style: none;
        justify-content: flex-end; /* Alinea los elementos al final del encabezado */
        align-items: center;
    }

    .navbar li {
        position: relative;
    }

    .navbar a,
    .navbar a:focus {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 0 5px 25px;
        font-size: 12px;
        font-weight: 10;
        color: #fff;
        white-space: nowrap;
        transition: 0.3s;
    }

    .navbar a i,
    .navbar a:focus i {
        font-size: 12px;
        line-height: 0;
        margin-left: 150px;
    }

    .navbar a:hover,
    .navbar .active,
    .navbar .active:focus,
    .navbar li:hover>a {
        color: #ff0000;
    }

    /* Estilos para el menú desplegable */
    .navbar .dropdown ul {
        display: block;
        position: absolute;
        left: 14px;
        top: calc(100% + 30px);
        margin: 0;
        padding: 20px 0;
        z-index: 99;
        opacity: 0;
        visibility: hidden;
        background: #fff;
        box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
        transition: 0.3s;
    }

    .navbar .dropdown ul li {
        min-width: 200px;
    }

    .navbar .dropdown ul a {
        padding: 0px 20px;
        font-size: 12px;
        text-transform: none;
        color: #151515;
        font-weight: 400;
        border-radius: 10px;
    }

    .navbar .dropdown ul a i {
        font-size: 12px;
    }

    .navbar .dropdown ul a:hover,
    .navbar .dropdown ul .active:hover,
    .navbar .dropdown ul li:hover>a {
        background-color: #ff0000;
        color: #fff;
    }

    .navbar .dropdown:hover>ul {
        opacity: 1;
        top: 100%;
        visibility: visible;
    }

    .navbar .dropdown .dropdown ul {
        top: 0;
        left: calc(100% - 30px);
        visibility: hidden;
    }

    .navbar .dropdown .dropdown:hover>ul {
        opacity: 1;
        top: 0;
        left: 100%;
        visibility: visible;
    }

    @media (max-width: 1366px) {
        .navbar .dropdown .dropdown ul {
            left: -90%;
        }

        .navbar .dropdown .dropdown:hover>ul {
            left: -100%;
        }
    }

    /* Estilos para el botón de menú móvil */
    .mobile-nav-toggle {
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        display: none;
        line-height: 0;
        transition: 0.5s;
    }

    @media (max-width: 991px) {
        .mobile-nav-toggle {
            display: block;
        }
    }

    /* Estilos para el menú móvil */
    .navbar-mobile {
        position: fixed;
        overflow: hidden;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.9);
        transition: 0.3s;
        z-index: 999;
    }

    .navbar-mobile .mobile-nav-toggle {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .navbar-mobile ul {
        display: block;
        position: absolute;
        top: 55px;
        right: 15px;
        bottom: 15px;
        left: 15px;
        padding: 10px 0;
        background-color: #fff;
        overflow-y: auto;
        transition: 0.3s;
    }

    .navbar-mobile a,
    .navbar-mobile a:focus {
        padding: 10px 20px;
        font-size: 12px;
        color: #151515;
    }

    .navbar-mobile a:hover,
    .navbar-mobile .active,
    .navbar-mobile li:hover>a {
        color: #151515;
        background-color: #ff0000;
    }

    .navbar-mobile .getstarted,
    .navbar-mobile .getstarted:focus {
        margin: 1px;
    }

    /* Estilos para el menú desplegable en móvil */
    .navbar-mobile .dropdown ul {
        position: static;
        display: none;
        margin: 15px 20px;
        padding: 15px 0;
        z-index: 99;
        opacity: 1;
        visibility: visible;
        background: #fff;
        box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
    }

    .navbar-mobile .dropdown ul li {
        min-width: 200px;
    }

    .navbar-mobile .dropdown ul a {
        padding: 10px 20px;
        color: #151515;
    }

    .navbar-mobile .dropdown ul a i {
        font-size: 12px;
    }

    .navbar-mobile .dropdown ul a:hover,
    .navbar-mobile .dropdown ul .active:hover,
    .navbar-mobile .dropdown ul li:hover>a {
        background-color: #ff0000;
    }

    .navbar-mobile .dropdown>.dropdown-active {
        display: block;
    }
</style>
