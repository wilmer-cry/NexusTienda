<?php
session_start();
require '../../base_datos/database.php';
include '../carrito/pg_head.php';
include '../carrito/pg_header.php';

$codigo = $_SESSION["codigo"];

$sql = "SELECT * FROM direcciones_envio WHERE codigo = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>

<form action="carrito_datos_facturacion.php" method="POST" onsubmit="return validarSeleccion();">
    <?php if ($result->num_rows > 0) : ?>
        <br>
        <p id="mensajeActlabel">Selecciona una dirección de envío</p>
        <div class="row-container">

            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="direccion-card" onclick="seleccionarDireccion(this, '<?= $row['departamento'] ?>')">
                    <input type="radio" name="direccion_envio" value="<?= $row['id'] ?>">
                    <h4><?= $row['nombre_recibe'] . ' ' . $row['apellidos_recibe'] ?></h4>
                    <p><?= $row['direccion_exacta'] ?></p>
                    <p><?= $row['municipio'] . ', ' . $row['departamento'] ?></p>
                    <p><?= $row['referencia_indicaciones'] ?></p>
                    <p><?= $row['telefono'] ?></p>
                    <a href="#">Editar dirección</a>
                    <a><strong> | </strong></a>
                    <a href="#">Eliminar dirección</a>
                    <input type="hidden" name="departamento" value="<?= $row['departamento'] ?>">
                    <input type="hidden" name="nombre_recibe" value="<?= $row['nombre_recibe'] ?>">
                    <input type="hidden" name="apellidos_recibe" value="<?= $row['apellidos_recibe'] ?>">
                    <input type="hidden" name="direccion_exacta" value="<?= $row['direccion_exacta'] ?>">
                    <input type="hidden" name="municipio" value="<?= $row['municipio'] ?>">
                    <input type="hidden" name="referencia_indicaciones" value="<?= $row['referencia_indicaciones'] ?>">
                    <input type="hidden" name="telefono" value="<?= $row['telefono'] ?>">
                </div>
            <?php endwhile; ?>

        </div>
        <input type="hidden" id="direccion_seleccionada" name="direccion_seleccionada" value="">
        <input type="hidden" id="departamento_seleccionado" name="departamento" value="">
        <input id="botonesDireccion" type="submit" value="Continuar">
        <button id="botonesDireccion" type="button" onclick="agregarDireccion()">Agregar dirección</button>
    </form>
    <?php else : ?>
        <p>No tienes ninguna dirección de envío registrada.</p>
        <button id="botonesDireccion" type="button" onclick="agregarDireccion()">Agregar dirección de envío</button>
    </form>
    <?php endif;

    $stmt->close();
}
?>

<script>
    function seleccionarDireccion(element, departamento) {
        var radioButton = element.querySelector("input[type='radio']");
        var isSelected = radioButton.checked;

        var tarjetas = document.querySelectorAll(".direccion-card");
        tarjetas.forEach(function(tarjeta) {
            tarjeta.classList.remove("selected");
            tarjeta.querySelector("input[type='radio']").checked = false;
        });

        if (isSelected) {
            radioButton.checked = false;
            document.getElementById("direccion_seleccionada").value = "";
            document.getElementById("departamento_seleccionado").value = "";
        } else {
            element.classList.add("selected");
            radioButton.checked = true;
            document.getElementById("direccion_seleccionada").value = radioButton.value;
            document.getElementById("departamento_seleccionado").value = departamento;
        }
    }

    function validarSeleccion() {
        var radioButtons = document.getElementsByName("direccion_envio");
        var seleccionado = false;

        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                seleccionado = true;
                break;
            }
        }

        if (!seleccionado) {
            alert("Por favor, selecciona una dirección de envío antes de continuar.");
            return false;
        }
        return true;
    }

    function agregarDireccion() {
        window.location.href = "direccion_nueva.php";
    }
</script>
</body>
</html>
