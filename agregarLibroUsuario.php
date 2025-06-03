<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

include_once("modelo/LibroCliente.php");

if (isset($_POST["idLibro"])) {
    $idLibro = intval($_POST["idLibro"]);
    $idUsuario = $_SESSION["usuario"];

    $libroCliente = new LibroCliente();
    $libroCliente->agregarLibroUsuario($idLibro, $idUsuario);
}

header("Location: mybooks.php");
exit;
