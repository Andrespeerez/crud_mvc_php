<?php
/**
 * *CONTROLADOR DE ARTÍCULO*
 * 
 * *DESCRIPCIÓN*
 * Controlador de ArticuloModelo
 * Implementa las llamadas para hacer CRUD
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types = 1);


if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

require_once("model/articulo.modelo.php");

class ArticuloControlador
{
    public static function index() : void
    {
        $articuloObjeto = new ArticuloModelo();
        $articuloObjeto->seleccionar();

        $articulos = $articuloObjeto->filas;
        
        require_once("view/articulo/articulo.index.php");
    }

    public static function nuevo() : void
    {
        require_once("view/articulo/articulo.nuevo.php");
    }

    public static function insertar() : void
    {
        $articulo = new ArticuloModelo();

        ArticuloControlador::validarYAsignar($articulo, true);

        if ($articulo->insertar() == 1)
        {
            header("location: " . URLSITE . "index.php?c=articulo");
            die();
        }
        else
        {
            ArticuloControlador::error("No se puedo insertar el Artículo");
        }
    }

    public static function editar() : void
    {
        if (! isset($_GET['id']) || $_GET['id'] == null)
        {
            ArticuloControlador::error("El ID del artículo no puede ser null or undefined");
        }

        $articuloObjeto = new ArticuloModelo();
        $articuloObjeto->setId((int) $_GET['id']);

        if (! $articuloObjeto->seleccionar())
        {
            ArticuloControlador::error("No se ha encontrado el artículo deseado");
        }

        $articulo = $articuloObjeto->filas[0];
        
        require_once("view/articulo/articulo.editar.php");
    }

    public static function modificar() : void
    {
        $articulo = new ArticuloModelo();

        if (! isset($_GET['id']))
        {
            ArticuloControlador::error("El ID del artículo no puede ser null or undefined");
        }

        $articulo->setId((int) $_GET['id']);

        if(! $articulo->seleccionar())
        {
            ArticuloControlador::error("No se ha encontrado el artículo deseado");
        }

        ArticuloControlador::validarYAsignar($articulo, false);

        if ($articulo->modificar() == 1 )
        {
            header("location: " . URLSITE . "index.php?c=articulo");
            die();
        }
        else
        {
            ArticuloControlador::error($articulo->getError());
        }
    }

    public static function borrar() : void
    {
        $articulo = new ArticuloModelo();

        if (! isset($_GET['id']))
        {
            ArticuloControlador::error("El ID del artículo no puede ser null or undefined");
        }

        $articulo->setId((int) $_GET['id']);

        if ($articulo->borrar() == 1)
        {
            header("location: " . URLSITE . "index.php?c=articulo");
            die();
        }
        else
        {
            ArticuloControlador::error($articulo->getError());
        }
    }

    public static function validarYAsignar(ArticuloModelo &$articulo, bool $insertar = false) : void
    {
        try
        {
            $articulo->setReferencia($_POST['referencia']);
            $articulo->setDescripcion($_POST['descripcion']);
            $articulo->setPrecio((float) $_POST['precio']);
            $articulo->setIva((float) $_POST['iva']);
        }
        catch (Exception $e)
        {
            ArticuloControlador::error($e->getMessage());
        }
    }

    public static function error(string $mensaje): void
    {
        $_SESSION['CRUDMVC_ERROR'] = $mensaje;

        header("location: " . URLSITE . "view/error.php");
        die();
    }
}