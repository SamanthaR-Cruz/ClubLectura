<?php
include_once("AccesoDatos.php");
include_once("Libro.php");

class LibroCliente {
    private $id = 0;
    private $fechaInicio = "";
    private $idLibro = 0;
    private $idUsuario = 0;

    public function getId() { return $this->id; }
    public function getFechaInicio() { return $this->fechaInicio; }
    public function getIdLibro() { return $this->idLibro; }
    public function getIdUsuario() { return $this->idUsuario; }

    public function setId($v) { $this->id = intval($v); }
    public function setFechaInicio($v) { $this->fechaInicio = $v; }
    public function setIdLibro($v) { $this->idLibro = intval($v); }
    public function setIdUsuario($v) { $this->idUsuario = intval($v); }

    public function obtenerLibrosPorUsuario($idUsuario) {
        $arrLibros = [];
        $oAD = new AccesoDatos();

        if ($oAD->conectar()) {
            $sql = "SELECT l.idLibro, l.titulo, l.autor, l.genero, l.numPag, l.descripcionLibro, lu.fechainicio
                    FROM librousuario lu
                    JOIN libros l ON lu.idLibro = l.idLibro
                    WHERE lu.idUsuario = " . intval($idUsuario) . "
                    ORDER BY lu.fechainicio DESC";

            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS != null) {
                foreach ($arrRS as $fila) {
                    $arrLibros[] = [
                        'idLibro' => $fila[0],
                        'titulo' => $fila[1],
                        'autor' => $fila[2],
                        'genero' => $fila[3],
                        'numPag' => $fila[4],
                        'descripcion' => $fila[5],
                        'fechaInicio' => $fila[6]
                    ];
                }
            }
        }
        return $arrLibros;
    }

    public function obtenerLibrosEnCurso($idUsuario) {
        return $this->obtenerLibrosPorEstado($idUsuario, false);
    }

    public function obtenerLibrosTerminados($idUsuario) {
        return $this->obtenerLibrosPorEstado($idUsuario, true);
    }

    private function obtenerLibrosPorEstado($idUsuario, $terminado) {
        $arrLibros = [];
        $oAD = new AccesoDatos();

        if ($oAD->conectar()) {
            $sql = "SELECT l.idLibro, l.titulo, l.autor, l.genero, l.numPag, l.descripcionLibro, lu.fechainicio, lu.fechaTermino
                    FROM librousuario lu
                    JOIN libros l ON lu.idLibro = l.idLibro
                    WHERE lu.idUsuario = " . intval($idUsuario);

            $sql .= $terminado ? " AND lu.fechaTermino IS NOT NULL" : " AND lu.fechaTermino IS NULL";
            $sql .= " ORDER BY lu.fechainicio DESC";

            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS != null) {
                foreach ($arrRS as $fila) {
                    $arrLibros[] = [
                        'idLibro' => $fila[0],
                        'titulo' => $fila[1],
                        'autor' => $fila[2],
                        'genero' => $fila[3],
                        'numPag' => $fila[4],
                        'descripcion' => $fila[5],
                        'fechaInicio' => $fila[6],
                        'fechaFin' => $fila[7]
                    ];
                }
            }
        }

        return $arrLibros;
    }

    public function eliminarLibroUsuario($idLibro, $idUsuario) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $sql = "DELETE FROM librousuario 
                    WHERE idLibro = $idLibro AND idUsuario = $idUsuario";
            $oAD->ejecutarComando($sql);
            $oAD->desconectar();
            return true;
        }
        return false;
    }

    public function marcarLibroComoTerminado($idLibro, $idUsuario) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $fechaFin = date("Y-m-d");
            $sql = "UPDATE librousuario
                    SET fechaTermino = '$fechaFin' 
                    WHERE idLibro = $idLibro AND idUsuario = $idUsuario";
            $resultado = $oAD->ejecutarComando($sql);
            $oAD->desconectar();
            return $resultado > 0;
        }
        return false;
    }

    // NUEVOS MÉTODOS para usar en agregarLibroUsuario.php

    public function yaAgregado($idLibro, $idUsuario) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $sql = "SELECT 1 FROM librousuario WHERE idLibro = $idLibro AND idUsuario = $idUsuario";
            $resultado = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();
            return $resultado != null;
        }
        return false;
    }

    public function agregarLibroUsuario($idLibro, $idUsuario) {
        if (!$this->yaAgregado($idLibro, $idUsuario)) {
            $fecha = date("Y-m-d");
            $oAD = new AccesoDatos();
            if ($oAD->conectar()) {
                $sql = "INSERT INTO librousuario (fechainicio, idLibro, idUsuario)
                        VALUES ('$fecha', $idLibro, $idUsuario)";
                $oAD->ejecutarComando($sql);
                $oAD->desconectar();
                return true;
            }
        }
        return false;
    }

    
public function marcarComoTerminado($idLibro, $idUsuario) {
    $oAD = new AccesoDatos();
    $res = false;
    if ($oAD->conectar()) {
        $fechaFin = date("Y-m-d");
        $sql = "UPDATE librousuario 
                SET fechaTermino = '$fechaFin' 
                WHERE idLibro = $idLibro AND idUsuario = $idUsuario";
        $res = $oAD->ejecutarComando($sql);
        $oAD->desconectar();
    }
    return $res;
}

}
?>
