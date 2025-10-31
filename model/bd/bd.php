<?php
/**
 * *CONEXIÓN A BASE DE DATOS*
 * 
 * *DESCRIPCIÓN*
 * Establece la conexión a la base de datos
 * Registra si se producen errores y
 * ejecuta peticiones en la base de datos
 * 
 * Los modelos Heredan de BD
 * La clase es abstracta para evitar que pueda ser instanciada
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */


declare(strict_types=1);


// Requerir Constantes Configuración
require_once("config.php");


abstract class BD
{
    private ?PDO $con = null;
    protected string $error = '';

    /**
     * Inicializa la conexión con la base de datos
     */
    public function __construct()
    {
        $this->error = '';

        try
        {
            $this->con = new PDO(PDO_MYSQL_CON, USUARIO, CONTRASENA);

            if ($this->con)
            {
                // Gestiona los errores con Excepciones
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // exec() ejecuta directamente en la base de datos
                // Usa el CHARSET utf-8
                $this->con->exec('SET CHARACTER SET utf8');
            }
        }
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
        }
    }

    /**
     * Elimina los atributos antes de destruir la clase
     * evita conexiones abiertas
     */
    public function __destruct()
    {
        $this->con = null;
        $this->error = '';
    }

    /**
     * Realiza una consulta en la base de datos
     * 
     * Recibe una query SQL y un array de parámetros
     * Cuando PDO prepara un statement, le pasas la plantilla de lo que quiere hacer
     * Cuando PDO ejecuta, solo recibe parámetros y lo sustituye en la plantilla
     * 
     * Si se le pasa un parámetro peligroso como "' OR 1 = 1 --"
     * no se ejecuta como código en la base de datos, por lo que previene SQL Injection
     * 
     * @param string $query Query SQL
     * @param array $params Array de parámetros
     * @return ?array Lista de Resultados
     */
    protected function _consultar(string $query, array $params = []) : ?array
    {
        if ($this->con == null)
        {
            return null;
        }


        $this->error = '';

        $filas = null;

        try
        {
            $stmt = $this->con->prepare($query);
            
            $stmt->execute($params);

            $filas = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
        }

        return $filas;
    }

    /**
     * Ejecuta una sentencia en la Base de Datos
     * 
     * Recibe una sentencia SQL a ejecutar y una lista de parámetros
     * Devuelve el número de filas afectadas
     * 
     * @param string $query Sentencia SQL a ejecutar
     * @param array $params Parámetros
     * @return int Numero de filas afectadas
     */
    protected function _ejecutar(string $query, array $params = []) : int
    {
        if ($this->con == null)
        {
            return 0;
        }

        $this->error = '';

        $numFilas = 0;

        try
        {
            $stmt = $this->con->prepare($query);

            $stmt->execute($params);

            $numFilas = $stmt->rowCount();
        }
        catch (PDOException $e)
        {
            $this->error = $e->getMessage();
        }

        return $numFilas;
    }

    /**
     * Devuelve el id de la última fila insertada
     * 
     * @return bool|string Id de la última fila insertada
     */
    protected function _ultimoId() : string|bool
    {
        if ($this->con != null)
        {
            return $this->con->lastInsertId();
        }

        return false;
    }

    public function getError() : string
    {
        return $this->error;
    }

    public function hasError() : bool
    {
        return $this->error != null;
    }
}