<?php
error_reporting(E_ALL);

class AccesoDatos {
	private $oConexion = null;

	function conectar() {
		$bRet = false;
		try {
			$this->oConexion = new PDO(
				"mysql:host=localhost;dbname=clubdelecturacascade", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'")
			);
			$bRet = true;
		} catch (Exception $e) {
			die("Error de conexión: " . $e->getMessage());
			throw $e;
		}
		return $bRet;
	}

	function desconectar() {
		if ($this->oConexion != null) {
			$this->oConexion = null;
		}
		return true;
	}

	function ejecutarConsulta($psConsulta) {
		if ($psConsulta == "") throw new Exception("AccesoDatos->ejecutarConsulta: falta indicar la consulta");
		if ($this->oConexion == null) throw new Exception("AccesoDatos->ejecutarConsulta: falta conectar la base");

		$arrRS = [];
		$i = 0;

		try {
			$rst = $this->oConexion->query($psConsulta);
			if ($rst) {
				foreach ($rst as $oLinea) {
					$arrRS[$i] = [];
					foreach ($oLinea as $llave => $sValCol) {
						if (is_string($llave)) {
							$arrRS[$i][] = $sValCol;
						}
					}
					$i++;
				}
			}
		} catch (Exception $e) {
			throw $e;
		}
		return $arrRS;
	}

	function ejecutarComando($psComando) {
		if ($psComando == "") throw new Exception("AccesoDatos->ejecutarComando: falta indicar el comando");
		if ($this->oConexion == null) throw new Exception("AccesoDatos->ejecutarComando: falta conectar la base");

		try {
			return $this->oConexion->exec($psComando);
		} catch (Exception $e) {
			throw $e;
		}
	}

	public function getConexion() {
		return $this->oConexion;
	}
	
	
}
?>


