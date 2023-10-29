<?php
    include'pg_arriba.php';
?>
   <form action="log_validar.php" method="post">
       <h1 class="animate__animated animate__backInLeft"><a href="../../../index.php"><img width="300px" src="../../img/logo.png" alt=""></a></h1> 
       <br>
       <p><input type="text" placeholder="Ingrese su usuario" name="usuario"></p>
       <p><input type="password" placeholder="Ingrese su contraseña" name="pass"></p>
       <input type="submit" value="Ingresar">
       
       <!-- Agregamos los enlaces "Crear cuenta" y "Olvidé mi contraseña" dentro del formulario -->
       <div class="additional-links">
           <p id="boton_registro"><a href="cuenta_registro.php" id="registrarse">Crear cuenta</a></p>
           <p><a href="cuenta_recuperar.php">Olvidé mi contraseña</a></p>
       </div>
   </form>
<?php
    include'pg_abajo.php';
?>
