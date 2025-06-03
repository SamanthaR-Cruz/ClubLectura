<?php
include_once("AccesoDatos.php");

class EventosIndex {
    public static function obtenerIdsEventosProximos($limite = 3) {
        $oAD = new AccesoDatos();
        $ids = [];

        if ($oAD->conectar()) {
            $sql = "SELECT idEvento FROM eventos WHERE fechaEvento >= CURDATE() ORDER BY fechaEvento ASC LIMIT " . intval($limite);
            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS !== null) {
                foreach ($arrRS as $fila) {
                    $ids[] = $fila[0];
                }
            }
        }

        return $ids;
    }
}
?>
