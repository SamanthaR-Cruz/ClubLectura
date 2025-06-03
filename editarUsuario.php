<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] != 1) {
    header("Location: sesion.php");
    exit;
}

if (!isset($_GET["id"])) {
    echo "ID de usuario no especificado.";
    exit;
}

$idUsuario = intval($_GET["id"]);

include_once("modelo/Usuario.php");
include_once("cabecera.html");
include_once("menu.php");

$usuario = new Usuario();

// Obtener datos actuales desde el modelo
if (!$usuario->cargarPorId($idUsuario)) {
    echo "<p>Usuario no encontrado.</p>";
    include_once("pie.html");
    exit;
}
?>

<section class="books-section">
  <h1>Editar Usuario</h1>

  <form method="post" action="editarUsuario.php?id=<?php echo $idUsuario; ?>" class="formulario-libro">
    <div class="campo-form">
      <label for="nombre">Nombre completo:</label>
      <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario->getNombre()); ?>" required>
    </div>

    <div class="campo-form">
      <label for="correo">Correo:</label>
      <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($usuario->getCorreo()); ?>" required>
    </div>

    <div class="campo-form">
      <label for="contrasena">Contraseña:</label>
      <input type="password" name="contrasena" id="contrasena" placeholder="Solo si deseas cambiarla">
    </div>

    <div class="campo-form">
      <label for="rol">Rol:</label>
      <select name="rol" id="rol" required>
        <option value="2" <?php if ($usuario->getRol() == 2) echo "selected"; ?>>Lector</option>
        <option value="1" <?php if ($usuario->getRol() == 1) echo "selected"; ?>>Administrador</option>
      </select>
    </div>

    <div class="boton-formulario">
      <button type="submit" name="actualizar" class="btn-agregar-libro">Actualizar</button>
    </div>
  </form>
</section>

</main>
<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>

<?php
// Proceso de actualización
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["actualizar"])) {
    $usuario->setNombre(trim($_POST["nombre"]));
    $usuario->setCorreo(trim($_POST["correo"]));
    $usuario->setRol(intval($_POST["rol"]));

    $nuevaContrasena = trim($_POST["contrasena"]);
    if ($nuevaContrasena !== "") {
        $usuario->setContrasena($nuevaContrasena);
    }

    if ($usuario->actualizar()) {
        echo "<script>
            const mensaje = 'Usuario actualizado correctamente.';
            const redireccion = 'crudU.php';
        </script>
        <script src='js/script-mensaje.js'></script>";
        exit;
    } else {
        echo "<p>Error al actualizar el usuario.</p>";
    }
}
?>
