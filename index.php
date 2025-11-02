<?php
/**
 * *PUNTO DE ENTRADA A LA APLICACIÓN*
 * 
 * *DESCRIPCIÓN*
 * Se ejecuta cada vez que se solicita algo a nuestra aplicación
 * Distribuye el tráfico al correspondiente controlador y método.
 * Actua como un director de orquesta o un router
 * 
 * @author Andrés Pérez Guardiola
 */


declare(strict_types=1);


// Inicializa la sesión
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}


// Requiere valores de configuración
require_once("config.php");


// Requiere los controladores
require_once("controller/app.controlador.php");
require_once("controller/cliente.controlador.php");
require_once("controller/factura.controlador.php");
require_once("controller/lineafactura.controlador.php");


$controlador = '';
if (isset($_GET['c']))
{
    $controlador = $_GET['c'];

    $metodo = '';
    if (isset($_GET['m']))
    {
        $metodo = $_GET['m'];
    }

    /*
    *Seleccionar Controlador*

    Llama al correspondiente controlador y al método solicitado
    -> Esto es lo que funciona como el orquestador
    */
    switch($controlador)
    {
        case 'cliente' :
            if (method_exists('ClienteControlador', $metodo))
            {
                ClienteControlador::{$metodo}();
            }
            else
            {
                ClienteControlador::index();
            }
            
            break;

        case 'app':
            if (method_exists('AppControlador', $metodo))
            {
                AppControlador::{$metodo}();
            }
            else
            {
                AppControlador::index();
            }

            break;

        case 'factura':
            if (method_exists('FacturaControlador', $metodo))
            {
                FacturaControlador::{$metodo}();
            }
            else
            {
                FacturaControlador::index();
            }

            break;

        case 'linea_factura':
            if (method_exists('LineaFacturaControlador', $metodo))
            {
                LineaFacturaControlador::{$metodo}();
            }
            else
            {
                LineaFacturaControlador::index();
            }

            break;

        default :
            AppControlador::index();
    }
}
else
{
    AppControlador::index();
}