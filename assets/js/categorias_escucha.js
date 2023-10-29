function getCategoriaSubcategorias(categoriaId) {
    console.log("Categoría seleccionada: " + categoriaId);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "prod_agg_prod_obten_subcat.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta AJAX recibida: " + xhr.responseText);
                // Actualiza el contenido del select de subcategorías con las opciones recibidas
                var subcategoriaSelect = document.getElementById("subcategoria");
                subcategoriaSelect.innerHTML = xhr.responseText;
            } else {
                console.error("Error en la solicitud AJAX. Estado: " + xhr.status);
            }
        }
    };
    xhr.send("categoriaId=" + categoriaId);
}