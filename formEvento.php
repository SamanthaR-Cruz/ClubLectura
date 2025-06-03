<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] != 1) {
    header("Location: sesion.php");
    exit;
}

require_once("modelo/Evento.php");

// Controlador
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["agregarEvento"])) {
    $idUsuario = $_SESSION["usuario"];
    $nombreEvento = trim($_POST["nombreEvento"]);
    $fechaEvento = $_POST["fechaEvento"];
    $lugarEvento = trim($_POST["lugarEvento"]);
    $descripcion = trim($_POST["descripcionEvento"]);

    $evento = new Evento();
    $idEvento = $evento->agregar($nombreEvento, $fechaEvento, $lugarEvento, $descripcion, $idUsuario);

    if ($idEvento) {
        // Guardar imagen
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
            $nombreImagen = $idEvento . ".jpeg";
            $rutaDestino = "img-eventos/" . $nombreImagen;

            if (!is_dir("img-eventos")) {
                mkdir("img-eventos", 0755, true);
            }

            move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);
        }

        echo "<script>
                const mensaje = 'Evento creado exitosamente.';
                const redireccion = 'eventos.php';
              </script>
              <script src='js/script-mensaje.js'></script>";
        exit;
    } else {
        echo "<script>
                const mensaje = 'Error al crear el evento.';
                const redireccion = 'formEvento.php';
              </script>
              <script src='js/script-mensaje.js'></script>";
        exit;
    }
}
?>

<?php include_once("cabecera.html"); ?>
<?php include_once("menu.php"); ?>

<section class="books-section">
  <h1>Crear nuevo evento</h1>
  <p>Llena el siguiente formulario para registrar un evento en el sistema</p>

  <form method="post" action="formEvento.php" enctype="multipart/form-data" class="formulario-libro">
    <div class="campo-form">
      <label for="nombreEvento">Nombre del evento:</label>
      <input type="text" name="nombreEvento" id="nombreEvento" required>
    </div>

    <div class="campo-form">
      <label for="fechaEvento">Fecha del evento:</label>
      <input type="date" name="fechaEvento" id="fechaEvento" required>
    </div>

    <div class="campo-form">
      <label for="lugarEvento">Lugar:</label>
      <input type="text" name="lugarEvento" id="lugarEvento" required>
    </div>

    <div class="campo-form">
      <label for="descripcionEvento">Descripción:</label>
      <textarea name="descripcionEvento" id="descripcionEvento" rows="4" required></textarea>
    </div>

    <div class="campo-form">
      <label for="imagen">Imagen del evento:</label>
      <input type="file" name="imagen" id="imagen" accept="image/*">
    </div>

    <div class="boton-formulario">
      <button type="submit" name="agregarEvento" class="btn-agregar-libro">Registrar evento</button>
    </div>
  </form>
</section>

</main>

<?php include_once("aside.php"); ?>
<?php include_once("pie.html"); ?>
