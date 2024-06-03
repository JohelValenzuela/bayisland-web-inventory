<?php

namespace Controllers;

use Model\Cliente;
use Model\Cobro;
use Model\Producto;
use Model\Receta;
use Model\Venta;
use Model\VentaProductos; // Agrega el modelo de VentaProductos
use MVC\Router;

class CobrosController {

    public static function mostrar(Router $router) {
        $clientes = Cliente::all();
        $clienteSeleccionado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
            $clienteSeleccionado = Cliente::find($_POST['cliente_id']);
        }

        $router->render('cobros/mostrar', [
            'clientes' => $clientes,
            'clienteSeleccionado' => $clienteSeleccionado
        ]);
    }

    public static function seleccionarCliente(Router $router) {
        $alertas = [];
        $clientes = Cliente::all();
        $clienteSeleccionado = null;
        $ventaCliente = null;
        $productosVenta = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
            $clienteSeleccionado = Cliente::find($_POST['cliente_id']);
            $ventaCliente = Venta::findVentaPorCliente($_POST['cliente_id']);

            //debug($ventaCliente);
            
            // Obtener todos los productos de venta
            $productosVenta = VentaProductos::all();
            
        }

        foreach ($productosVenta as $productoVenta) {
            $productoVenta->producto = Producto::find($productoVenta->producto_id);
            $productoVenta->receta = Receta::find($productoVenta->receta_id);
            $productoVenta->venta = Venta::find($productoVenta->receta_id);

            
        }

        $router->render('cobros/seleccionarCliente', [
            'clientes' => $clientes,
            'clienteSeleccionado' => $clienteSeleccionado,
            'ventaCliente' => $ventaCliente,
            'productosVenta' => $productosVenta,
            'alertas' => $alertas
        ]);
    }

}
