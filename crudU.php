<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] != 1) {
    header("Location: sesion.php");
    exit;
}

include_once("modelo/Usuario.php");
$oUsuario = new Usuario();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["eliminar"])) {
        $idEliminar = intval($_POST["eliminar"]);
        $eliminado = $oUsuario->eliminar($idEliminar);

        $mensaje = $eliminado
            ? "Usuario eliminado correctamente."
            : "No se pudo eliminar el usuario.";

        echo "<script>
            const mensaje = '$mensaje';
            const redireccion = 'crudU.php';
        </script>
        <script src='js/script-mensaje.js'></script>";
        exit;
    }

    if (isset($_POST["editar"])) {
        $idEditar = intval($_POST["editar"]);
        header("Location: editarUsuario.php?id=$idEditar");
        exit;
    }
}

include_once("cabecera.html");
include_once("menu.php");

$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : "";
$usuarios = $oUsuario->obtenerTodos($busqueda);
?>

<section class="books-section">
  <h1>Gestión de Usuarios</h1>

  <form method="get" class="form-busqueda">
    <input type="text" name="buscar" placeholder="Buscar por nombre o número de control..." 
           value="<?php echo htmlspecialchars($busqueda); ?>">
    <button type="submit" class="btn-agregar-libro">Buscar</button>
    <?php if ($busqueda !== ""): ?>
      <a href="crudU.php" class="btn-agregar-libro">Ver todos</a>
    <?php endif; ?>
  </form>

  <div class="chat-box">
    <?php if ($usuarios): ?>
      <?php foreach ($usuarios as $u): ?>
        <div class="mensaje">
          <p><strong><?php echo htmlspecialchars($u[2]); ?></strong></p>
          <p>Número de control: <?php echo htmlspecialchars($u[1]); ?><br>
             Correo: <?php echo htmlspecialchars($u[3]); ?><br>
             Rol: <?php echo ($u[4] == 1) ? 'Administrador' : 'Lector'; ?></p>

          <form method="post" style="display:inline;">
            <input type="hidden" name="editar" value="<?php echo $u[0]; ?>">
            <button class="btn-agregar-libro">Editar</button>
          </form>

          <form method="post" name="formEliminar<?php echo $u[0]; ?>" style="display:inline;">
            <input type="hidden" name="eliminar" value="<?php echo $u[0]; ?>">
            <button type="button" class="elim" onclick="confirmarEliminacionUsuario(<?php echo $u[0]; ?>)">Eliminar</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No se encontraron usuarios.</p>
    <?php endif; ?>
  </div>

  <a href="registro.php" class="btn-agregar-libro">+ Agregar nuevo usuario</a>
</section>

</main>
<script src="js/script-confirmar.js"></script>

<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>
