<?php 
/**
 * *CONTROLADOR LINEA FACTURA*
 * 
 * @author Andrés Pérez Guardiola
 */

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

require_once("model/lineafactura.modelo.php");
require_once("model/factura.modelo.php");

abstract class LineaFacturaControlador
{
    public static function index(): void
    {
        $lineasFacturaObject = new LineaFacturaModelo();
        $lineasFacturaObject->setFacturaId((int) $_GET['factura_id']);
        $lineasFacturaObject->seleccionar();

        $lineasFactura = $lineasFacturaObject->filas;

        require_once("view/lineafactura/lineafactura.index.php");
    }

    public static function nuevo() : void
    {
        $facturaObject = new FacturaModelo();

        if (! isset($_GET['factura_id']))
        {
            FacturaControlador::error("ERROR: No se ha recibido identificador de Factura");
        }

        $facturaObject->setId((int) $_GET['factura_id']);


        if ($facturaObject->seleccionar())
        {
            $facturas = $facturaObject->filas;

            require_once("view/lineafactura/lineafactura.nuevo.php");
        }
        else
        {
            FacturaControlador::error("ERROR: No se pueden obtener los clientes");
        }
    }

    public static function insertar(): void
    {
        if (! isset($_GET['factura_id']))
        {
            FacturaControlador::error("ERROR: No se ha recibido identificador de Factura");
        }

        
        $factura = new FacturaModelo();
        $factura->setId((int) $_GET['factura_id']);
        $factura->seleccionar();

        // verifica que factura_id está en la base de datos
        if (empty($factura->filas) || $factura->filas == [])
        {
            LineaFacturaControlador::error("ERROR: No se puede insertar la linea factura porque la factura no existe");
        }

        $lineaFactura = new LineaFacturaModelo();

        LineaFacturaControlador::validarYAsignar($lineaFactura, true);

        if ($lineaFactura->insertar() == 1)
        {
            header("location: " . URLSITE . "index.php?c=linea_factura&factura_id=" . $_GET['factura_id']);
            die();
        }
        else
        {
            LineaFacturaControlador::error($lineaFactura->getError());
        } 
    }

    public static function borrar(): void
    {
        $lineafactura = new LineaFacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El ID de Línea Factura no puede ser NULL o Undefined");
        }

        if (! isset($_GET['factura_id']))
        {
            FacturaControlador::error("El ID de Factura no puede ser NULL o Undefined");
        }

        $lineafactura->setId((int) $_GET['id']);

        if( $lineafactura->borrar() != 0 )
        {
            header("location: " . URLSITE . "index.php?c=linea_factura&factura_id=" . $_GET['factura_id']);
            die();
        }
        else
        {
            FacturaControlador::error($lineafactura->getError());
        }
    }


    public static function editar() : void
    {
        $lineafactura = new LineaFacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El ID de Línea Factura no puede ser NULL o Undefined");
        }

        $lineafactura->setId((int) $_GET['id']);

        if ($lineafactura->seleccionar())
        {
            require_once("view/lineafactura/lineafactura.editar.php");
        }
        else
        {
            FacturaControlador::error("No se encontró la linea factura con dicho id");
        }   
    }

    public static function modificar() : void
    {
        $lineafactura = new LineaFacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El ID de Línea Factura no puede ser NULL o Undefined");
        }

        $lineafactura->setId((int) $_GET['id']);

        if (! $lineafactura->seleccionar())
        {
            FacturaControlador::error("No se encontró la línea factura con dicho Id");
        }

        LineaFacturaControlador::validarYAsignar($lineafactura);

        if ( ($lineafactura->modificar() == 1) || $lineafactura->getError() == null)
        {
            header("location: " . URLSITE . "index.php?c=linea_factura&factura_id=" . $_GET['factura_id']);
        }
        else
        {
            LineaFacturaControlador::error($lineafactura->getError());
        }
    }


    /**
     * Realiza la validación y asigna los valores a un objeto pasado por referencia
     * 
     * @param LineaFacturaModelo $factura Objecto factura por referencia
     * @return void
     */
    public static function validarYAsignar(LineaFacturaModelo &$lineafactura, bool $insertar = false) : void
    {
        try
        {
            $lineafactura->setFacturaId((int) $_GET['factura_id']);

            if ($insertar == true)
            {
                $referencia = $lineafactura->seleccionaUltimaReferencia();

                $lineafactura->setReferencia( $referencia + 1);
            }
           
            $lineafactura->setDescripcion($_POST['descripcion']);
            $lineafactura->setCantidad((float) $_POST['cantidad']);
            $lineafactura->setPrecio((float) $_POST['precio']);
            $lineafactura->setIva((float) $_POST['iva']);
        }
        catch (Exception $e)
        {
            LineaFacturaControlador::error($e->getMessage());
        }
    }


    public static function error(string $mensaje): void
    {
        $_SESSION['CRUDMVC_ERROR'] = $mensaje;

        header("location: " . URLSITE . "view/error.php");
        die();
    }
}