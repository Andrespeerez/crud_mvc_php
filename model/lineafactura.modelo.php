<?php 
/**
 * *MODELO LINEA FACTURA*
 * 
 * @author Andrés Pérez Guardiola
 */


declare(strict_types=1);

require_once("model/bd/bd.php");
require_once("controller/lineafactura.controlador.php");

class LineaFacturaModelo extends BD
{
    private int $id = 0;
    private int $facturaId = 0;
    private int $referencia = 0;
    private string $descripcion = '';
    private float $cantidad = 0;
    private float $precio = 0;
    private float $iva = 21.0;
    private float $importe = 0;


    public ?array $filas = null;

    
    public function insertar(): int
    {
        if ($this->facturaId == 0)
        {
            throw new Exception("El id de Factura no está definido");
        }

        $sql = "INSERT INTO lineas_factura 
                VALUES (default, :factura_id, :referencia, :descripcion, :cantidad, :precio, :iva, :importe)";      

        $this->importe = $this->calcularImporte();

        $params = [
            "factura_id"    => $this->facturaId,
            "referencia"    => $this->referencia,
            "descripcion"   => $this->descripcion,
            "cantidad"      => $this->cantidad,
            "precio"        => $this->precio,
            "iva"           => $this->iva,
            "importe"       => $this->importe,
        ];

        return $this->_ejecutar($sql, $params);
    }

    public function borrar() : int
    {
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "DELETE FROM lineas_factura WHERE id = :id";

        $params = [
            "id" => $this->id,
        ];

        return $this->_ejecutar($sql, $params);
    }

    public function modificar() : int
    {
        if ($this->id == 0)
        {
            return 0;
        }

        $sql = "UPDATE lineas_factura SET 
                factura_id = :factura_id, 
                referencia = :referencia, 
                descripcion = :descripcion, 
                cantidad = :cantidad, 
                precio = :precio, 
                iva  = :iva, 
                importe = :importe
                WHERE id = :id";

        $this->importe = $this->calcularImporte();

        $params = [
            "id"            => $this->id,
            "factura_id"    => $this->facturaId,
            "referencia"    => $this->referencia,
            "descripcion"   => $this->descripcion,
            "cantidad"      => $this->cantidad,
            "precio"        => $this->precio,
            "iva"           => $this->iva,
            "importe"       => $this->importe,
        ];

        return $this->_ejecutar($sql, $params);
    }


    public function seleccionar() : bool
    {
        $sql = "SELECT * FROM lineas_factura ";

        $param = [];

        if ($this->id != 0)
        {
            $sql .= " WHERE id = :id";
            $param['id'] = $this->id;
        }
        else 
        {
            $sql .= " WHERE factura_id = :factura_id";
            $param['factura_id'] = $this->facturaId;
        }

        $this->filas = $this->_consultar($sql, $param);

        if ($this->filas == false)
        {
            return true;
        }

        if ($this->id != 0)
        {
            $objeto = $this->filas[0];

            $this->setReferencia($objeto->referencia);
            $this->setDescripcion($objeto->descripcion);
            $this->setCantidad((float) $objeto->cantidad);
            $this->setPrecio((float) $objeto->precio);
            $this->setIva((float) $objeto->iva);
            $this->setImporte((float) $objeto->importe);
        }

        return true;
    }

    public function seleccionaUltimaReferencia() : int
    {
        $sql = "SELECT max(referencia) as max_referencia FROM lineas_factura WHERE factura_id = :factura_id";

        $params = [
            "factura_id" => $this->facturaId,
        ];

        $referencia = $this->_consultar($sql, $params);

        return (int) $referencia[0]->max_referencia;
    }

    // Calcular importe
    public function calcularImporte() : float
    {
        return $this->cantidad * $this->precio * (1 + $this->iva / 100.0);
    }


    // GETTERS y SETTERS
    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFacturaId() : int
    {
        return $this->facturaId;
    }

    public function setFacturaId(int $facturaId) : void
    {
        $this->facturaId = $facturaId;
    }

    public function getReferencia() : int
    {
        return $this->referencia;
    }

    public function setReferencia(int $referencia) : void
    {
        $this->referencia = $referencia;
    }

    public function getDescripcion() : string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getCantidad() : float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad) : void
    {
        $this->cantidad = $cantidad;
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

    public function getImporte() : float
    {
        return $this->importe;
    }

    public function setImporte(float $importe) : void
    {
        $this->importe = $importe;
    }

}