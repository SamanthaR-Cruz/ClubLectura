<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

if (!isset($_GET["idEvento"])) {
    echo "Evento no especificado.";
    exit;
}

$idEvento = intval($_GET["idEvento"]);
$idUsuario = $_SESSION["usuario"];

include_once("modelo/Evento.php");
$evento = Evento::obtenerPorId($idEvento);
$yaAgregado = Evento::verificarInscripcion($idEvento, $idUsuario);

if (!$evento) {
    echo "<p>Evento no encontrado.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idEventoAgregar"])) {
    Evento::inscribirUsuario($idEvento, $idUsuario);
    header("Location: verEvento.php?idEvento=$idEvento");
    exit;
}

include("vista/verEventoVista.php");
