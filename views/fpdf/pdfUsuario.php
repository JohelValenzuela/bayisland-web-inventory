<?php

require 'fpdf.php';

use Model\Auth;
use Model\Categoria;
use Model\Pedido;
use Model\Producto;
use Model\Roles;

class PDF extends FPDF {


    function Header()
   {
      $this->Image('build/img/header.png', 0, 0, 212); // Y  W  H
      $this->Image('build/img/logo.png', 3, 3, 50); // Y  W  H
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->SetXY(40, 20);
      $this->SetTextColor(228, 100, 0);
      $this->Cell(130, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE DE USUARIOS')), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(5);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $hoy = date('d/m/Y');
      $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha : $hoy")), 0, 0, '', 0);
      $this->Ln(5);

    //   /* TELEFONO */
    //   $this->Cell(5);  // mover a la derecha
    //   $this->SetFont('Arial', 'B', 10);
    //   $this->Cell(59, 10,  iconv('UTF-8', 'windows-1252', ("Teléfono : ")), 0, 0, '', 0);
    //   $this->Ln(5);

    //   /* COREEO */
    //   $this->Cell(5);  // mover a la derecha
    //   $this->SetFont('Arial', 'B', 10);
    //   $this->Cell(85, 10,  iconv('UTF-8', 'windows-1252', ("Correo : ")), 0, 0, '', 0);
    //   $this->Ln(5);

    //   /* TELEFONO */
    //   $this->Cell(5);  // mover a la derecha
    //   $this->SetFont('Arial', 'B', 10);
    //   $this->Cell(85, 10,  iconv('UTF-8', 'windows-1252', ("Sucursal : ")), 0, 0, '', 0);
    //   $this->Ln(10);

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
      $this->Cell(50, 10,  iconv('UTF-8', 'windows-1252', ('NOMBRE COMPLETO')), 1, 0, 'C', 1);
      $this->Cell(55, 10,  iconv('UTF-8', 'windows-1252', ('CORREO ELECTRÓNICO')), 1, 0, 'C', 1);
      $this->Cell(30, 10,  iconv('UTF-8', 'windows-1252', ('ROL')), 1, 0, 'C', 1);
      $this->Cell(20, 10,  iconv('UTF-8', 'windows-1252', ('CONF')), 1, 0, 'C', 1);
      $this->Cell(20, 10,  iconv('UTF-8', 'windows-1252', ('ESTADO')), 1, 1, 'C', 1);
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
      $this->Image('build/img/footer.png', 0, 277, 212); // Y  W  H
      $this->Image('build/img/logo.png', 157, 277, 50); // Y  W  H
   }
}


$usuarios = Auth::all();

foreach ($usuarios as $usuario) {
    $usuario->rol = Roles::find($usuario->rolId);
    //debug($usuarios);
 }

$pdf = new PDF();
$pdf->AddPage("portrait"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 20); //salto de pagina automatico

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


foreach($fila = $usuarios as $usuarios){

    if($usuarios->confirmado == 1){
        $val = 'SI';
    } else{
        $val = 'NO';
    }

    $pdf->Cell(15, 8, iconv('UTF-8', 'windows-1252', $usuarios->id), 1, 0, 'C', 0);
    $pdf->Cell(50, 8, iconv('UTF-8', 'windows-1252', $usuarios->nombre . " ". $usuarios->apellido), 1, 0, 'C', 0);  
    $pdf->Cell(55, 8, iconv('UTF-8', 'windows-1252', $usuarios->correo), 1, 0, 'C', 0);  
    $pdf->Cell(30, 8, iconv('UTF-8', 'windows-1252', $usuarios->rol->tipoRol), 1, 0, 'C', 0); 
    $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $val), 1, 0, 'C', 0); 
    $pdf->Cell(20, 8, iconv('UTF-8', 'windows-1252', $usuarios->estado), 1, 1, 'C', 0);  
}


$pdf->Output('ReporteUsuario.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();

