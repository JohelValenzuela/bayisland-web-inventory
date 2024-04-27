<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
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

      /* UBICACION */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $hoy = date('d/m/Y');
      $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha : $hoy")), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10,  iconv('UTF-8', 'windows-1252', ("Teléfono : ")), 0, 0, '', 0);
      $this->Ln(5);

      /* COREEO */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10,  iconv('UTF-8', 'windows-1252', ("Correo : ")), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10,  iconv('UTF-8', 'windows-1252', ("Sucursal : ")), 0, 0, '', 0);
      $this->Ln(10);

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
      $this->Cell(45, 10,  iconv('UTF-8', 'windows-1252', ('N° REF')), 1, 0, 'C', 1);
      $this->Cell(35, 10,  iconv('UTF-8', 'windows-1252', ('CATEGORÍA')), 1, 0, 'C', 1);
      $this->Cell(35, 10,  iconv('UTF-8', 'windows-1252', ('PRODUCTO')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('CANTIDAD')), 1, 0, 'C', 1);
      $this->Cell(35, 10,  iconv('UTF-8', 'windows-1252', ('ESTADO')), 1, 0, 'C', 1);
      $this->Cell(45, 10,  iconv('UTF-8', 'windows-1252', ('USUARIO')), 1, 0, 'C', 1);
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


$pedido = Pedido::all();
$categoria = Categoria::all();
$producto = Producto::all();
$usuarios = Auth::all();


$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
// /* TABLA */
// $pdf->Cell(30, 10,  ("N°"), 1, 0, 'C', 0);
// $pdf->Cell(40, 10,  ("numero"), 1, 0, 'C', 0);
// $pdf->Cell(40, 10,  ("nombre"), 1, 0, 'C', 0);
// $pdf->Cell(40, 10,  ("precio"), 1, 0, 'C', 0);
// $pdf->Cell(85, 10,  ("info"), 1, 0, 'C', 0);
// $pdf->Cell(40, 10,  ("total"), 1, 1, 'C', 0);


foreach ($pedido as $pedidos) {
   $pedidos->categoria = Categoria::find($pedidos->categoriaId);
   $pedidos->producto = Producto::find($pedidos->productoId);
   $pedidos->usuario = Auth::find($pedidos->usuarioId);
   //debug($usuarios);
}

foreach($fila = $pedido as $pedido){
    $pdf->Cell(45, 8, iconv('UTF-8', 'windows-1252', $pedido->referencia), 1, 0, 'C', 0);
    $pdf->Cell(35, 8, iconv('UTF-8', 'windows-1252', $pedido->categoria->nombre), 1, 0, 'C', 0); 
    $pdf->Cell(35, 8, iconv('UTF-8', 'windows-1252', $pedido->producto->nombre), 1, 0, 'C', 0);     
    $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $pedido->cantidad), 1, 0, 'C', 0);     
    $pdf->Cell(35, 8, iconv('UTF-8', 'windows-1252', $pedido->estado), 1, 0, 'C', 0);   
    $pdf->Cell(45, 8, iconv('UTF-8', 'windows-1252', $pedido->usuario->nombre ." ". $pedidos->usuario->apellido), 1, 0, 'C', 0);   
    $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $pedido->fechaCreacion), 1, 1, 'C', 0);  
}


$pdf->Output('I', 'ReportePedido.pdf');//nombreDescarga, Visor(I->visualizar - D->descargar)

$pdf->Output();