<?php
include_once("AccesoDatos.php");

class Usuario {
	private $id = 0;
	private $numcon = "";
	private $nombre = "";
	private $correo = "";
	private $contrasena = "";
	private $rol = "";
	private $oAD = null;

	// Getters
	public function getId() { return $this->id; }
	public function getNumCon() { return $this->numcon; }
	public function getNombre() { return $this->nombre; }
	public function getCorreo() { return $this->correo; }
	public function getContrasena() { return $this->contrasena; }
	public function getRol() { return $this->rol; }

	// Setters
	public function setId($valor) { $this->id = intval($valor); }
	public function setNumCon($valor) { $this->numcon = trim($valor); }
	public function setNombre($valor) { $this->nombre = trim($valor); }
	public function setCorreo($valor) { $this->correo = trim($valor); }
	public function setContrasena($valor) { $this->contrasena = trim($valor); }
	public function setRol($valor) { $this->rol = intval($valor); }

	// Validación de login
	public function validarLogin() {
		if ($this->numcon == "" || $this->contrasena == "") {
			throw new Exception("Usuario->validarLogin: faltan datos");
		}

		$sQuery = "SELECT idUsuario, nombreCompleto, rol 
				   FROM usuarios 
				   WHERE numeroControl = '" . $this->numcon . "' 
				   AND contrasena = '" . $this->contrasena . "'";

		$this->oAD = new AccesoDatos();
		if ($this->oAD->conectar()) {
			$arrRS = $this->oAD->ejecutarConsulta($sQuery);
			$this->oAD->desconectar();

			if ($arrRS != null && count($arrRS) > 0) {
				$this->id = $arrRS[0][0];
				$this->nombre = $arrRS[0][1];
				$this->rol = $arrRS[0][2];
				return true;
			}
		}
		return false;
	}

	// Registro de usuario nuevo
	public function agregar() {
		if ($this->numcon == "" || $this->contrasena == "" || $this->nombre == "" || $this->correo == "") {
			throw new Exception("Usuario->agregar: faltan datos");
		}

		$sQuery = "INSERT INTO usuarios (numeroControl, contrasena, nombreCompleto, correo, rol) 
				   VALUES (
					   '" . $this->numcon . "',
					   '" . $this->contrasena . "',
					   '" . $this->nombre . "',
					   '" . $this->correo . "',
					   " . intval($this->rol) . "
				   )";

		$this->oAD = new AccesoDatos();
		if ($this->oAD->conectar()) {
			$bRet = $this->oAD->ejecutarComando($sQuery);
			$this->oAD->desconectar();
			return $bRet;
		}

		return false;
	}

	// Obtener todos los usuarios con o sin filtro
	public function obtenerTodos($filtro = "") {
		$usuarios = [];
		$this->oAD = new AccesoDatos();

		if ($this->oAD->conectar()) {
			$sql = "SELECT idUsuario, numeroControl, nombreCompleto, correo, rol FROM usuarios";

			if ($filtro !== "") {
				$filtro = addslashes($filtro);
				$sql .= " WHERE nombreCompleto LIKE '%$filtro%' OR numeroControl LIKE '%$filtro%'";
			}

			$sql .= " ORDER BY nombreCompleto ASC";

			$usuarios = $this->oAD->ejecutarConsulta($sql);
			$this->oAD->desconectar();
		}

		return $usuarios;
	}
	
public function cargarPorId($id) {
    $oAD = new AccesoDatos();
    if ($oAD->conectar()) {
        $res = $oAD->ejecutarConsulta("SELECT idUsuario, numeroControl, nombreCompleto, correo, contrasena, rol FROM usuarios WHERE idUsuario = $id");
        $oAD->desconectar();
        if ($res && count($res) > 0) {
            $this->setId($res[0][0]);
            $this->setNumCon($res[0][1]);
            $this->setNombre($res[0][2]);
            $this->setCorreo($res[0][3]);
            $this->setContrasena($res[0][4]);
            $this->setRol($res[0][5]);
            return true;
        }
    }
    return false;
}

public function actualizar() {
	if ($this->id <= 0 || $this->nombre == "" || $this->correo == "") {
		throw new Exception("Usuario->actualizar: faltan datos o ID inválido");
	}

	$sql = "UPDATE usuarios SET 
				nombreCompleto = '" . $this->nombre . "',
				correo = '" . $this->correo . "',
				rol = " . intval($this->rol);

	if ($this->contrasena !== "") {
		$sql .= ", contrasena = '" . $this->contrasena . "'";
	}

	$sql .= " WHERE idUsuario = " . intval($this->id);

	$this->oAD = new AccesoDatos();
	if ($this->oAD->conectar()) {
		$resultado = $this->oAD->ejecutarComando($sql);
		$this->oAD->desconectar();
		return $resultado > 0;
	}
	return false;
}

	// Eliminar un usuario por ID
	public function eliminar($idUsuario) {
		$this->oAD = new AccesoDatos();
		if ($this->oAD->conectar()) {
			$idUsuario = intval($idUsuario);
			$sql = "DELETE FROM usuarios WHERE idUsuario = $idUsuario";
			$resultado = $this->oAD->ejecutarComando($sql);
			$this->oAD->desconectar();
			return $resultado > 0;
		}
		return false;
	}
}
?>
