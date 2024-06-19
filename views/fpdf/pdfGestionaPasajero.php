<?php

require 'fpdf.php';

use Model\Auth;
use Model\Capitan;
use Model\Categoria;
use Model\Guia;
use Model\Inventario;
use Model\Pedido;
use Model\Producto;
use Model\ReportePasajero;
use Model\UnidadMedida;

$capitanes = Capitan::all();
$guias = Guia::all();
$reportes = ReportePasajero::all();
       



class PDF extends FPDF {

   function Header() {
        $id = validarORedireccionar('/pasajeros');
        $reporte = ReportePasajero::find($id);

        // Convertir la fecha de creación al formato dd-mm-yyyy
        $fechaCreacion = new DateTime($reporte->fecha);
        $fecha = $fechaCreacion->format('d-m-Y');
        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');

        $cantidad_pasajeros = $reporte->guia1_pasajeros + $reporte->guia2_pasajeros + $reporte->guia3_pasajeros + $reporte->guia4_pasajeros + $reporte->guia5_pasajeros + $reporte->pasajeros_muelle;

        $guia1 = ($reporte->guia1_id == NULL) ? '' : Guia::find($reporte->guia1_id);
        $guia2 = ($reporte->guia2_id == NULL) ? '' : Guia::find($reporte->guia2_id);
        $guia3 = ($reporte->guia3_id == NULL) ? '' : Guia::find($reporte->guia3_id);
        $guia4 = ($reporte->guia4_id == NULL) ? '' : Guia::find($reporte->guia4_id);
        $guia5 = ($reporte->guia5_id == NULL) ? '' : Guia::find($reporte->guia5_id);
        $guia_muelle = ($reporte->guia_muelle_id == NULL) ? '' : Guia::find($reporte->guia_muelle_id);
        $reportado_por = ($reporte->reportado_por_id == NULL) ? '' : Guia::find($reporte->reportado_por_id);
        $capitan = ($reporte->capitan_id == NULL) ? '' : Capitan::find($reporte->capitan_id);


        $this->Image('build/img/header.png', 0, 0, 300); // Y  W  H
        $this->Image('build/img/logo.png', 3, 3, 50); // Y  W  H
        $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(95); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        //creamos una celda o fila
        $this->SetXY(85, 20);
        $this->SetTextColor(27, 25,45);
        $this->Cell(130, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE DEL PASAJEROS (' . $fecha . ')' )), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); //color

        $this->SetTextColor(0, 0, 0); //colorTexto

        /* REPORTE ID */
        $this->SetXY(30, 60);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Reporte : $reporte->id")), 0, 0, '', 0);
        $this->Ln(5);

        /* FECHA */
        $this->SetXY(30, 70);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha : $fechaCreacionFormateada")), 0, 0, '', 0);
        $this->Ln(5);

        /* REPORTA */
        $this->SetXY(30, 80);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Reporta :  $reportado_por->nombre")), 0, 0, '', 0);
        $this->Ln(5);

        /* CAPITÁN */
        $this->SetXY(30, 90);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Capitán : $capitan->nombre")), 0, 0, '', 0);
        $this->Ln(5);

        /* CANTIDAD PASAJEROS */
        $this->SetXY(30, 100);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Total Pax : $cantidad_pasajeros")), 0, 0, '', 0);
        $this->Ln(5);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(27, 25,45);
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      //$this->Cell(100, 10,  ("REPORTE DE PEDIDOS "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetXY(125, 60);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('')), 0, 0, 'C', 1);
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('NOMBRE')), 0, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('CANTIDAD PAX')), 0, 1, 'C', 1);
      $this->SetXY(125, 70);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('GUÍA 1')), 0, 0, 'C', 1);

      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia1) ? $guia1->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->guia1_pasajeros . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 80);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('GUÍA 2')), 0, 0, 'C', 1);

      $this->SetFillColor(228, 233, 247); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia2) ? $guia2->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->guia2_pasajeros . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 90);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('GUÍA 3')), 0, 0, 'C', 1);

      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia3) ? $guia3->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->guia3_pasajeros . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 100);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('GUÍA 4')), 0, 0, 'C', 1);

      $this->SetFillColor(228, 233, 247); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia4) ? $guia4->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->guia4_pasajeros . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 110);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('GUÍA 5')), 0, 0, 'C', 1);

      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia5) ? $guia5->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->guia5_pasajeros . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 120);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('MUELLE')), 0, 0, 'C', 1);

      $this->SetFillColor(228, 233, 247); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, iconv('UTF-8', 'windows-1252', (($guia_muelle) ? $guia_muelle->nombre : '-')), 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->pasajeros_muelle . ' pax', 1, 1, 'C', 1);

      $this->SetXY(125, 130);
      $this->SetFillColor(27, 25,45); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('NO SHOW')), 0, 0, 'C', 1);

      $this->SetFillColor(255, 255, 255); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(230, 228, 228); //colorBorde
      $this->SetFont('Arial', 'B', 12);
      $this->Cell(50, 10, '-', 1, 0, 'C', 1);
      $this->Cell(60, 10, $reporte->pasajeros_no_show . ' pax', 1, 1, 'C', 1);

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

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 30); //salto de pagina automatico

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


$pdf->Output('ReporteInventario.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();

