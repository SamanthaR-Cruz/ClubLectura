<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

include_once("modelo/Comentario.php");
include_once("cabecera.html");
include_once("menu.php");

$idUsuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];
$oComentario = new Comentario();

$busqueda = isset($_GET["buscar"]) ? trim($_GET["buscar"]) : "";
$comentarios = $oComentario->obtenerTodos($busqueda);
?>

<section class="foro-section">
  <h1>Comentarios del Club</h1>

  <form method="get" class="form-busqueda" style="margin-bottom: 20px;">
    <input type="text" name="buscar" placeholder="Buscar por autor..."
           value="<?php echo htmlspecialchars($busqueda); ?>" />
    <button type="submit" class="btn-agregar-libro">Buscar</button>
    <?php if (!empty($busqueda)): ?>
      <a href="comentarios.php" class="btn-agregar-libro" style="background-color:#aaa;">Ver todos</a>
    <?php endif; ?>
  </form>

  <div class="chat-box">
    <?php foreach ($comentarios as $c): ?>
      <div class="mensaje">
        <h3><?php echo htmlspecialchars($c[1]); ?></h3>
        <p><?php echo nl2br(htmlspecialchars($c[2])); ?></p>
        <small>Por <?php echo htmlspecialchars($c[3]); ?></small>
        <?php if ($rol == 1): ?>
          <form method="post" name="formEliminar<?php echo $c[0]; ?>" style="display:inline;">
            <input type="hidden" name="eliminar" value="<?php echo $c[0]; ?>">
            <button type="button" class="elim" onclick="confirmarEliminacionComentario(<?php echo $c[0]; ?>)">🗑️</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <h2>Escribe un comentario</h2>
  <form method="post" class="form-foro">
    <input type="text" name="titulo" placeholder="Título del comentario" required>
    <textarea name="descripcion" placeholder="Escribe tu comentario..." required></textarea>
    <button type="submit" name="publicar">Publicar</button>
  </form>
</section>

</main>
<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>
<script src="js/script-confirmar.js"></script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = "";
    if (isset($_POST["publicar"])) {
        $publicado = $oComentario->insertar($_POST["titulo"], $_POST["descripcion"], $idUsuario);
        $accion = $publicado ? "publicado" : "fallo";
    }

    if (isset($_POST["eliminar"]) && $rol == 1) {
        $eliminado = $oComentario->eliminar($_POST["eliminar"]);
        $accion = $eliminado ? "eliminado" : "fallo";
    }

    $mensaje = match ($accion) {
        "publicado" => "Comentario publicado correctamente.",
        "eliminado" => "Comentario eliminado correctamente.",
        default => "Ocurrió un error, intenta de nuevo."
    };

    echo "<script>
        const mensaje = '$mensaje';
        const redireccion = 'comentarios.php';
    </script>
    <script src='js/script-mensaje.js'></script>";
    exit;
}
?>
