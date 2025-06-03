<?php

class LectorLibros {
    public static function obtenerRutaPDF($idLibro) {
        $id = intval($idLibro); // Sanear
        $ruta = "pdfs/" . $id . ".pdf";
        return file_exists($ruta) ? $ruta : null;
    }
}
?>
