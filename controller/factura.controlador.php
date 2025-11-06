<?php
/**
 * *CONTROLADOR DE FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Implementa todas las funciones que debe realizar la aplicación
 * para cada petición que realice el usuario
 * 
 * Emplea el modelo factura.modelo.php para la conexión con base de datos
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

require_once("model/cliente.modelo.php");
require_once("model/factura.modelo.php");

abstract class FacturaControlador
{
    public static function index(): void
    {
        $factura = new FacturaModelo();
        $factura->seleccionar();

        require_once("view/factura/factura.index.php");
    }

    public static function nuevo(): void
    {
        $clientes = new ClienteModelo();
        if ($clientes->seleccionar())
        {
            require_once("view/factura/factura.nuevo.php");
        }
        else
        {
            FacturaControlador::error("ERROR: No se pueden obtener los clientes");
        }
    }

    public static function insertar(): void
    {
        $cliente = new ClienteModelo();

        // verificar que  se recibe cliente_id 
        if (! isset($_POST['cliente_id']))
        {
            FacturaControlador::error("ERROR: No se ha recibido identificador de cliente");
        }

        $cliente->setId((int) $_POST['cliente_id']);
        $cliente->seleccionar();

        // verifica que cliente_id está en la base de datos
        if (empty($cliente->filas) || $cliente->filas == [])
        {
            FacturaControlador::error("ERROR: No se puede insertar factura porque el cliente no existe");
        }

        $factura = new FacturaModelo();

        FacturaControlador::validarYAsignar($factura, true);

        if ($factura->insertar() == 1)
        {
            header("location: " . URLSITE . "index.php?c=factura");
            die();
        }
        else
        {
            FacturaControlador::error($factura->getError());
        } 
    }

    public static function borrar(): void
    {
        $factura = new FacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El ID de Factura no puede ser NULL o undefined");
        }

        $factura->setId((int) $_GET['id']);

        if( $factura->borrar() == 1 )
        {
            header("location: " . URLSITE . "index.php?c=factura");
            die();
        }
        else
        {
            FacturaControlador::error($factura->getError());
        }
    }

    public static function editar(): void
    {
        $factura = new FacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El id de Factura no puede ser NULL o Undefined");
        }

        $factura->setId( (int) $_GET['id']);

        $clientes = new ClienteModelo();
        $clientes->seleccionar(); // Selecciona todos los clientes


        if ($factura->seleccionar())
        {
            require_once("view/factura/factura.editar.php");
        }
        else
        {
            FacturaControlador::error("No se encontró la factura con dicho id");
        }        
    }

    public static function modificar(): void
    {
        $factura = new FacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El id de Factura no puede ser NULL o Undefined");
        }

        $factura->setId((int) $_GET['id']);

        if (! $factura->seleccionar())
        {
            FacturaControlador::error("No se encontró la factura con dicho Id");
        }

        FacturaControlador::validarYAsignar($factura);

        if ( ($factura->modificar() == 1) || $factura->getError() == null) 
        {
            header("location: " . URLSITE . "index.php?c=factura");
        }
        else
        {
            FacturaControlador::error($factura->getError());
        }

    }

    /**
     * Realiza la validación y asigna los valores a un objeto pasado por referencia
     * 
     * @param FacturaModelo $factura Objecto factura por referencia
     * @throws \InvalidArgumentException Fecha formato incorrecta
     * @return void
     */
    public static function validarYAsignar(FacturaModelo &$factura, bool $insertar = false) : void
    {
        try
        {
            $factura->setClienteId((int) $_POST['cliente_id']);

            if ($insertar == true)
            {
                $numero = $factura->seleccionaUltimoNumero();

                $factura->setNumero( $numero + 1);
            }

            $fechaRecibida = $_POST['fecha'];
            $formatoEntrada = 'Y-m-d';

            $objetoFecha = DateTime::createFromFormat($formatoEntrada, $fechaRecibida);

            if ($objetoFecha === false) 
            {             
                throw new InvalidArgumentException("Formato de fecha inválido.");
            }

            $factura->setFecha($objetoFecha);
        }
        catch (Exception $e)
        {
            FacturaControlador::error($e->getMessage());
        }
    }

    public static function error(string $mensaje): void
    {
        $_SESSION['CRUDMVC_ERROR'] = $mensaje;

        header("location: " . URLSITE . "view/error.php");
        die();
    }
}