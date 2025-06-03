<?php
include_once("AccesoDatos.php");

class EventosUsuario {
    public static function obtenerMisEventos($idUsuario) {
        $oAD = new AccesoDatos();
        $eventos = [];
        if ($oAD->conectar()) {
            $sql = "SELECT e.idEvento, e.nombreEvento, e.fechaEvento, e.descripcionEvento, e.lugarEvento
                    FROM eventos e
                    INNER JOIN eventosusuario eu ON e.idEvento = eu.idEvento
                    WHERE eu.idUsuario = $idUsuario";
            $res = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            foreach ($res as $r) {
                $eventos[] = new Evento($r[0], $r[1], $r[2], $r[3], $r[4]);
            }
        }
        return $eventos;
    }

    public static function agregarEvento($idUsuario, $idEvento) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $oAD->ejecutarComando("INSERT IGNORE INTO eventosusuario (idUsuario, idEvento) VALUES ($idUsuario, $idEvento)");
            $oAD->desconectar();
            return true;
        }
        return false;
    }

    public static function eliminarEvento($idUsuario, $idEvento) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $oAD->ejecutarComando("DELETE FROM eventosusuario WHERE idUsuario = $idUsuario AND idEvento = $idEvento");
            $oAD->desconectar();
            return true;
        }
        return false;
    }
}
