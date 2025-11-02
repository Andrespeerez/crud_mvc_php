<?php
/**
 * *CONTROLADOR DEL CLIENTE*
 * 
 * *DESCRIPCIÓN*
 * Implementa todas las funciones que debe realizar
 * la aplicación en función de la petición que reciba
 * 
 * Cada función es una función estática,
 * realiza peticiones a base de datos a través
 * del modelo si es pertinente y
 * manda una vista al usuario
 * 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */


declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}


require_once("model/cliente.modelo.php");


abstract class ClienteControlador
{
    /**
     * Redirige a la vista principal de Cliente
     * realiza una petición de buscar todos los clientes
     * 
     * @return void
     */
    public static function index() : void
    {
        $cliente = new ClienteModelo();

        $cliente->seleccionar();  // Pide al modelo que busque en la bbdd y me devuelva resultados

        require_once("view/cliente/cliente.index.php");
    }

    /**
     * Redirige a la vista de Nuevo Cliente
     * 
     * En mi caso no mando una opción NUEVO,
     * porque tengo clientes separado en 3 vistas distintas
     * 
     * @return void
     */
    public static function nuevo() : void
    {
        require_once("view/cliente/cliente.nuevo.php");
    }

    /**
     * Controla petición de Insertar Nuevo Cliente en BBDD
     * 
     * Cuando reciba una petición de c=cliente?m=insertar
     * pedirá al modelo que inserte el cliente en la bd
     * al terminar redirigue al usuario al index() o a
     * la página de error 
     * 
     * @return void
     */
    public static function insertar() : void
    {
        $cliente = new ClienteModelo();

        ClienteControlador::validarYAsignar($cliente, true);

        if ($cliente->insertar() == 1) // <-- Llamo al Modelo para que inserte en la bbdd
        {
            header("location: " . URLSITE . "index.php?c=cliente");
            die();
        }
        else
        {
            ClienteControlador::error($cliente->getError());
        }
    }

    /**
     * Redirige a la vista de Editar Cliente
     * 
     * En mi caso no mando una opción EDITAR,
     * porque tengo clientes separado en 3 vistas distintas
     * (ahora me arrepiento ...)
     * 
     * @return void
     */
    public static function editar() : void
    {
        $cliente = new ClienteModelo();

        if (!isset($_GET['id']))
        {
            ClienteControlador::error("El ID de usuario no puede ser null o Undefined");
        }

        $cliente->setId((int) $_GET['id']);

        if ($cliente->seleccionar())  // Pido al modelo que me devuelva al cliente con id = (int) $_GET['id']
        {
            require_once("view/cliente/cliente.editar.php");
        }
        else
        {
            ClienteControlador::error($cliente->getError());
        }
    }

    /**
     * Controla petición de Modificar Cliente en BBDD
     * 
     * Cuando reciba una petición de c=cliente?m=modificar
     * pedirá al modelo que modifique el cliente en la bd
     * al terminar redirigue al usuario al index() o a
     * la página de error 
     * 
     * @return void
     */
    public static function modificar() : void
    {
        $cliente = new ClienteModelo();

        if (!isset($_GET['id']))
        {
            ClienteControlador::error("El ID de usuario no puede ser null o Undefined");
        }

        $cliente->setId((int) $_GET['id']);
        if (!$cliente->seleccionar())
        {
            ClienteControlador::error($cliente->getError());
        }

        ClienteControlador::validarYAsignar($cliente, false);

        if ( ($cliente->modificar() == 1) || ($cliente->getError() == null) )
        {
            header("location: " . URLSITE . "index.php?c=cliente");
            die();
        }
        else
        {
            ClienteControlador::error($cliente->getError());
        }
    }

    /**
     * Controla petición de Borrar Cliente en BBDD
     * 
     * Cuando reciba una petición de c=cliente?m=borrar
     * pedirá al modelo que borre el cliente en la bd
     * al terminar redirigue al usuario al index() o a
     * la página de error 
     * 
     * @return void
     */
    public static function borrar() : void
    {
        $cliente = new ClienteModelo();

        if (!isset($_GET['id']))
        {
            ClienteControlador::error("El ID de usuario no puede ser null o Undefined");
        }

        $cliente->setId((int) $_GET['id']);

        if ($cliente->borrar() == 1)
        {
            header("location: " . URLSITE . "index.php?c=cliente");
            die();
        }
        else
        {
            ClienteControlador::error($cliente->getError());
        }
    }

    /**
     * Asigna parámetros recibidos al objeto ClienteModelo
     * 
     * Intenta asignar los parámetros a las propiedades de la clase ClienteModelo
     * 
     * Si lanza una excepción, redirige a la página de error
     * mostrando el correspondiente mensaje guardado en $_SESSION["CRUDMVC_ERROR"]
     * 
     * @param ClienteModelo $cliente Por referencia
     * @param bool $hashear  Si requiere hashear la contraseña, por defecto False
     * @return void
     */
    public static function validarYAsignar(ClienteModelo &$cliente, bool $insertar = false) : void
    {
        try
        {
            // Validaciones de formato
            if ($insertar == true)
            {

                if( ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                {
                    throw new InvalidArgumentException("Email mal formateado");
                }
            
                $cliente->setEmail($_POST['email']); 
            }



            $contrasenaPlana = $_POST["contrasena"] ?? '';
            if ($insertar == true && !empty($contrasenaPlana) )
            {
                if (strlen($contrasenaPlana) < 8)
                {
                    throw new InvalidArgumentException("Contraseña debe tener al menos 8 caracteres.");
                }
                
                $cliente->setContrasena($contrasenaPlana);
            }

            $fechaRecibida = $_POST['fecha_nacimiento'];
            $formatoEntrada = 'Y-m-d';

            $objetoFecha = DateTime::createFromFormat($formatoEntrada, $fechaRecibida);
  
            if ($objetoFecha === false) 
            {             
                throw new InvalidArgumentException("Formato de fecha inválido.");
            }

            // Asignaciones           
            $cliente->setNombre($_POST['nombre']);
            $cliente->setApellidos($_POST['apellidos']);
            $cliente->setDireccion($_POST['direccion']);
            $cliente->setPoblacion($_POST['poblacion']);
            $cliente->setProvincia($_POST['provincia']);
            $cliente->setFechaNacimiento($objetoFecha);  
        }
        catch (Exception $e)
        {
            ClienteControlador::error($e->getMessage());
        }
    }

    public static function error(string $mensaje): void
    {
        $_SESSION['CRUDMVC_ERROR'] = $mensaje;

        header("location: " . URLSITE . "view/error.php");
        die();
    }
}