<!DOCTYPE html>
<html>
<?php
include "componentes/head.php";
require "modelo/bibliotecaLibros.php";
require "modelo/libro.php";
require "modelo/biblioteca.php";
?>

<body>
    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Añadir nuevos libros a la biblioteca:</h1>
            <?php
            if (isset($_POST['idbiblioteca']) && isset($_POST['idlibro'])) {
                $idbiblioteca = $_POST['idbiblioteca'];
                $idlibro = $_POST['idlibro'];
                $libros = new BibliotecaLibros();
                $libros->setIdlibro($idlibro);
                echo $libros->insertarNombreLibro();
            }
            ?>
            <form id="insertarBibliotecaForm" action="insertarBiblioteca.php" method="post">
                <div class="form-group">
                    <label>Id Biblioteca</label>
                    <input type="text" class="form-control" name="id">
                </div>

                <?php include "componentes/seleccionLibro.php"; ?>
    
                <input type="submit" value="Enviar">
            </form>
    
            <a href="listadobibliotecas.php" class="btn btn-primary">Crear Biblioteca</a>
            <a href="listadobibliotecas.php" class="btn btn-secondary">Volver al listado</a>
        </div>
    </div>
</body>
</html>
