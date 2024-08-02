document.getElementById('cliente_switch').addEventListener('change', function() {
    var nuevoClienteDiv = document.getElementById('nuevo_cliente_div');
    var codigoBrazaleteDiv = document.getElementById('codigo_brazalete_div');
    var clienteExistente = document.getElementById('cliente_existente');
    
    if(this.checked) {
        nuevoClienteDiv.style.display = 'block';
        codigoBrazaleteDiv.style.display = 'block';
        clienteExistente.style.display = 'none';
    } else {
        nuevoClienteDiv.style.display = 'none';
        codigoBrazaleteDiv.style.display = 'none';
        clienteExistente.style.display = 'block';
    }
});