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

abstract class LineaFacturaControlador
{
    public static function index(): void
    {
        require_once("view/lineafactura/lineafactura.index.php");
    }
}