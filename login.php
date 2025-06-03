<?php
session_start();
include_once("modelo/Login.php");

try {
    if (!empty($_POST["txtNumCon"]) && !empty($_POST["txtContrasena"])) {
        $numCon = $_POST["txtNumCon"];
        $contrasena = $_POST["txtContrasena"];

        if (Login::autenticar($numCon, $contrasena)) {
            header("Location: mybooks.php");
            exit();
        }
    } else {
        throw new Exception("Faltan datos");
    }
} catch (Exception $e) {
    error_log($e->getMessage(), 0);
    $_SESSION["mensaje_error"] = $e->getMessage();
    header("Location: sesion.php");
    exit();
}
