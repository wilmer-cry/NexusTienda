<?php
session_start();
require '../../base_datos/database.php';
include '../carrito/pg_head.php';
include '../carrito/pg_header.php';

echo "<p id='mensajeActlabel'>Ingresa una direccion</p>";
?>
<div id="soloparabordecss">
<form id="nuevaDireccionForm" action="direccion_nuevo_guardar.php" method="POST">
    <label for="nombre">Nombre de quien recibe *</label>
    <input type="text" id="nombre" name="nombre" required>
    <br><br>

    <label for="apellidos">Apellidos de quien recibe *</label>
    <input type="text" id="apellidos" name="apellidos" required>
    <br><br>

    <label for="telefono">Número de teléfono *</label>
    <input type="tel" id="telefono" name="telefono" required>
    <br><br>

    <label for="departamento">Departamento *</label>
    <select id="departamento" name="departamento" required>
        <option value="Alta Verapaz">Alta Verapaz</option>
        <option value="Baja Verapaz">Baja Verapaz</option>
        <option value="Chimaltenago">Chimaltenago</option>
        <option value="Chiquimula">Chiquimula</option>
        <option value="Guatemala">Guatemala</option>
        <option value="El Progreso">El Progreso</option>
        <option value="Escuintla">Escuintla</option>
        <option value="Huehuetenango">Huehuetenango</option>
        <option value="Izabal">Izabal</option>
        <option value="Jalapa">Jalapa</option>
        <option value="Jutiapa">Jutiapa</option>
        <option value="Petén">Petén</option>
        <option value="Quetzaltenango">Quetzaltenango</option>
        <option value="Quiché">Quiché</option>
        <option value="Retalhuleu">Retalhuleu</option>
        <option value="Sacatepequez">Sacatepequez</option>
        <option value="San Marcos">San Marcos</option>
        <option value="Santa Rosa">Santa Rosa</option>
        <option value="Sololá">Sololá</option>
        <option value="Suchitepequez">Suchitepequez</option>
        <option value="Totonicapán">Totonicapán</option>
        <option value="Zacapa">Zacapa</option>
    </select>
    <br><br>

    <label for="municipio">Municipio *</label>
    <input type="text" id="municipio" name="municipio" required>
    <br><br>

    <label for="direccion">Dirección exacta *</label>
    <input type="text" id="direccion" name="direccion" required>
    <br><br>

    <label for="referencia">Referencia o indicaciones (opcional)</label>
    <textarea id="referencia" name="referencia" rows="4"></textarea>
    <br><br>

    <input id="btnCarga" class="btn-guardar" type="submit" value="Guardar Dirección"><a>Guardar</a></input>
    <a href="direccion_seleccion.php"><button id="btnCarga"class="btn-cancelar" type="button">Cancelar</button></a>
</form>
</div>
</body>
</html>
