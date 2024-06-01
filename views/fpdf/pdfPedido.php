<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
use Model\DetallePedido;
use Model\MaestroPedido;
use Model\Pedido;
use Model\Producto;

class PDF extends FPDF {


   function Header()
   {
      $this->Image('build/img/header.png', 0, 0, 300); // Y  W  H
      $this->Image('build/img/logo.png', 3, 3, 50); // Y  W  H
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->SetXY(85, 20);
      $this->SetTextColor(228, 100, 0);
      $this->Cell(130, 15,  ('REPORTE DE PEDIDOS'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* FECHA */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $hoy = date('d/m/Y');
      $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha : $hoy")), 0, 0, '', 0);
      $this->Ln(5);

      /* TITULO DE LA TABLA */
      //color
      // $this->SetTextColor(228, 100, 0);
      // $this->Cell(100); // mover a la derecha
      // $this->SetFont('Arial', 'B', 15);
      //$this->Cell(100, 10,  ("REPORTE DE PEDIDOS "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(20, 10,  iconv('UTF-8', 'windows-1252', ('ID')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('N° REF')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('CREADO POR')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('DESICION POR')), 1, 0, 'C', 1);
      $this->Cell(45, 10,  iconv('UTF-8', 'windows-1252', ('ESTADO')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('FECHA')), 1, 1, 'C', 1);
   }

   // Encabezado para el detalle
   function HeaderDetalle()
   {
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(20);  // mover a la derecha
      $this->Cell(20, 8,  iconv('UTF-8', 'windows-1252', ('ID')), 1, 0, 'C', 1);
      $this->Cell(30, 8,  iconv('UTF-8', 'windows-1252', ('MAESTRO')), 1, 0, 'C', 1);
      $this->Cell(50, 8,  iconv('UTF-8', 'windows-1252', ('PRODUCTO')), 1, 0, 'C', 1);
      $this->Cell(50, 8,  iconv('UTF-8', 'windows-1252', ('CANTIDAD')), 1, 0, 'C', 1);
      $this->Cell(105, 8,  iconv('UTF-8', 'windows-1252', ('OBSERVACION')), 1, 1, 'C', 1);
       // Aquí puedes agregar más información si lo necesitas
   }

   function FooterDetalle()
   {
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(20);  // mover a la derecha
      $this->Cell(255, 3,  iconv('UTF-8', 'windows-1252', ('')), 1, 1, 'C', 1);
       // Aquí puedes agregar más información si lo necesitas
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10,  ('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10,  ($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
      $this->Image('build/img/footer.png', 0, 182, 300); // Y  W  H
      $this->Image('build/img/logo.png', 244, 188, 50); // Y  W  H
   }
}

$maestros = MaestroPedido::all(); // Obtener todos los maestros
$detalles = DetallePedido::all(); // Obtener todos los maestros

$pdf = new PDF();
$pdf->AddPage("landscape");
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163);


   // Recorrer los maestros
   foreach ($maestros as $maestro) {
      $maestro->usuario = Auth::find($maestro->usuarioId);
      $maestro->usuarioAprueba = Auth::find($maestro->usuarioIdAprueba);
   }

   foreach ($maestros as $maestro) {
      // Mostrar datos del maestro
      $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $maestro->id), 1, 0, 'C', 0);
      $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $maestro->referencia), 1, 0, 'C', 0);
      $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $maestro->usuario->nombre . " " . $maestro->usuario->apellido), 1, 0, 'C', 0);
      $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', ($maestro->usuarioIdAprueba != 0) ? ($maestro->usuarioAprueba->nombre . " " . $maestro->usuarioAprueba->apellido) : 'Sin Aprobación'), 1, 0, 'C', 0);
      $pdf->Cell(45, 8, iconv('UTF-8', 'windows-1252', $maestro->estado), 1, 0, 'C', 0);
      $pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252', $maestro->fechaCreacion), 1, 1, 'C', 0);

      // Buscar los detalles del maestro actual
    $detalles_encontrados = false; // Variable para controlar si se encontraron detalles o no
    foreach ($detalles as $detalle) {
        if ($detalle->maestroId == $maestro->id) {
            if (!$detalles_encontrados) {
                $pdf->HeaderDetalle();
                $detalles_encontrados = true;
            }

            // Mostrar datos del detalle
            // Ajusta las celdas según tus necesidades
            $pdf->Cell(20);  // mover a la derecha
            //$pdf->Cell(3, 8,  iconv('UTF-8', 'windows-1252', ('')), 1, 0, 'C', 1);
            $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $detalle->id), 1, 0, 'C', 0);
            $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $detalle->maestroId), 1, 0, 'C', 0);
            $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $detalle->productoId), 1, 0, 'C', 0);
            $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $detalle->cantidad), 1, 0, 'C', 0);
            $pdf->Cell(105, 8, iconv('UTF-8', 'windows-1252', $detalle->observacion), 1, 0, 'C', 0);
            //$pdf->Cell(3, 8,  iconv('UTF-8', 'windows-1252', ('')), 1, 0, 'C', 1);
            // Continúa con los demás campos del detalle
            $pdf->Ln(); // Salto de línea después de mostrar un detalle
            //$pdf->FooterDetalle();
        }
    }
}
     

$pdf->Output('ReportePedido.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();