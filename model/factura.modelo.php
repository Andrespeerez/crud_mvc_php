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

    public function seleccionar() : bool
    {
        $sql = "SELECT * FROM factura";

        $param = [];

        if ($this->id != 0)
        {
            $sql .= " WHERE id = :id";
            $param = [
                "id" => $this->id,
            ];
        }

        $this->filas = $this->_consultar($sql, $param);

        if ($this->filas == false)
        {
            return true;
        }

        if ($this->id != 0)
        {
            $objeto = $this->filas[0];

            $this->setClienteId($objeto->cliente_id);
            $this->setNumero($objeto->numero);

            $fechaString = $objeto->fecha;
            $fechaDataTime = DateTime::createFromFormat('Y-m-d H:i:s', $fechaString);

            $this->setFecha($fechaDataTime);
        }

        return true;
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