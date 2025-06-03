<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: sesion.php");
    exit;
}

include_once("modelo/Evento.php");
include_once("modelo/EventosUsuario.php");
include_once("cabecera.html");
include_once("menu.php");

$idUsuario = $_SESSION["usuario"];

$eventos = Evento::obtenerTodos();
$misEventos = EventosUsuario::obtenerMisEventos($idUsuario);
?>
