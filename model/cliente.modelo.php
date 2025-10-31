<?php
/**
 * *MODELO CLIENTE*
 * 
 * *DESCRIPCIÓN*
 * Clase cliente que maneja la lógica de negocio
 * controla las peticiones que se le pueden hacer a base de datos
 * y los métodos que se puedan hacer con el modelo
 * 
 * En este caso, métodos de consulta, edición, borrado, creación
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types=1);

require_once("model/bd/bd.php");


class ClienteModelo extends BD
{
    private int $id = 0;
    private string $nombre = "";
    private string $email = "";

    public ?array $filas = null;

    /**
     * Inserta registro en la base de datos
     * 
     * Toma los valores del objeto actual y sube el registro a la base datos
     * 
     * @return int Número de Filas afectadas
     */
    public function insertar() : int
    {
        $sql = "INSERT INTO cliente VALUES (default, :nombre, :email)";

        $param = [
            "nombre" => $this->nombre, 
            "email"  => $this->email,
        ];

        return $this->_ejecutar($sql, $param);
    }

    /**
     * Modifica los valores de la base de datos
     * 
     * @return int Número de Filas afectadas
     */
    public function modificar() : int
    {
        // Si el objeto no tiene ID
        // No hace nada
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "UPDATE cliente SET nombre = :nombre, email = :email WHERE id = :id";

        $param = [
            "nombre" => $this->nombre,
            "email"  => $this->email,
            "id"     => $this->id,
        ];

        return $this->_ejecutar($sql, $param);
    }


    /**
     * Borra el cliente en la base de datos
     * 
     * @return int Número de Filas afectadas
     */
    public function borrar() : int
    {
        // Si el objeto no tiene ID
        // No hace nada
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "DELETE FROM cliente WHERE id = :id";

        $param = [
            "id" => $this->id,
        ];

        return $this->_ejecutar($sql, $param);
    }

    /**
     * Selecciona 1 o todos los registros
     * 
     * Si el objeto ClienteModelo tiene definido ID, solo traerá un solo registro
     * Si no tiene definido ID, se traerá todos los registros de la base de datos
     * 
     * @return bool True si la consulta es exitosa, False si falla o está vacío
     */
    public function seleccionar() : bool
    {
        $sql = "SELECT * FROM cliente";

        $param = [];

        // Si existe ID, solo buscará esa ID
        if ($this->id != 0)
        {
            $sql .= " WHERE id = :id";
            $param = [
                "id" => $this->id,
            ];
        }

        // Siempre guardamos en filas lo que recibamos
        $this->filas = $this->_consultar($sql, $param);

        // No hemos recibido ninguna fila
        if ($this->filas == null)
        {
            return false;
        }

        // Si tenemos un objeto con ID
        // Aplicamos las propiedades recibidas
        if ($this->id != 0)
        {
            $this->setNombre($this->filas[0]->nombre);
            $this->setEmail($this->filas[0]->email); 
        }

        return true;
    }

    /*
        GETTERS Y SETTERS
    */

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getNombre() : string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre) : void
    {
        // Rechazo porque no cabe en la base de datos varchar(32)
        if (strlen($nombre) > 32)
        {
            throw new InvalidArgumentException("Nombre demasiado largo");
        }

        $this->nombre = $nombre;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        // Si es mayor a 100, varchar(100)
        // o si no es un email válido
        if (strlen($email) > 100 ||
            ! filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            throw new InvalidArgumentException("Email demasiado largo o Formato incorrecto");
        }

        $this->email = $email;
    }

}

