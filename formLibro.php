<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] != 1) {
    header("Location: sesion.php"); // corregido 'sesio.php'
    exit;
}

include_once("cabecera.html");
include_once("menu.php");
?>

<section class="books-section">
  <h1>Agregar nuevo libro</h1>
  <p>Llena el siguiente formulario para registrar un nuevo libro en la biblioteca</p>

  <form method="post" action="formLibro.php" enctype="multipart/form-data" class="formulario-libro">
    <div class="campo-form">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" required>
    </div>

    <div class="campo-form">
      <label for="autor">Autor:</label>
      <input type="text" name="autor" id="autor" required>
    </div>

    <div class="campo-form">
      <label for="genero">Género:</label>
      <input type="text" name="genero" id="genero" required>
    </div>

    <div class="campo-form">
      <label for="numPag">Número de páginas:</label>
      <input type="number" name="numPag" id="numPag" required>
    </div>

    <div class="campo-form">
      <label for="descripcion">Descripción:</label>
      <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
    </div>

    <div class="campo-form">
      <label for="archivo">Archivo PDF:</label>
      <input type="file" name="archivo" id="archivo" accept="application/pdf" required>
    </div>

    <div class="boton-formulario">
      <button type="submit" name="agregarLibro" class="btn-agregar-libro">Registrar libro</button>
    </div>
  </form>
</section>
</main>

<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>

<?php
include_once("modelo/Libro.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregarLibro"])) {
    $titulo = trim($_POST["titulo"]);
    $autor = trim($_POST["autor"]);
    $genero = trim($_POST["genero"]);
    $numPag = intval($_POST["numPag"]);
    $descripcion = trim($_POST["descripcion"]);
    $archivo = $_FILES["archivo"];

    // Validar tipo de archivo
    $tipoArchivo = mime_content_type($archivo["tmp_name"]);
    if ($tipoArchivo != "application/pdf") {
        echo "<script>
                const mensaje = 'El archivo debe ser un PDF.';
                const redireccion = 'formLibro.php';
              </script>
              <script src='js/script-mensaje.js'></script>";
        exit;
    }

    // Crear libro
    $libro = new Libro();
    $libro->setTitulo($titulo);
    $libro->setAutor($autor);
    $libro->setGenero($genero);
    $libro->setNumPag($numPag);
    $libro->setDescripcion($descripcion);

    // Guardar y obtener ID
    $idLibro = $libro->guardarYObtenerId();

    if ($idLibro !== null && $idLibro > 0) {
        $nombreArchivo = $idLibro . ".pdf";
        $rutaArchivo = "pdfs/" . $nombreArchivo;

        if (!is_dir("pdfs")) {
            mkdir("pdfs", 0755, true);
        }

        if (move_uploaded_file($archivo["tmp_name"], $rutaArchivo)) {
            echo "<script>
                    const mensaje = 'Libro agregado exitosamente.';
                    const redireccion = 'agregarLibro.php';
                  </script>
                  <script src='js/script-mensaje.js'></script>";
        } else {
            echo "<script>
                    const mensaje = 'Libro registrado, pero el archivo no se pudo guardar.';
                    const redireccion = 'formLibro.php';
                  </script>
                  <script src='js/script-mensaje.js'></script>";
        }
    } else {
        echo "<script>
                const mensaje = 'Error al registrar el libro.';
                const redireccion = 'formLibro.php';
              </script>
              <script src='js/script-mensaje.js'></script>";
    }
}
?>
