<?php
include_once("AccesoDatos.php");

class Libro {
    private $id = 0;
    private $titulo = "";
    private $autor = "";
    private $genero = "";
    private $numPag = 0;
    private $descripcion = "";

    // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function getGenero() { return $this->genero; }
    public function getNumPag() { return $this->numPag; }
    public function getDescripcion() { return $this->descripcion; }

    // Setters
    public function setId($v) { $this->id = intval($v); }
    public function setTitulo($v) { $this->titulo = trim($v); }
    public function setAutor($v) { $this->autor = trim($v); }
    public function setGenero($v) { $this->genero = trim($v); }
    public function setNumPag($v) { $this->numPag = intval($v); }
    public function setDescripcion($v) { $this->descripcion = trim($v); }

    // Buscar todos los libros
    public function buscarTodos() {
        $arrLibros = [];
        $oAD = new AccesoDatos();

        if ($oAD->conectar()) {
            $sql = "SELECT idLibro, titulo, autor, genero, numPag, descripcionLibro FROM libros";
            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS != null) {
                foreach ($arrRS as $fila) {
                    $libro = new Libro();
                    $libro->setId($fila[0]);
                    $libro->setTitulo($fila[1]);
                    $libro->setAutor($fila[2]);
                    $libro->setGenero($fila[3]);
                    $libro->setNumPag($fila[4]);
                    $libro->setDescripcion($fila[5]);
                    $arrLibros[] = $libro;
                }
            }
        }
        return $arrLibros;
    }

    // Buscar libro por ID
    public function buscarPorId($id) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $sql = "SELECT idLibro, titulo, autor, genero, numPag, descripcionLibro 
                    FROM libros WHERE idLibro = " . intval($id);
            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS != null && count($arrRS) > 0) {
                $this->setId($arrRS[0][0]);
                $this->setTitulo($arrRS[0][1]);
                $this->setAutor($arrRS[0][2]);
                $this->setGenero($arrRS[0][3]);
                $this->setNumPag($arrRS[0][4]);
                $this->setDescripcion($arrRS[0][5]);
                return true;
            }
        }
        return false;
    }

    // Eliminar libro por ID
    public function eliminar($id) {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            $sql = "DELETE FROM libros WHERE idLibro = " . intval($id);
            $n = $oAD->ejecutarComando($sql);
            $oAD->desconectar();
            return $n > 0;
        }
        return false;
    }

    // Guardar libro (insertar o actualizar)
    public function guardar() {
        $oAD = new AccesoDatos();
        if ($oAD->conectar()) {
            if ($this->id > 0) {
                $sql = "UPDATE libros SET 
                            titulo = '" . addslashes($this->titulo) . "',
                            autor = '" . addslashes($this->autor) . "',
                            genero = '" . addslashes($this->genero) . "',
                            numPag = " . intval($this->numPag) . ",
                            descripcionLibro = '" . addslashes($this->descripcion) . "'
                        WHERE idLibro = " . $this->id;
            } else {
                $sql = "INSERT INTO libros (titulo, autor, genero, numPag, descripcionLibro)
                        VALUES (
                            '" . addslashes($this->titulo) . "',
                            '" . addslashes($this->autor) . "',
                            '" . addslashes($this->genero) . "',
                            " . intval($this->numPag) . ",
                            '" . addslashes($this->descripcion) . "'
                        )";
            }

            $n = $oAD->ejecutarComando($sql);
            $oAD->desconectar();
            return $n > 0;
        }
        return false;
    }

    public function guardarYObtenerId() {
        $oAD = new AccesoDatos();
        $idNuevo = null;

        if ($oAD->conectar()) {
            $pdo = $oAD->getConexion();
            $sql = "INSERT INTO libros (titulo, autor, genero, numPag, descripcionLibro)
                    VALUES ('" . addslashes($this->titulo) . "', '" . addslashes($this->autor) . "', '" . addslashes($this->genero) . "', " . intval($this->numPag) . ", '" . addslashes($this->descripcion) . "')";
            $resultado = $pdo->exec($sql);

            if ($resultado > 0) {
                $idNuevo = $pdo->lastInsertId();
            }

            $oAD->desconectar();
        }

        return $idNuevo;
    }

    public function buscarPorTituloAutor($texto) {
        $arrLibros = [];
        $oAD = new AccesoDatos();

        $texto = addslashes($texto);

        if ($oAD->conectar()) {
            $sql = "SELECT idLibro, titulo, autor, genero, numPag, descripcionLibro 
                    FROM libros
                    WHERE titulo LIKE '%$texto%' OR autor LIKE '%$texto%'";

            $arrRS = $oAD->ejecutarConsulta($sql);
            $oAD->desconectar();

            if ($arrRS != null) {
                foreach ($arrRS as $fila) {
                    $libro = new Libro();
                    $libro->setId($fila[0]);
                    $libro->setTitulo($fila[1]);
                    $libro->setAutor($fila[2]);
                    $libro->setGenero($fila[3]);
                    $libro->setNumPag($fila[4]);
                    $libro->setDescripcion($fila[5]);
                    $arrLibros[] = $libro;
                }
            }
        }

        return $arrLibros;
    }
}
?>
