<?php

require 'fpdf.php';

use Model\Auth;
use Model\Capitan;
use Model\Categoria;
use Model\Cliente;
use Model\Cobro;
use Model\Guia;
use Model\Inventario;
use Model\Pedido;
use Model\Producto;
use Model\ReportePasajero;
use Model\UnidadMedida;
use Model\Venta;
use Model\VentaProductos;


$id = validarORedireccionar('/ventas');
$venta = Venta::find($id);

$ventaId = $venta->id;

class PDF extends FPDF {

   function Header() {
        $id = validarORedireccionar('/ventas');
        $venta = Venta::find($id);
        $clienteSeleccionado = Cliente::find($venta->cliente);
        
        $ventaId = $venta->id;
        $ventaProductos = VentaProductos::findVentaProductos($ventaId);
        $fecha = date("F, j, Y, g:i a");
        $cliente = $clienteSeleccionado->nombre . " - " . $clienteSeleccionado->codigo_brazalete;
        $tipoCambio = number_format($_SESSION['tipo_cambio'], 2) . " colones" ;


                            $sumas = []; // Inicializamos un array para almacenar las sumas de precio por método de pago
                            $clienteTieneVentas = false; // Variable para verificar si el cliente tiene ventas
                            foreach ($ventaProductos as $producto) : 
                                // Verificar si el producto tiene un cobro vinculado
                                $cobroVinculado = Cobro::findVenta($producto->venta_id);
                                if (!$cobroVinculado) :
                                    // Obtener el cliente asociado a la venta del producto
                                    $clienteProducto = Venta::find($producto->venta_id)->cliente;
                                    // Verificar si la venta pertenece al cliente seleccionado
                                    if (intval($clienteProducto) == intval($clienteSeleccionado->id)) : ?>
                                        <?php $clienteTieneVentas = true; // El cliente tiene ventas ?>       
                                    <?php 
                                        // Agregar el precio del producto al array de sumas según el método de pago
                                        $sumas[$producto->metodoPago] = isset($sumas[$producto->metodoPago]) ? $sumas[$producto->metodoPago] + $producto->precio : $producto->precio;
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach;

$sum_colones = 0;
$sum_dolares = 0;
foreach ($sumas as $metodoPago => $suma) : 
    if ($metodoPago == 'tarjeta-colones' || $metodoPago == 'sinpe' || $metodoPago == 'efectivo-colones') {
        $sum_colones += $suma;
    } elseif ($metodoPago == 'tarjeta-dolares' || $metodoPago == 'efectivo-dolares') {
        $sum_dolares += $suma;
    }
endforeach;

$totalColones = ($sum_dolares * $_SESSION['tipo_cambio']) + $sum_colones ;
$totalDolares = ($sum_colones / $_SESSION['tipo_cambio']) + $sum_dolares;
$tipo_cambio = number_format($_SESSION['tipo_cambio'], 2);


        $this->Image('build/img/header.png', 0, 0, 300); // Y  W  H
        $this->Image('build/img/logo.png', 3, 3, 50); // Y  W  H
        $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(95); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        //creamos una celda o fila
        $this->SetXY(85, 20);
        $this->SetTextColor(27, 25,45);
        $this->Cell(130, 15,  iconv('UTF-8', 'windows-1252', ('REPORTE DE VENTA' )), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); //color

        $this->SetTextColor(0, 0, 0); //colorTexto

        /* REPORTE ID */
        $this->SetXY(30, 50);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Venta: N° $ventaId")), 0, 0, '', 0);
        $this->Ln(5);

        /* FECHA */
        $this->SetXY(30, 60);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Fecha: $fecha")), 0, 0, '', 0);
        $this->Ln(5);

        /* REPORTA */
        $this->SetXY(30, 70);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Cliente: $cliente")), 0, 0, '', 0);
        $this->Ln(5);

        /* REPORTE ID */
       $this->SetXY(180, 50);
       $this->SetFont('Arial', 'B', 14);
       $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Monto Colones: $totalColones")), 0, 0, '', 0);
       $this->Ln(5);

       /* FECHA */
       $this->SetXY(180, 60);
       $this->SetFont('Arial', 'B', 14);
       $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Monto Dolares: $totalDolares")), 0, 0, '', 0);
       $this->Ln(5);

       /* REPORTA */
       $this->SetXY(180, 70);
       $this->SetFont('Arial', 'B', 14);
       $this->Cell(96, 10,  iconv('UTF-8', 'windows-1252', ("Tipo Cambio Dolar: $tipo_cambio")), 0, 0, '', 0);
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
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->SetXY(30, 90);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('Producto')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('Cantidad')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('Precio')), 1, 0, 'C', 1);
      $this->Cell(60, 10,  iconv('UTF-8', 'windows-1252', ('Método de Pago')), 1, 1, 'C', 1);
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

$ventaProductos = VentaProductos::findVentaProductos($ventaId);

$pdf->SetXY(30, 100);
foreach($fila = $ventaProductos as $vp){
   $pdf->SetX(30);
   $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', Producto::find($vp->producto_id)->nombre), 1, 0, 'C', 0);
   $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $vp->cantidad), 1, 0, 'C', 0);  
   $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $vp->precio), 1, 0, 'C', 0);  
   $pdf->Cell(60, 10, iconv('UTF-8', 'windows-1252', $vp->metodoPago), 1, 1, 'C', 0);  
}

$pdf->Output('ReporteInventario.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
$pdf->Output();

