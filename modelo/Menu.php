<?php

class Menu {
    public static function usuarioAutenticado() {
        return isset($_SESSION["usuario"]);
    }

    public static function rolEsAdmin() {
        return isset($_SESSION["rol"]) && $_SESSION["rol"] == 1;
    }
}
