<?php
/**
 * *MODELO DE ARTÍCULO*
 * 
 * *DESCRIPCIÓN*
 * 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

declare(strict_types = 1);

require_once("model/bd/bd.php");

class ArticuloModelo extends BD
{
    private int $id = 0;
    private string $referencia = "";
    private string $descripcion = "";
    private float $precio = 0;
    private float $iva = 0;

    public ?array $filas = null;

    public function insertar() : int
    {
        $sql = "INSERT INTO articulo VALUES
                (default, :referencia, :descripcion, :precio, :iva)";

        $param = [
            "referencia"    => $this->referencia,
            "descripcion"   => $this->descripcion,
            "precio"        => $this->precio,
            "iva"           => $this->iva,
        ];

        return $this->_ejecutar($sql, $param);
    }

    public function modificar() : int
    {
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "UPDATE articulo SET referencia = :referencia, descripcion = :descripcion, precio = :precio, iva = :iva
                WHERE id = :id";
        
        $param = [
            "id"            => $this->id,
            "referencia"    => $this->referencia,
            "descripcion"   => $this->descripcion,
            "precio"        => $this->precio,
            "iva"           => $this->iva,
        ];

        return $this->_ejecutar($sql, $param);
    }

    public function borrar() : int
    {
        if ($this-> id == 0)
        {
            return 0;
        }

        $sql = "DELETE FROM articulo WHERE id = :id";

        $param = [
            "id"            => $this->id,
        ];

        return $this->_ejecutar($sql, $param);
    }

    public function seleccionar() : bool
    {
        $sql = "SELECT * FROM articulo";

        $param = [];

        if ($this->id != 0)
        {
            $sql .= " WHERE id = :id";
            $param = [
                "id"        => $this->id,
            ];
        }

        $this->filas = $this->_consultar($sql, $param);

        if ($this->filas == null)
        {
            return false;
        }

        if ($this->id != 0)
        {
            $objeto = $this->filas[0];

            $this->setReferencia( $objeto->referencia);
            $this->setDescripcion($objeto->descripcion);
            $this->setPrecio((float) $objeto->precio);
            $this->setIva((float) $objeto->iva);
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

    public function getReferencia() : string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia) : void
    {
        if (strlen($referencia) > 5)
        {
            throw new Exception("Referencia demasiado larga (max 5)");
        }

        $this->referencia = $referencia;
    }

    public function getDescripcion() : string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion) : void
    {
        if (strlen($descripcion) > 50)
        {
            throw new Exception("Descripción demasiado larga");
        }

        $this->descripcion = $descripcion;
    }

    public function getPrecio() : float
    {
        return $this->precio;
    } 

    public function setPrecio(float $precio) : void
    {
        $this->precio = $precio;
    }

    public function getIva() : float
    {
        return $this->iva;
    }

    public function setIva(float $iva) : void
    {
        $this->iva = $iva;
    }

}