<?php 
/**
 * *CONSTANTES DE LA APLICACIÓN*
 * 
 * *DESCRIPCIÓN* 
 * Constantes de ámbito global de la aplicación
 * Conexión a base de datos
 * URL del sitio
 *
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

// URL del sitio
define("URLSITE", "http://localhost/DAES/unidad16/mvc/");  


// Base de Datos
define("HOST", "localhost");
define("BASEDATOS", "mvc_crud");
define("USUARIO", "mvcapp");
define("CONTRASENA", "");

define("PDO_MYSQL_CON", "mysql:host=" . HOST .";dbname=" . BASEDATOS . ";charset=utf8");