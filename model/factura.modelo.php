<?php
/**
 * *FACTURA MODELO*
 * 
 * *DESCRIPCIÓN*
 * Clase factura que maneja la lógica del negocio
 * controla las peticiones que se le pueden hacer a base de datos
 * y los métodos que se le pueden hacer al modelo
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types=1);


require_once("model/bd/bd.php");

class FacturaModelo extends BD
{
    private int $id = 0;
    private int $clienteId = 0;
    private int $numero = 0;
    private ?DateTime $fecha = null;

    public ?array $filas = null;

    /**
     * Inserta nuevos registros en factura
     * 
     * Toma los valores del objeto actual para insertar en base de datos
     * 
     * @throws Exception IF clienteId no está definido
     * @return int Número de filas insertadas
     */
    public function insertar() : int
    {
        if ($this->clienteId == 0)
        {
            throw new Exception("El id de cliente al que corresponde la factura no está definido");
        }

        $sql = "INSERT INTO factura VALUES (default, :cliente_id, :numero, :fecha)";

        $params = [
            "cliente_id"    => $this->clienteId,
            "numero"        => $this->numero,
            "fecha"         => $this->fecha->format("Y-m-d"),
        ];

        return $this->_ejecutar($sql, $params);
    }

    /**
     * Borrar registro en base de datos para factura
     * 
     * @return int Número de filas afectadas
     */
    public function borrar() : int
    {
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "DELETE FROM factura WHERE id = :id";

        $param = [
            "id" => $this->id
        ];

        return $this->_ejecutar($sql, $param);
    }

    /**
     * Modifica un registro en la base de datos
     * 
     * @return int Número de filas afectadas
     */
    public function modificar() : int
    {
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "UPDATE factura SET cliente_id = :cliente_id, numero = :numero, fecha = :fecha 
         WHERE id = :id";

        $param = [
            "id"          => $this->id,
            "cliente_id"  => $this->clienteId,
            "numero"      => $this->numero,
            "fecha"       => $this->fecha->format("Y-m-d"),
        ];

        return $this->_ejecutar($sql, $param);
    }

    /**
     * Selecciona 1 o todos los registros
     * 
     * Si el objeto FacturaModelo tiene definido ID, solo traerá un solo registro
     * Si no tiene definido ID, se traerá todos los registros de la base de datos
     * 
     * @return bool True si la consulta es exitosa, False si falla o está vacío
     */
    public function seleccionar() : bool
    {
        $sql = "SELECT f.id as id, f.cliente_id as cliente_id, f.numero as numero, f.fecha as fecha, CONCAT_WS(' ', c.nombre, c.apellidos) as nombre_cliente 
                FROM factura as f
                JOIN cliente as c ON f.cliente_id = c.id";

        $param = [];
    
        // Caso de Búsqueda 0, Todas las facturas

        // Caso de Búsqueda 1
        // Búsqueda de Factura por ID, solo devuelve un resultado
        if ($this->id != 0)
        {
            $sql .= " WHERE f.id = :id";
            $param = [
                "id" => $this->id,
            ];
        }

        // Caso de Búsqueda 2
        // Búsqueda de Facturas que pertenezcan a un Cliente, todas las facturas de un cliente
        if ($this->clienteId != 0)
        {
            $sql .= " WHERE f.cliente_id = :cliente_id";
            $param = [
                "cliente_id" => $this->clienteId,
            ];
        }

        $this->filas = $this->_consultar($sql, $param);

        // Salgo prematuramente si no encuentro registros
        // Devuelvo true, porque la búsqueda ha sido existosa, aunque no arroja resultados
        if ($this->filas == false)
        {
            return true;
        }

        // Rehidratar el modelo con datos de la base de datos
        // Solo cuando estoy recibiendo un solo registro de la base de datos
        // i.e. cuando busco una factura por ID
        if ($this->id != 0)
        {
            $objeto = $this->filas[0];

            $this->setClienteId((int) $objeto->cliente_id);
            $this->setNumero((int) $objeto->numero);

            $fechaString = $objeto->fecha;
            $fechaDataTime = DateTime::createFromFormat('Y-m-d H:i:s', $fechaString);

            $this->setFecha($fechaDataTime);
        }

        return true;
    }


    /**
     * Devuelve el número de factura mayor en la base de datos
     * 
     * Utilizo una numeración de factura incremental. 
     * Las nuevas facturas reciben el número de factura = (número máximo + 1).
     * 
     * @return int Número de factura mayor
     */
    public function seleccionaUltimoNumero() : int
    {
        $sql = "SELECT max(numero) as max_numero FROM factura";

        $numero = $this->_consultar($sql, []);

        return (int) $numero[0]->max_numero;
    }


    // GETTERS Y SETTERS
    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    public function getClienteId() : int
    {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId) : void
    {
        $this->clienteId = $clienteId;
    }

    public function getNumero() : int
    {
        return $this->numero;
    }

    public function setNumero(int $numero) : void
    {
        $this->numero = $numero;
    }

    public function getFecha() : DateTime
    {
        return $this->fecha;
    }

    public function setFecha(DateTime $fecha) : void
    {
        $this->fecha = $fecha;
    }
}