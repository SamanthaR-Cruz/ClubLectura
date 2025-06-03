<?php
session_start();
if (!isset($_SESSION["usuario"])) {
  header("Location: sesion.php");
  exit;
}

include_once("cabecera.html");
include_once("menu.php");
include_once("modelo/Libro.php");

$oLibro = new Libro();

// Buscar libros
if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
  $libros = $oLibro->buscarPorTituloAutor(trim($_GET['q']));
} else {
  $libros = $oLibro->buscarTodos();
}

// Eliminar libro si se envió el POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminarLibro"]) && $_SESSION["rol"] == 1) {
  $idLibro = intval($_POST["eliminarLibro"]);

  $rutaArchivo = "pdfs/" . $idLibro . ".pdf";
  if (file_exists($rutaArchivo)) {
    unlink($rutaArchivo);
  }

  if ($oLibro->eliminar($idLibro)) {
    echo "<script>
            const mensaje = 'Libro eliminado correctamente.';
            const redireccion = 'agregarLibro.php';
          </script>
          <script src='js/script-mensaje.js'></script>";
  } else {
    echo "<script>
            const mensaje = 'Error al eliminar el libro.';
            const redireccion = 'agregarLibro.php';
          </script>
          <script src='js/script-mensaje.js'></script>";
  }
}
?>

<section class="books-section">
  <h1>Biblioteca Digital</h1>
  <p>Descubre tu próxima lectura</p>

  <form method="get" action="agregarLibro.php" class="busqueda-libro" style="margin-bottom: 20px; display: flex; gap: 10px;">
    <input type="text" name="q" placeholder="Buscar por título o autor..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
    <button type="submit" class="btn-agregar-libro">Buscar</button>
    <?php if (isset($_GET['q']) && !empty($_GET['q'])): ?>
      <a href="agregarLibro.php" class="btn-agregar-libro" style="background-color: #999;">Ver todos</a>
    <?php endif; ?>
  </form>

  <?php if ($_SESSION["rol"] == 1): ?>
    <div class="boton-formulario">
      <a href="formLibro.php" class="btn-agregar-libro">+ Añadir nuevo libro</a>
    </div>
  <?php endif; ?>

  <?php foreach ($libros as $libro): ?>
    <div class="art-libro">
      <h3><?php echo htmlspecialchars($libro->getTitulo()); ?></h3>
      <p><strong>Autor:</strong> <?php echo htmlspecialchars($libro->getAutor()); ?></p>
      <p><strong>Género:</strong> <?php echo htmlspecialchars($libro->getGenero()); ?></p>
      <p><strong>No. de páginas:</strong> <?php echo $libro->getNumPag(); ?></p>
      <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($libro->getDescripcion())); ?></p>
      <div class="libro-footer">
        <form action="agregarLibroUsuario.php" method="post" style="display:inline;">
          <input type="hidden" name="idLibro" value="<?php echo $libro->getId(); ?>">
          <button type="submit" class="btn-agregar">Agregar</button>
        </form>

        <?php if ($_SESSION["rol"] == 1): ?>
          <form method="post" style="display:inline;">
            <input type="hidden" name="eliminarLibro" value="<?php echo $libro->getId(); ?>">
            <button type="button" class="btn-accion rojo" onclick="confirmarEliminacionLibro(<?php echo $libro->getId(); ?>)">🗑️</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</section>

</main>

<?php include_once("aside.php"); ?>
<script src="js/script-confirmar.js"></script>
<?php include_once("pie.html"); ?>
