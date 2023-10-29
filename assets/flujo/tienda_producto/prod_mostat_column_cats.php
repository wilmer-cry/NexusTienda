<div class="columncats" id="categoriasMenu">
        <h5 id="categoriasid">CATEGORIAS</h5>
            <ul>
                <?php foreach ($categorias as $categoria) : ?>
                    <li id="categoriass">
                        <a id="cats" href="prod_filtro_cat.php?categoria_id=<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></a>
                        <ul>
                            <?php foreach ($subcategorias as $subcategoria) : ?>
                                <?php if ($subcategoria['id_categoria'] == $categoria['id']) : ?>
                                    <li id="subcategoria">
                                        <a id="subcats" href="prod_filtro_subcat.php?subcategoria_id=<?php echo $subcategoria['id_subcategoria']; ?>"> ── <?php echo $subcategoria['nombre_subcategoria']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
</div>
