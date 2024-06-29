<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
use Model\Cliente;
use Model\Cobro;
use Model\Pedido;
use Model\Producto;
use Model\ReporteDefecto;
use Model\UnidadMedida;
use Model\Venta;
use Model\VentaProductos;

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
      $this->Cell(220, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE DE VENTAS')), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
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
      $this->Cell(10, 10,  iconv('UTF-8', 'windows-1252', ('N°')), 1, 0, 'C', 1);
      $this->Cell(70, 10,  iconv('UTF-8', 'windows-1252', ('CLIENTE')), 1, 0, 'C', 1);
      $this->Cell(40, 10,  iconv('UTF-8', 'windows-1252', ('BRAZALETE')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('FECHA VENTA')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('POR PAGAR')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('PAGADO')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('ESTADO')), 1, 1, 'C', 1);
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


$ventas = Venta::all();
$ventaProducto = VentaProductos::all();
$cobros = Cobro::all();

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 30); //salto de pagina automatico

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde



foreach($fila = $ventas as $venta){
   $venta->cliente = Cliente::find($venta->cliente);

   $cantidadPorPagar = 0;
   foreach ($ventaProducto as $vp) {
      if ($vp->venta_id == $venta->id) {
         $cantidadPorPagar += $vp->precio * 1;
      }
   }

   $cobro = null; 
   foreach ($cobros as $c) { 
      if ($c->venta_id == $venta->id) { 
         $cobro = $c; 
         break; 
      } 
   } 

   // Obtener el símbolo de moneda según el método de pago
   $simboloMoneda = '';
                                 
   // Iterar sobre los productos de venta para obtener el método de pago
   foreach($ventaProducto as $vp) {
      if ($vp->venta_id == $venta->id) {
         if (strpos($vp->metodoPago, 'tarjeta-colones') !== false || strpos($vp->metodoPago, 'sinpe') !== false || strpos($vp->metodoPago, 'efectivo-colones') !== false) {
               $simboloMoneda = '₡';
         } elseif (strpos($vp->metodoPago, 'tarjeta-dolares') !== false || strpos($vp->metodoPago, 'efectivo-colones') !== false) {
               $simboloMoneda = '$';
         }
         break; // Romper el bucle una vez que se haya encontrado el método de pago
      }
   }
   
   $pagar = $simboloMoneda . '' . $cantidadPorPagar;
   $pagado = isset($cobro) ? $simboloMoneda . ' ' . $cobro->cantidad_pagada : $simboloMoneda . '' .  0;
   $estado = isset($cobro) ? $cobro->estado : 'Pendiente';

   //debug($venta);
   $pdf->Cell(10, 8, iconv('UTF-8', 'windows-1252', $venta->id), 1, 0, 'C', 0);
   $pdf->Cell(70, 8, iconv('UTF-8', 'windows-1252', $venta->cliente->nombre), 1, 0, 'C', 0);  
   $pdf->Cell(40, 8, iconv('UTF-8', 'windows-1252', $venta->cliente->codigo_brazalete), 1, 0, 'C', 0); 
   $pdf->Cell(60, 8, iconv('UTF-8', 'windows-1252', $venta->fecha), 1, 0, 'C', 0); 
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $pagar), 1, 0, 'C', 0); 
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $pagado), 1, 0, 'C', 0); 
   $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $estado), 1, 1, 'C', 0); 
}


$pdf->Output('ReporteProducto.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();