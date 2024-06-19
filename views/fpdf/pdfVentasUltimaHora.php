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
use Model\VentaUltimaHora;

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
      $this->Cell(220, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE DE VENTAS DE ULTIMA HORA')), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
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
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('CLIENTE')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('PAÍS')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('VENDEDOR')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('COBRADOR')), 1, 0, 'C', 1);
      $this->Cell(20, 10,  iconv('UTF-8', 'windows-1252', ('PAX')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('DOLARES')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('COLONES')), 1, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('FECHA')), 1, 1, 'C', 1);
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


$ventas = VentaUltimaHora::all();

$pedido = Pedido::all();
$categoria = Categoria::all();
$usuarios = Auth::all();

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 30); //salto de pagina automatico

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

foreach($fila = $ventas as $ventas){
   $pdf->Cell(15, 8, iconv('UTF-8', 'windows-1252', $ventas->id), 1, 0, 'C', 0);
   $pdf->Cell(40, 8, iconv('UTF-8', 'windows-1252', $ventas->nombre_persona), 1, 0, 'C', 0);  
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $ventas->nacionalidad), 1, 0, 'C', 0);   
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $ventas->vendedor_nombre), 1, 0, 'C', 0);   
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $ventas->cobrador_nombre), 1, 0, 'C', 0);   
   $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $ventas->cantidad_personas), 1, 0, 'C', 0);   
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $ventas->total_dolares), 1, 0, 'C', 0);   
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $ventas->total_colones), 1, 0, 'C', 0);   
   $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $ventas->fecha), 1, 1, 'C', 0); 

}


$pdf->Output('ReporteProducto.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();