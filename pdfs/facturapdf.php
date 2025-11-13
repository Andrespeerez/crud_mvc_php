<?php 
/**
 * *FACTURA PDF*
 * 
 * *DESCRIPCIÓN*
 * Define la clase FacturaPDF que permite crear PDFs 
 * a partir de los datos recibidos de la tabla Factura y
 * LineasFactura.
 * 
 * En la cabecera incluímos Factura:
 * Número Factura
 * Nombre Cliente
 * Fecha
 * Base Total
 * Importe Total
 * 
 * En la tabla incluimos:
 * Descripción
 * Cantidad
 * Precio
 * Iva
 * Importe
 * 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */


require_once('mc_table.php');

class FacturaPDF extends PDF_MC_Table
{
    public $factura;
    public $filas;

    // Definición de columnas
    public static $col1Width = 60; // Descripción
    public static $col2Width = 25; // Cantidad
    public static $col3Width = 35; // Precio
    public static $col4Width = 20; // IVA
    public static $col5Width = 50; // Importe 

    public function header()
    {
        // TITULO DE PÁGINA
        $this->SetFont('Arial', 'B', 16);  // Arial, Negrita, 16px
        $this->Cell(0, 10, 'FACTURA', 1, 0, 'C');  // CABECERA. CELL representa un espacio donde voy a escribir
        $this->Ln();
        
    }

    public function footer()
    {
        // Posición: a 1 cm del final de la página
        $this->SetY(-10);

        // Arial, sin estilo y tamaño 8
        $this->SetFont('Arial', '', 10);

        // FECHA Y HORA
        $fechayhora = date('d/m/y - h:i');
        $this->Cell(50, 10, $fechayhora, 0, 0, 'L');

        // NÚMERO DE PÁGINAS "Página 1/10"
        $paginaString = mb_convert_encoding('Página ' . $this->PageNo() . ' de {nb}', 'Windows-1252', 'UTF-8');
        $this->Cell(145, 10, $paginaString, 0, 0, 'R');
    }

    public function imprimir() : void
    {
        if ($this->factura)
        {
            $this->SetFont('Arial', '', 14);
            $string = mb_convert_encoding('Número de Factura: ' . $this->factura->numero, 'Windows-1252', 'UTF-8');
            $this->Cell(0, 10, $string, 0, 0, 'L');

            $string = mb_convert_encoding('Fecha: ' . $this->factura->fecha, 'Windows-1252', 'UTF-8');
            $this->Cell(0, 10, $string, 0, 0, 'R');

            $this->Ln();

            $string = mb_convert_encoding('Cliente: ' . $this->factura->nombre_cliente, 'Windows-1252', 'UTF-8');
            $this->Cell(0, 10, $string, 0, 0, 'L');

            $this->Ln();
            $this->Ln();
            $string = mb_convert_encoding('Base: ' . $this->factura->base . ' €', 'Windows-1252', 'UTF-8');
            $this->Cell(0, 10, $string, 0, 0, 'L');
            $string = mb_convert_encoding('Importe: ' . $this->factura->importe . ' €', 'Windows-1252', 'UTF-8');
            $this->Cell(0, 10, $string, 0, 0, 'R');

        }

        // TÍTULO DE CELDAS
        $celdas = [
            'DESCRIPCION' => mb_convert_encoding('Descripción', 'Windows-1252', 'UTF-8'),
            'CANTIDAD' => mb_convert_encoding('Cantidad', 'Windows-1252', 'UTF-8'),
            'PRECIO' => mb_convert_encoding('Precio Unidad', 'Windows-1252', 'UTF-8'),
            'IVA' => mb_convert_encoding('IVA', 'Windows-1252', 'UTF-8'),
            'IMPORTE' => mb_convert_encoding('Importe', 'Windows-1252', 'UTF-8')
        ];

        $this->SetXY(10, 60);
        $this->SetFillColor(0, 0, 0); // COLOR DE FONDO NEGRO
        $this->SetTextColor(255, 255, 255); // COLOR DE LETRA BLANCO
        $this->Cell(FacturaPDF::$col1Width, 10,  $celdas['DESCRIPCION'], 1, 0, 'C', true);
        $this->Cell(FacturaPDF::$col2Width, 10,  $celdas['CANTIDAD'], 1, 0, 'C', true);
        $this->Cell(FacturaPDF::$col3Width, 10,  $celdas['PRECIO'], 1, 0, 'C', true);
        $this->Cell(FacturaPDF::$col4Width, 10,  $celdas['IVA'], 1, 0, 'C', true);
        $this->Cell(FacturaPDF::$col5Width, 10,  $celdas['IMPORTE'], 1, 0, 'C', true);
        $this->Ln();

        $this->SetWidths(array(FacturaPDF::$col1Width, FacturaPDF::$col2Width, FacturaPDF::$col3Width, FacturaPDF::$col4Width, FacturaPDF::$col5Width));
        $this->SetTextColor(0, 0, 0);

        if ($this->filas)
        {
            foreach ($this->filas as $fila)
            {
                $this->Row(
                    array(
                        mb_convert_encoding($fila->descripcion, 'Windows-1252', 'UTF-8'),
                        mb_convert_encoding($fila->cantidad, 'Windows-1252', 'UTF-8'),
                        mb_convert_encoding($fila->precio, 'Windows-1252', 'UTF-8'),
                        mb_convert_encoding($fila->iva, 'Windows-1252', 'UTF-8'),
                        mb_convert_encoding($fila->importe, 'Windows-1252', 'UTF-8')
                    )
                );
            }
        }      

    }
}