
// CLIENTE EXISTENTE O NUEVO EN VENTAS

document.getElementById('cliente_switch').addEventListener('change', function() {
    var isClienteNuevo = this.checked;
    document.getElementById('nuevo_cliente_div').style.display = isClienteNuevo ? 'block' : 'none';
    document.getElementById('codigo_brazalete_div').style.display = isClienteNuevo ? 'block' : 'none';
    document.getElementById('cliente_existente').style.display = isClienteNuevo ? 'none' : 'block';
});



