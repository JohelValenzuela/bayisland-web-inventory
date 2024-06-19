<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
use Model\DetallePedido;
use Model\MaestroPedido;
use Model\Pedido;
use Model\Producto;
use Model\Receta;
use Model\RecetaIngredientes;
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
      $this->SetXY(85, 20);
      $this->SetTextColor(228, 100, 0);
      $this->Cell(130, 15,  ('REPORTE DE RECETAS E INGREDIENTES'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
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
      $this->Cell(110, 10,  iconv('UTF-8', 'windows-1252', ('RECETA')), 1, 0, 'C', 1);
      $this->Cell(145, 10,  iconv('UTF-8', 'windows-1252', ('OBSERVACIÓN')), 1, 1, 'C', 1);
   }

   // Encabezado para el detalle
   function HeaderDetalle()
   {
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(20);  // mover a la derecha
      $this->Cell(20, 8,  iconv('UTF-8', 'windows-1252', ('ID')), 1, 0, 'C', 1);
      $this->Cell(90, 8,  iconv('UTF-8', 'windows-1252', ('PRODUCTO')), 1, 0, 'C', 1);
      $this->Cell(145, 8,  iconv('UTF-8', 'windows-1252', ('CANTIDAD')), 1, 1, 'C', 1);
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

$receta = Receta::all(); // Obtener todos los maestros
$ingredientesReceta = RecetaIngredientes::all(); // Obtener todos los maestros

$pdf = new PDF();
$pdf->AddPage("landscape");
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163);


   foreach ($ingredientesReceta as $ingredientes) {
      $ingredientes->producto = Producto::find($ingredientes->productoId);
      $ingredientes->medida = UnidadMedida::find($ingredientes->producto->medidaId);
   }

   foreach ($receta as $recetas) {
      $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $recetas->id), 1, 0, 'C', 0);
      $pdf->Cell(110, 8, iconv('UTF-8', 'windows-1252', $recetas->nombre), 1, 0, 'C', 0);
      $pdf->Cell(145, 8, iconv('UTF-8', 'windows-1252', $recetas->observacion), 1, 1, 'C', 0);

     
        $ingredienteRecetaEncontrado = false;
        $pdf->HeaderDetalle();
        foreach($ingredientesReceta as $ingredienteReceta) {
            if($ingredienteReceta->recetaId == $recetas->id) {
                $ingredienteRecetaEncontrado = true;
            }


            // Mostrar datos del detalle
            // Ajusta las celdas según tus necesidades
            $pdf->Cell(20);  // mover a la derecha
            //$pdf->Cell(3, 8,  iconv('UTF-8', 'windows-1252', ('')), 1, 0, 'C', 1);
            $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $ingredienteReceta->id), 1, 0, 'C', 0);
            $pdf->Cell(90, 8, iconv('UTF-8', 'windows-1252', $ingredientes->producto->nombre), 1, 0, 'C', 0);
            $pdf->Cell(145, 8, iconv('UTF-8', 'windows-1252', $ingredienteReceta->cantidad . " onz"), 1, 0, 'C', 0);
            //$pdf->Cell(3, 8,  iconv('UTF-8', 'windows-1252', ('')), 1, 0, 'C', 1);
            // Continúa con los demás campos del detalle
            $pdf->Ln(); // Salto de línea después de mostrar un detalle
            //$pdf->FooterDetalle();
        }
    }

     

$pdf->Output('ReportePedido.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();