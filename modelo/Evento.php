<?php
include_once("AccesoDatos.php");

class Evento {
    private $id;
    private $nombre;
    private $fecha;
    private $descripcion;
    private $lugar;

    // Constructor
    public function __construct($id = 0, $nombre = "", $fecha = "", $descripcion = "", $lugar = "") {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->descripcion = $descripcion;
        $this->lugar = $lugar;
    }

    // Obtener todos los eventos
    public static function obtenerTodos() {
        $oAD = new AccesoDatos();
        $eventos = [];

        if ($oAD->conectar()) {
            $res = $oAD->ejecutarConsulta("SELECT idEvento, nombreEvento, fechaEvento, descripcionEvento, lugarEvento FROM eventos ORDER BY fechaEvento");
            $oAD->desconectar();

            foreach ($res as $r) {
                $eventos[] = new Evento($r[0], $r[1], $r[2], $r[3], $r[4]);
            }
        }

        return $eventos;
    }

    // Eliminar evento y sus relaciones
    public static function eliminarTotal($idEvento) {
        $oAD = new AccesoDatos();

        if ($oAD->conectar()) {
            $oAD->ejecutarComando("DELETE FROM eventosusuario WHERE idEvento = $idEvento");
            $oAD->ejecutarComando("DELETE FROM eventos WHERE idEvento = $idEvento");
            $oAD->desconectar();
            return true;
        }

        return false;
    }

    // Agregar un nuevo evento
    public static function agregar($nombre, $fecha, $lugar, $descripcion, $idUsuario) {
        $oAD = new AccesoDatos();
        $idEvento = null;

        if ($oAD->conectar()) {
            $pdo = $oAD->getConexion();
            $stmt = $pdo->prepare("INSERT INTO eventos (nombreEvento, fechaEvento, descripcionEvento, lugarEvento, idUsuario)
                                   VALUES (:nombre, :fecha, :descripcion, :lugar, :idUsuario)");
            $stmt->execute([
                ":nombre" => $nombre,
                ":fecha" => $fecha,
                ":descripcion" => $descripcion,
                ":lugar" => $lugar,
                ":idUsuario" => $idUsuario
            ]);
            $idEvento = $pdo->lastInsertId();
            $oAD->desconectar();
        }

        return $idEvento;
    }

    // Obtener evento por ID (para verEvento.php)
    public function obtenerEventoPorId($idEvento) {
        $oAD = new AccesoDatos();
        $evento = null;

        if ($oAD->conectar()) {
            $sql = "SELECT nombreEvento, fechaEvento, descripcionEvento, lugarEvento 
                    FROM eventos WHERE idEvento = $idEvento";
            $res = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($res && count($res) > 0) {
                $evento = $res[0];
            }
        }

        return $evento;
    }

    // Verificar si el usuario ya está registrado en el evento
    public function usuarioYaRegistrado($idEvento, $idUsuario) {
        $oAD = new AccesoDatos();
        $yaRegistrado = false;

        if ($oAD->conectar()) {
            $sql = "SELECT 1 FROM eventosusuario WHERE idUsuario = $idUsuario AND idEvento = $idEvento";
            $res = $oAD->ejecutarConsulta($sql);
            $yaRegistrado = ($res != null);
            $oAD->desconectar();
        }

        return $yaRegistrado;
    }

    // Registrar usuario en el evento (si no está registrado)
    public function registrarUsuarioEnEvento($idEvento, $idUsuario) {
        $oAD = new AccesoDatos();

        if ($oAD->conectar()) {
            $sql = "INSERT INTO eventosusuario (idUsuario, idEvento)
                    SELECT $idUsuario, $idEvento
                    WHERE NOT EXISTS (
                        SELECT 1 FROM eventosusuario WHERE idUsuario = $idUsuario AND idEvento = $idEvento
                    )";
            $oAD->ejecutarComando($sql);
            $oAD->desconectar();
        }
    }

    public static function obtenerPorId($idEvento) {
    $oAD = new AccesoDatos();
    if ($oAD->conectar()) {
        $res = $oAD->ejecutarConsulta("SELECT idEvento, nombreEvento, fechaEvento, descripcionEvento, lugarEvento FROM eventos WHERE idEvento = $idEvento");
        $oAD->desconectar();
        if ($res && count($res) > 0) {
            $r = $res[0];
            return new Evento($r[0], $r[1], $r[2], $r[3], $r[4]);
        }
    }
    return null;
}

public static function verificarInscripcion($idEvento, $idUsuario) {
    $oAD = new AccesoDatos();
    if ($oAD->conectar()) {
        $res = $oAD->ejecutarConsulta("SELECT 1 FROM eventosusuario WHERE idEvento = $idEvento AND idUsuario = $idUsuario");
        $oAD->desconectar();
        return ($res != null);
    }
    return false;
}

public static function inscribirUsuario($idEvento, $idUsuario) {
    $oAD = new AccesoDatos();
    if ($oAD->conectar()) {
        $oAD->ejecutarComando("INSERT IGNORE INTO eventosusuario (idEvento, idUsuario) VALUES ($idEvento, $idUsuario)");
        $oAD->desconectar();
    }
}


    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getFecha() { return $this->fecha; }
    public function getDescripcion() { return $this->descripcion; }
    public function getLugar() { return $this->lugar; }
}
?>
