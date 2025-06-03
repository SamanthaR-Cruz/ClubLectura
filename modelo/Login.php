<?php
include_once("modelo/Usuario.php");

class Login {
    public static function autenticar($numCon, $contrasena) {
        $oUsu = new Usuario();
        $oUsu->setNumCon($numCon);
        $oUsu->setContrasena($contrasena);

        if ($oUsu->validarLogin()) {
            $_SESSION["usuario"] = $oUsu->getId();
            $_SESSION["nombre"] = $oUsu->getNombre();
            $_SESSION["rol"] = $oUsu->getRol();
            return true;
        } else {
            throw new Exception("Número de control o contraseña incorrectos");
        }
    }
}
