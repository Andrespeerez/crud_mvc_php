<?php
/**
 * *CONTROLADOR DE FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Implementa todas las funciones que debe realizar la aplicación
 * para cada petición que realice el usuario
 * 
 * Emplea el modelo factura.modelo.php para la conexión con base de datos
 * Emplea cliente.modelo.php para mandar opciones de cliente a las vistas editar y nuevo
 * Emplea lineafactura.modelo.php para calcular el importe total de la factura
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
require_once("model/lineafactura.modelo.php");
require_once("pdfs/facturapdf.php");

abstract class FacturaControlador
{
    public static function index(): void
    {
        $facturaObject = new FacturaModelo();

        // Si recibo ID de cliente
        // Solo muestro las facturas de dicho cliente
        if (isset($_GET['cliente_id']))
        {
            $facturaObject->setClienteId((int) $_GET['cliente_id']); // Solo facturas de dicho cliente
        }

        $facturaObject->seleccionar();

        $facturas = $facturaObject->filas;  // Array de Objectos (DTO)

        FacturaControlador::calcularBaseYTotal($facturas);

        require_once("view/factura/factura.index.php");
    }

    public static function nuevo(): void
    {
        $clientesObject = new ClienteModelo();
        if ($clientesObject->seleccionar())
        {
            $clientes = $clientesObject->filas;
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
            FacturaControlador::redirigirIndex();
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
            FacturaControlador::redirigirIndex();
        }
        else
        {
            FacturaControlador::error($factura->getError());
        }
    }

    public static function editar(): void
    {
        $facturaObjeto = new FacturaModelo();

        if (! isset($_GET['id']))
        {
            FacturaControlador::error("El id de Factura no puede ser NULL o Undefined");
        }

        $facturaObjeto->setId( (int) $_GET['id']);

        $clienteObjeto = new ClienteModelo();
        $clienteObjeto->seleccionar(); // Selecciona todos los clientes

        if ($facturaObjeto->seleccionar())
        {
            $facturas = $facturaObjeto->filas; // Enviamos un array de DTOs
            $clientes = $clienteObjeto->filas; // Enviamos un array de DTOs

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
            FacturaControlador::redirigirIndex();
        }
        else
        {
            FacturaControlador::error($factura->getError());
        }

    }

    public static function imprimir() : void
    {
        $facturas = new FacturaModelo();
        $facturas->setId((int) $_GET['factura_id']);
        $facturas->seleccionar();

        FacturaControlador::calcularBaseYTotal($facturas->filas);

        $lineas = new LineaFacturaModelo();
        $lineas->setFacturaId((int) $_GET['factura_id']);
        $lineas->seleccionar();

        $pdf = new FacturaPDF();

        $pdf->AliasNbPages();

        $pdf->AddPage();

        $pdf->SetFont('Arial', '', 12);
        
        $pdf->factura = $facturas->filas[0];
        $pdf->filas = $lineas->filas;

        $pdf->imprimir();

        $pdf->Output();
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
                $numero = (int) $factura->seleccionaUltimoNumero();

                $factura->setNumero( (int) $numero + 1);
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

    /**
     * Refirigue la vista a la página de Error
     * 
     * @param string $mensaje Mensaje de error a mostrar
     * @return never
     */
    public static function error(string $mensaje): void
    {
        $_SESSION['CRUDMVC_ERROR'] = $mensaje;

        header("location: " . URLSITE . "view/error.php");
        die();
    }

    /**
     * Redirigue la vista al Index.
     * 
     * Si recibió un parámetro de cliente_id, mostrará solo las facturas de dicho cliente
     * Si no recibe dicho parámetro, devolverá todas las facturas
     * 
     * @return never
     */
    public static function redirigirIndex() : void
    {
        if (isset($_GET['cliente_id']))
                header("location: " . URLSITE . "index.php?c=factura&cliente_id=" . (int) $_GET['cliente_id']);
        else
            header("location: " . URLSITE . "index.php?c=factura");

        die();
    }
    

    /**
     * Procedimiento:
     * Añade los campos "base" y "importe" totales a la factura
     * 
     * Muta el array que recibe
     * 
     * Dependencias con lineafactura.modelo.php
     * 
     * @param array $facturaDTOs Array de facturas
     * @return void
     */
    public static function calcularBaseYTotal(array &$facturaDTOs) : void
    {   
        // Doble foreach! Rendimiento mal! 
        // Mejor un service y que se guarde en base de datos
        // TODO: FacturaService que se encargue de actualizar base y importe cada vez que se
        // TODO: cambie o agrege algo nuevo en LineasFactura para dicha factura

        // Por cada factura ...
        foreach ($facturaDTOs as &$factura)
        {
            $factura->base = 0;
            $factura->importe = 0;

            $lineasFacturaObject = new LineaFacturaModelo();
            $lineasFacturaObject->setFacturaId($factura->id);

            // Obtengo sus lineas factura
            if ($lineasFacturaObject->seleccionar() && $lineasFacturaObject->filas !== null)
            {
                $lineasFactura = $lineasFacturaObject->filas;

                $base = 0;
                $importe = 0;
                // Sumo cada linea factura para obtener la base total y su importe total
                foreach ($lineasFactura as $linea)
                {
                    $base += $linea->precio * $linea->cantidad;
                    $importe += $linea->importe;
                }

                // Asigno los valores al DTO que recibirá la vista
                $factura->base = $base;
                $factura->importe = $importe;
            }
            else
            {
                // fallo en la búsqueda
                FacturaControlador::error($lineasFacturaObject->getError());
            }
        }
    }
}