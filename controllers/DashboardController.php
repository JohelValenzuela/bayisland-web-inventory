<?php

namespace Controllers;

use Model\Auth;
use Model\Categoria;
use Model\Inventario;
use Model\Pedido;
use Model\Producto;
use Model\Receta;
use Model\RecetaIngredientes;
use Model\Regalia;
use Model\ReporteDefecto;
use Model\ReportePasajero;
use Model\Stock;
use Model\UnidadMedida;
use Model\Venta;
use Model\VentaUltimaHora;
use MVC\Router;

class DashboardController {

    public static function mostrar(Router $router) {

        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        /*** CONSULTAS DASHBOARD */

            // Categoría
            $categoriaDash = Categoria::cuentaCantidad();

            // Producto
            $productoDash = Producto::cuentaCantidad();

            // Pedido
            $pedidoDash = Pedido::cuentaCantidad();
            $pedidoDistintos = Pedido::cuentaDistintos('referencia');
            $pedidoPendiente = Pedido::cuentaCantidadEstado('estado', 'Pendiente');
            $pedidoAceptado = Pedido::cuentaCantidadEstado('estado', 'Aceptado');
            $pedidoRechazado = Pedido::cuentaCantidadEstado('estado', 'Rechazado');

            // Kardex
            $inventarioDash = Inventario::cuentaCantidad();
            $inventarioEntrada = Inventario::cuentaCantidadEstado('operacion', 'Entrada');
            $inventarioSalida = Inventario::cuentaCantidadEstado('operacion', 'Salida');

            // Stock
            $stockDash = Stock::cuentaCantidad();

            // Medidas
            $medidasDash = UnidadMedida::cuentaCantidad();

            // Usuarios
            $usuarioDash = Auth::cuentaCantidad();
            $usuarioAdministrador = Auth::cuentaCantidadEstado('rolId', '3');
            $usuarioEncargado = Auth::cuentaCantidadEstado('rolId', '2');

            // Recetas
            $recetasDash = Receta::cuentaCantidad();

            // Ventas
            $ventasDash = Venta::cuentaCantidad();

            // Ventas de última Hora
            $ventas_ultimaDash = VentaUltimaHora::cuentaCantidad();

            // Reportar Daños
            $defectosDash = ReporteDefecto::cuentaCantidad();

            // Reportar Regalía
            $regaliasDash = Regalia::cuentaCantidad();

            // Reportar Pasajeros
            $pasajerosDash = ReportePasajero::cuentaCantidad();

            // Reportar Pasajeros
            $ingredientesDash = RecetaIngredientes::cuentaCantidad();
        
        /*** TERMINA CONSULTAS DASHBOARD */

        /** MOSTRAR DATOS DE TABLA STOCK EN DASHBOARD */

        $stock = Stock::all(); // Columna, Valor
        $inventario = Inventario::allLimitado(5);
        $pedido = Pedido::allLimitado(10);

        $categoria = Categoria::all();
        $producto = Producto::all();
        $usuarios = Auth::all();
           
            foreach ($stock as $stocks) {
                $stocks->producto = Producto::find($stocks->productoId);
                $stocks->usuario = Auth::find($stocks->usuarioId);
            }

            foreach ($inventario as $inventarios) {
                $inventarios->producto = Producto::find($inventarios->productoId);
                $inventarios->usuario = Auth::find($inventarios->usuarioId);
            }

            foreach ($pedido as $pedidos) {
                $pedidos->categoria = Categoria::find($pedidos->categoriaId);
                $pedidos->producto = Producto::find($pedidos->productoId);
                $pedidos->usuario = Auth::find($pedidos->usuarioId);
            }

        $router->render('dashboard/mostrar', [
            'categoriaDash' => $categoriaDash,
            'productoDash' => $productoDash,
            'pedidoDash' => $pedidoDistintos,
            'pedidoPendiente' => $pedidoPendiente,
            'pedidoAceptado' => $pedidoAceptado,
            'pedidoRechazado' => $pedidoRechazado,
            'inventarioDash' => $inventarioDash,
            'inventarioEntrada' => $inventarioEntrada,
            'inventarioSalida' => $inventarioSalida,
            'usuarioDash' => $usuarioDash,
            'usuarioAdministrador' => $usuarioAdministrador,
            'usuarioEncargado' => $usuarioEncargado,
            'medidasDash' => $medidasDash,
            'stockDash' => $stockDash,
            'stock' => $stock,
            'producto' => $producto,
            'usuarios' => $usuarios,
            'inventario' => $inventario,
            'pedido' => $pedido,
            'recetasDash' => $recetasDash,
            'ventasDash' => $ventasDash,
            'ventas_ultimaDash' => $ventas_ultimaDash,
            'defectosDash' => $defectosDash,
            'regaliasDash' => $regaliasDash,
            'pasajerosDash' => $pasajerosDash,
            'ingredientesDash' => $ingredientesDash
        ]);
    }


}