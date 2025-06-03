<?php
include_once("AccesoDatos.php");

class Comentario {
    private $oAD;

    public function __construct() {
        $this->oAD = new AccesoDatos();
    }

    public function obtenerTodos($busqueda = "") {
        $comentarios = [];

        if ($this->oAD->conectar()) {
            $sql = "SELECT c.idComentario, c.tituloComentario, c.descripcionComentario, u.nombreCompleto, u.idUsuario
                    FROM comentarios c
                    JOIN usuarios u ON c.idUsuario = u.idUsuario";

            if ($busqueda !== "") {
                $busquedaSql = addslashes($busqueda);
                $sql .= " WHERE u.nombreCompleto LIKE '%$busquedaSql%'";
            }

            $sql .= " ORDER BY c.idComentario DESC";

            $comentarios = $this->oAD->ejecutarConsulta($sql);
            $this->oAD->desconectar();
        }

        return $comentarios;
    }

    public function insertar($titulo, $descripcion, $idUsuario) {
        if ($this->oAD->conectar()) {
            $titulo = addslashes(trim($titulo));
            $descripcion = addslashes(trim($descripcion));
            $sql = "INSERT INTO comentarios (tituloComentario, descripcionComentario, idUsuario)
                    VALUES ('$titulo', '$descripcion', $idUsuario)";
            $resultado = $this->oAD->ejecutarComando($sql);
            $this->oAD->desconectar();
            return $resultado > 0;
        }
        return false;
    }

    public function eliminar($idComentario) {
        if ($this->oAD->conectar()) {
            $idComentario = intval($idComentario);
            $sql = "DELETE FROM comentarios WHERE idComentario = $idComentario";
            $resultado = $this->oAD->ejecutarComando($sql);
            $this->oAD->desconectar();
            return $resultado > 0;
        }
        return false;
    }
}
?>
