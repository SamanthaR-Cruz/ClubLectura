<?php
// Archivo:  sesion.php
// Objetivo: Formulario de inicio de sesion
// Autor: 
?>

<?php
include_once("cabecera.html");
include_once("menu.php");
?>

<section class="login-section">
    <h1>Iniciar Sesión</h1>
    <p>Accede a tu cuenta para continuar</p>

    <form id="lgn" method="post" action="login.php">
        <label for="txtNumCon">Número de control</label>
        <input type="text" name="txtNumCon" id="txtNumCon" required />

        <label for="txtContrasena">Contraseña</label>
        <input type="password" name="txtContrasena" id="txtContrasena" required />

        <button type="submit" class="btn-register green-light">Ingresar</button>
    </form>

    <div class="registro-extra">
        <p>¿Eres nuevo? Regístrate aquí:</p>
        <a href="registro.php" class="btn-register pink">Registrarme</a>
    </div>
</section>

</main>
</div>

<?php include_once("pie.html"); ?>


<?php
if (isset($_SESSION["mensaje_error"])) {
    echo "<script>
        const mensajeError = '" . addslashes($_SESSION["mensaje_error"]) . "';
    </script>";
    echo "<script src='js/script-error-login.js'></script>";
    unset($_SESSION["mensaje_error"]);
}
?>
