<?php

require_once "bd.php";
class BibliotecaLibros
{
    private $db;
    private $id;
    private $idbiblioteca;
    private $idlibro;
    private $listaLibros;
    private $nombre;

    function __construct()
    {
        try {
            $bd = new bd();
            $this->db = $bd->conectarBD();
        } catch (PDOException $e) {
            echo "Error al conectar con la base de datos: " . $e->getMessage();
            die();
        }
    }
    


    private function obtenerRegistrosLibros($filtro = null, $orden = null)
    {
        if ($filtro && $orden) {
            $querySelect = "SELECT * FROM libros ORDER BY $filtro $orden";
        } else {
            $querySelect = "SELECT * FROM libros";
        }

        $listaLibros = $this->db->prepare($querySelect);
        $listaLibros->execute();

        return $listaLibros->fetchAll(PDO::FETCH_CLASS, "Libro");
    }

    function insertarNombreLibro()
{
    try {
        // código para insertar el libro en la biblioteca
        $queryInsert = "INSERT INTO biblioteca_libros (idbiblioteca, idlibro) VALUES (:idbiblioteca, :idlibro)";
        $stmtInsert = $this->db->prepare($queryInsert);
        $stmtInsert->bindParam(":idbiblioteca", $this->idbiblioteca);
        $stmtInsert->bindParam(":idlibro", $this->idlibro);
        $stmtInsert->execute();

        // Obtener el número de libros ingresados en la biblioteca
        $numeroLibros = $this->obtenerNumeroLibros();
        // Actualizar el número de libros ingresados en la biblioteca
        $this->actualizarNumeroLibros();
        
        // Devolver el número de libros ingresados en la biblioteca
        return $numeroLibros;
    } catch (Exception $ex) {
        // código para manejar errores
    }
}

    

    function obtenerBiblioteca()
    {
        try {
            $querySelect = "SELECT * FROM biblioteca_libros WHERE id= :id";
            
            $instanciaDB = $this->db->prepare($querySelect);

            $instanciaDB->bindParam(":id", $this->id);

            $instanciaDB->execute();

            if ($instanciaDB) {
                return $instanciaDB->fetchAll(PDO::FETCH_CLASS, "librosBiblioteca")[0];
            } else {
                echo "Ocurrió un error inesperado al recuperar la Biblioteca seleccionada";
            }
        } catch (Exception $ex) {
            echo "Ocurrió un error: " . $ex->getMessage();
            return null;
        }
    }
    public function actualizarNumeroLibros() {
        $idBiblioteca = $_POST['idbiblioteca'];
        $consulta = $this->db->prepare("UPDATE biblioteca_libros SET numerolibros = (SELECT COUNT(*) FROM biblioteca_libros WHERE idbiblioteca = :id) WHERE idbiblioteca = :id");
        $consulta->bindParam(':id', $idBiblioteca);
        $consulta->execute();
        return $consulta->rowCount();
    }

	/**
	 * @return mixed
	 */
	public function getIdbiblioteca() {
		return $this->idbiblioteca;
	}
	
	/**
	 * @param mixed $idbiblioteca 
	 * @return self
	 */
	public function setIdbiblioteca($idbiblioteca): self {
		$this->idbiblioteca = $idbiblioteca;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIdlibro() {
		return $this->idlibro;
	}
	
	/**
	 * @param mixed $idlibro 
	 * @return self
	 */
	public function setIdlibro($idlibro): self {
		$this->idlibro = $idlibro;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getNombre() {
		return $this->nombre;
	}
	
	/**
	 * @param mixed $nombre 
	 * @return self
	 */
	public function setNombre($nombre): self {
		$this->nombre = $nombre;
		return $this;
	}
}