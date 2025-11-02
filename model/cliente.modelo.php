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
    
    private string $email = "";
    private string $contrasenaHash = "";
    private string $nombre = "";
    private string $apellidos = "";
    private string $direccion = "";
    private string $poblacion = "";
    private string $provincia = "";
    private ?DateTime $fechaNacimiento = null;

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
        $sql = "INSERT INTO cliente VALUES 
                (default, :email, :contrasena, :nombre, :apellidos, 
                :direccion, :poblacion, :provincia, :fecha_nacimiento)";

        $param = [
            "email"             => $this->email,
            "contrasena"        => $this->contrasenaHash,
            "nombre"            => $this->nombre, 
            "apellidos"         => $this->apellidos,
            "direccion"         => $this->direccion,
            "poblacion"         => $this->poblacion,
            "provincia"         => $this->provincia,
            "fecha_nacimiento"  => $this->fechaNacimiento->format('Y-m-d'),
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

        $sql = "UPDATE cliente SET email = :email, contrasena = :contrasena, nombre = :nombre,
                apellidos = :apellidos, direccion = :direccion, poblacion = :poblacion,
                provincia = :provincia, fecha_nacimiento = :fecha_nacimiento      
                WHERE id = :id";

        $param = [
            "id"                => $this->id,
            "email"             => $this->email,
            "contrasena"        => $this->contrasenaHash,
            "nombre"            => $this->nombre, 
            "apellidos"         => $this->apellidos,
            "direccion"         => $this->direccion,
            "poblacion"         => $this->poblacion,
            "provincia"         => $this->provincia,
            "fecha_nacimiento"  => $this->fechaNacimiento->format('Y-m-d'),            
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
            $objeto = $this->filas[0];

            $this->setEmail($objeto->email);
            $this->contrasenaHash = $objeto->contrasena; // Directo, porque el set hace hash
           
            $this->setNombre($objeto->nombre);
            $this->setApellidos($objeto->apellidos);
            $this->setDireccion($objeto->direccion);
            $this->setPoblacion($objeto->poblacion);
            $this->setProvincia($objeto->provincia);

            $fechaString = $objeto->fecha_nacimiento;
            $fechaDataTime = DateTime::createFromFormat('Y-m-d H:i:s', $fechaString);
            // throw new Exception($fechaString); // para debugging
            $this->setFechaNacimiento($fechaDataTime);
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

    public function getContrasena(): string
    {
        return $this->contrasenaHash;
    }

    public function setContrasena(string $contrasena): void
    {
        if (strlen($contrasena) > 255)
        {
            throw new InvalidArgumentException("Contraseña Inválida");
        }

        $this->contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
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

    public function getApellidos() : string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos) : void
    {
        // Rechazo porque no cabe en la base de datos varchar(100)
        if (strlen($apellidos) > 100)
        {
            throw new InvalidArgumentException("Apellidos demasiado largo");
        }

        $this->apellidos = $apellidos;
    }

    public function getDireccion() : string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion) : void
    {
        // Rechazo porque no cabe en la base de datos varchar(100)
        if (strlen($direccion) > 100)
        {
            throw new InvalidArgumentException("Dirección demasiado largo");
        }

        $this->direccion = $direccion;
    }

    public function getPoblacion() : string
    {
        return $this->poblacion;
    }

    public function setPoblacion(string $poblacion) : void
    {
        // Rechazo porque no cabe en la base de datos varchar(32)
        if (strlen($poblacion) > 32)
        {
            throw new InvalidArgumentException("Población demasiado largo");
        }

        $this->poblacion = $poblacion;
    }

    public function getProvincia() : string
    {
        return $this->poblacion;
    }

    public function setProvincia(string $provincia) : void
    {
        // Rechazo porque no cabe en la base de datos varchar(32)
        if (strlen($provincia) > 32)
        {
            throw new InvalidArgumentException("Provincia demasiado largo");
        }

        $this->provincia = $provincia;
    }

    public function getFechaNacimiento() : DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(DateTime $fechaNacimiento) : void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

}

