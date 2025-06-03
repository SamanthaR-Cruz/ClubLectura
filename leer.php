<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

if (!isset($_GET["idLibro"])) {
    echo "ID de libro no especificado.";
    exit;
}

include_once("modelo/LectorLibros.php");
include_once("cabecera.html");
include_once("menu.php");

$idLibro = $_GET["idLibro"];
$rutaPDF = LectorLibros::obtenerRutaPDF($idLibro);
?>

<section class="books-section">
  <div class="header-libros">
    <h1>Lector</h1>
    <a href="mybooks.php" class="btn-agregar-libro">← Volver a Mis Libros</a>
  </div>

  <?php if ($rutaPDF): ?>
    <div class="contenedor-pdf" style="margin-top: 20px;">
      <iframe src="<?php echo $rutaPDF; ?>" 
              width="100%" 
              height="500px" 
              style="border-radius: 10px;">
      </iframe>
    </div>
  <?php else: ?>
    <p style="color: red;">No se encontró el archivo PDF para este libro.</p>
  <?php endif; ?>
</section>
</main>

<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>
