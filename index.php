<?php
include_once("cabecera.html");
include_once("menu.php");
include_once("modelo/EventosIndex.php");

$imagenesEventos = [];
$idsEventos = EventosIndex::obtenerIdsEventosProximos(3);

foreach ($idsEventos as $id) {
    $ruta = "img-eventos/$id.jpeg";
    $imagenesEventos[] = file_exists($ruta) ? $ruta : "img-eventos/placeholder.jpeg";
}

while (count($imagenesEventos) < 3) {
    $imagenesEventos[] = "img-eventos/placeholder.jpeg";
}
?>
