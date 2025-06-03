<?php
// Archivo:  registro.php
// Objetivo: Formulario de registro para nuevos usuarios
// Autor: 
?>

<?php
session_start();
include_once("cabecera.html");
include_once("menu.php");
?>

<section class="crt-section">
    <h1>¡Únete a nuestro Club de Lectura!</h1>
    <p>Completa el formulario para inscribirte y ser parte de esta gran comunidad lectora</p>

    <form id="crt" method="post" action="registro.php">
    <h2>Formulario de inscripción</h2>

    <label for="txtNumCon">Número de control:</label>
    <input type="text" name="txtNumCon" id="txtNumCon" required />

    <label for="txtNomCon">Nombre completo:</label>
    <input type="text" name="txtNomCon" id="txtNomCon" required />
    
    <label for="txtCorreo">Correo electrónico:</label>
    <input type="email" name="txtCorreo" id="txtCorreo" required />

    <label for="txtContrasena">Contraseña:</label>
    <input type="password" name="txtContrasena" id="txtContrasena" required />
    
    <label for="txtCContrasena">Confirmar contraseña:</label>
    <input type="password" name="txtCContrasena" id="txtCContrasena" required />

    <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1): ?>
        <label for="rol">Rol del usuario:</label>
        <select name="rol" id="rol" required>
            <option value="2" selected>Lector</option>
            <option value="1">Administrador</option>
        </select>
    <?php endif; ?>

    <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1): ?>
  <button type="submit" class="btn-registrar">Registrar usuario</button>
<?php else: ?>
  <button type="submit" class="btn-registrar">Registrarme</button>
<?php endif; ?>

    </form>
</section>

</main>

<?php
include_once("aside.php");
include_once("pie.html");
?>

<?php
include_once("modelo/Usuario.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numcon = $_POST["txtNumCon"];
    $nombre = $_POST["txtNomCon"];
    $correo = $_POST["txtCorreo"];
    $pass = $_POST["txtContrasena"];
    $cpass = $_POST["txtCContrasena"];
    $rol = (isset($_SESSION["rol"]) && $_SESSION["rol"] == 1 && isset($_POST["rol"])) ? intval($_POST["rol"]) : 2;

    if ($pass !== $cpass) {
        echo "<script>
                const mensaje = 'Las contraseñas no coinciden';
                const redireccion = 'registro.php';
              </script>
              <script src='js/script-mensaje.js'></script>";
    } else {
        $oUsu = new Usuario();
        $oUsu->setNumCon($numcon);
        $oUsu->setNombre($nombre);
        $oUsu->setCorreo($correo);
        $oUsu->setContrasena($pass);
        $oUsu->setRol($rol);

        try {
            if ($oUsu->agregar()) {
                echo "<script>
                        const mensaje = '¡Registro exitoso! Inicia sesión.';
                        const redireccion = 'sesion.php';
                      </script>
                      <script src='js/script-mensaje.js'></script>";
            } else {
                echo "<script>
                        const mensaje = 'No se pudo registrar. Intenta con otro número de control.';
                        const redireccion = 'registro.php';
                      </script>
                      <script src='js/script-mensaje.js'></script>";
            }
        } catch (Exception $e) {
            echo "<script>
                    const mensaje = 'Error en el registro: " . addslashes($e->getMessage()) . "';
                    const redireccion = 'registro.php';
                  </script>
                  <script src='js/script-mensaje.js'></script>";
        }
    }
}
?>
