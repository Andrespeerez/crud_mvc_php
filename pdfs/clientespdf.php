<?php 
/**
 * *CLIENTES PDF*
 * 
 * *DESCRIPCIÓN*
 * Define la clase ClientesPDF que permite crear PDFs 
 * a partir de los datos recibidos de la tabla clientes.
 * 
 * Las columnas devueltas son: 
 * Nombre Apellidos
 * Email
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

require_once('mc_table.php');

class ClientesPDF extends PDF_MC_Table
{
    public $filas;  // Filas de datos de clientes recibidas

    // Ancho de página 190mm (210mm - 10mm - 10mm), donde 10mm es el margen por cada lado
    public static int $col1Width = 75;
    public static int $col2Width = 115;

    public function header() : void 
    {

        // TITULO DE PÁGINA
        $this->SetFont('Arial', 'B', 16);  // Arial, Negrita, 16px
        $this->Cell(0, 10, 'LISTADO DE CLIENTES', 1, 0, 'C');  // CABECERA. CELL representa un espacio donde voy a escribir

        // TÍTULO DE CELDAS
        $celdas = [
            'NOMBRE' => mb_convert_encoding('Nombre', 'Windows-1252', 'UTF-8'),
            'APELLIDOS' => mb_convert_encoding('Apellidos', 'Windows-1252', 'UTF-8'),
            'EMAIL' => mb_convert_encoding('Email', 'Windows-1252', 'UTF-8'),
            'DIRECCION' => mb_convert_encoding('Dirección', 'Windows-1252', 'UTF-8'),
            'POBLACION' => mb_convert_encoding('Población', 'Windows-1252', 'UTF-8'),
            'PROVINCIA' => mb_convert_encoding('Provincia', 'Windows-1252', 'UTF-8'),
        ];

        $this->SetXY(10, 20);
        $this->SetFillColor(0, 0, 0); // COLOR DE FONDO NEGRO
        $this->SetTextColor(255, 255, 255); // COLOR DE LETRA BLANCO
        $this->Cell(ClientesPDF::$col1Width, 10,  $celdas['NOMBRE'], 1, 0, 'C', true);
        $this->Cell(ClientesPDF::$col2Width, 10,  $celdas['EMAIL'], 1, 0, 'C', true);

        // SALTO DE LINEA (como si fuera una máquina de escrbir)
        $this->Ln();
    }   

    public function footer(): void
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

    public function imprimir()
    {
        $this->SetWidths(array(ClientesPDF::$col1Width, ClientesPDF::$col2Width));

        if ($this->filas)
        {
            foreach ($this->filas as $fila)
            {
                $this->Row(
                    array(
                        mb_convert_encoding($fila->nombre . ' ' . $fila->apellidos, 'Windows-1252', 'UTF-8'),
                        mb_convert_encoding($fila->email, 'Windows-1252', 'UTF-8')
                    )
                );
            }
        }
    }

}


