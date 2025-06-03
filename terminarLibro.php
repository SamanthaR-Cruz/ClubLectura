<?php
// Archivo:  terminarLibro.php
// Objetivo: Controlador que marca un libro como terminado
// Autor:

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

if (isset($_POST["idLibro"])) {
    include_once("modelo/LibroCliente.php");

    $idLibro = intval($_POST["idLibro"]);
    $idUsuario = $_SESSION["usuario"];

    $oLC = new LibroCliente();
    $oLC->marcarComoTerminado($idLibro, $idUsuario);
}

header("Location: mybooks.php");
exit;
