<?php
// Archivo:  mybooks.php
// Objetivo: Visualizar mis libros
// Autor: 
?>

<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminarLibro"])) {
  include_once("modelo/LibroCliente.php");
  $idLibro = intval($_POST["eliminarLibro"]);
  $idUsuario = $_SESSION["usuario"];
  $oLCtemp = new LibroCliente();
  $oLCtemp->eliminarLibroUsuario($idLibro, $idUsuario);
  header("Location: mybooks.php");
  exit;
}


include_once("modelo/LibroCliente.php");
include_once("cabecera.html");
include_once("menu.php");

$idUsuario = $_SESSION["usuario"];
$nombre = $_SESSION["nombre"];

$oLC = new LibroCliente();
$librosCurso = $oLC->obtenerLibrosEnCurso($idUsuario);
$librosTerminados = $oLC->obtenerLibrosTerminados($idUsuario);
?>

<section class="books-section">
  <div class="header-libros">
    <h1>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h1>
    <a href="agregarLibro.php" class="btn-agregar-libro">+ Agregar libro</a>
  </div>

  <p><strong>Tus libros en curso:</strong></p>
  <?php if (count($librosCurso) > 0): ?>
  <table class="tabla-libros">
    <thead>
      <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Fecha de Inicio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($librosCurso as $libro): ?>
      <tr>
        <td><strong><?php echo htmlspecialchars($libro["titulo"]); ?></strong></td>
        <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
        <td><?php echo date("d-m-Y", strtotime($libro["fechaInicio"])); ?></td>
        <td>
        <a href="leer.php?idLibro=<?php echo $libro['idLibro']; ?>" class="btn-accion azul">Leer</a>
        <form method="post" name="formTerminarLibro<?php echo $libro['idLibro']; ?>" action="terminarLibro.php" style="display:inline;">
  <input type="hidden" name="idLibro" value="<?php echo $libro['idLibro']; ?>">
  <button type="button" class="btn-accion verde" onclick="confirmarTerminarLibro(<?php echo $libro['idLibro']; ?>)">Terminar</button>
</form>
          <form method="post" name="formEliminarLibroUsuario<?php echo $libro['idLibro']; ?>" style="display:inline;">
  <input type="hidden" name="eliminarLibro" value="<?php echo $libro['idLibro']; ?>">
  <button type="button" class="btn-accion rojo" onclick="confirmarEliminarLibroUsuario(<?php echo $libro['idLibro']; ?>)">🗑️</button>
</form>

        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p>No tienes libros en curso.</p>
  <?php endif; ?>

  <br><br>
  <p><strong>Libros terminados:</strong></p>
  <?php if (count($librosTerminados) > 0): ?>
  <table class="tabla-libros">
    <thead>
      <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Fecha de Inicio</th>
        <th>Fecha de Finalización</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($librosTerminados as $libro): ?>
      <tr>
        <td><strong><?php echo htmlspecialchars($libro["titulo"]); ?></strong></td>
        <td><?php echo htmlspecialchars($libro["autor"]); ?></td>
        <td><?php echo date("d-m-Y", strtotime($libro["fechaInicio"])); ?></td>
        <td><?php echo date("d-m-Y", strtotime($libro["fechaFin"])); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p>Aún no has terminado ningún libro.</p>
  <?php endif; ?>
</section>

</main>

<?php
include_once("aside.php");?>
<script src="js/script-confirmar.js"></script>
<?php include_once("pie.html");
?>
