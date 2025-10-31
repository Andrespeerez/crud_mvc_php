<?php
/**
 * *CONTROLADOR DE LA APLICACIÓN*
 * 
 * *DESCRIPCIÓN*
 * Controla peticiones a la página principal de la aplicación
 * Es el controlador por defecto cuando no se le da controlador
 * a la URL
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}

abstract class AppControlador
{
    /**
     * Redirige a la vista principal de la Aplicación
     * 
     * @return void
     */
    public static function index(): void
    {
        require_once("view/app.php");
    }

    /**
     * Destruye la sesión actual
     * 
     * @return void
     */
    public static function logout() : void
    {
        $_SESSION = [];
        session_destroy();     

        require_once("view/app.php");
    }
}