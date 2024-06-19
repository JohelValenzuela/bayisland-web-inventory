<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
use Model\Guia;
use Model\Pedido;
use Model\Producto;
use Model\ReporteDefecto;
use Model\ReportePasajero;
use Model\UnidadMedida;

class PDF extends FPDF {


    function Header()
   {
    $this->Image('build/img/header.png', 0, 0, 300); // Y  W  H
    $this->Image('build/img/logo.png', 3, 3, 50); // Y  W  H
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->SetXY(40, 20);
      $this->SetTextColor(228, 100, 0);
      $this->Cell(220, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE GENERAL DE PASAJEROS')), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $hoy = date('d/m/Y');
      $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha : $hoy")), 0, 0, '', 0);
      $this->Ln(5);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      //$this->Cell(100, 10,  ("REPORTE DE PEDIDOS "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(15, 10,  iconv('UTF-8', 'windows-1252', ('N°')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('FECHA')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('REPORTA')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('CANTIDAD GUÍAS')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('CANTIDAD PASAJEROS')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('CANTIDAD NOSHOW')), 1, 1, 'C', 1);
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


$reporta = ReportePasajero::all();

$pedido = Pedido::all();
$categoria = Categoria::all();
$usuarios = Auth::all();

foreach ($reporta as $reportar) {
    $reportar->reportado_por = Guia::find($reportar->reportado_por_id);
    
}

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 30); //salto de pagina automatico

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

foreach($fila = $reporta as $reporta){
   $pdf->Cell(15, 8, iconv('UTF-8', 'windows-1252', $reporta->id), 1, 0, 'C', 0);
   $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $reporta->fecha), 1, 0, 'C', 0);  
   $pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252', $reportar->reportado_por->nombre), 1, 0, 'C', 0);  
   $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', count(explode(',',$reporta->guias_bote_ids)) . " pax"), 1, 0, 'C', 0); 
   $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', ($reporta->guia1_pasajeros + $reporta->guia2_pasajeros + $reporta->guia3_pasajeros + $reporta->guia4_pasajeros + $reporta->guia5_pasajeros + $reporta->pasajeros_muelle) . " pax"), 1, 0, 'C', 0); 
   $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $reporta->pasajeros_no_show  . " pax"), 1, 1, 'C', 0); 

}


$pdf->Output('ReporteProducto.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();