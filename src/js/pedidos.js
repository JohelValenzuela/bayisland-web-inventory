document.addEventListener('DOMContentLoaded', function() {
    const botonesIncremento = document.querySelectorAll('.incremento');
    const botonesDecremento = document.querySelectorAll('.decremento');
    const categoriaLinks = document.querySelectorAll('.categoria-enlace'); // Cambiado a .categoria-enlace
    const productos = document.querySelectorAll('.producto-card');
    const inputBusqueda = document.getElementById('inputBusqueda');
    const btnClear = document.getElementById('btnClear');
    const mensajeNoResultados = document.getElementById('mensajeNoResultados');
    const mostrarTodosLink = document.querySelector('.mostrar-todos');

    botonesIncremento.forEach(boton => {
        boton.addEventListener('click', function() {
            incrementarCantidad(boton);
        });
    });

    botonesDecremento.forEach(boton => {
        boton.addEventListener('click', function() {
            decrementarCantidad(boton);
        });
    });

    categoriaLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoriaId = link.getAttribute('data-categoria'); // Obtener el ID de la categoría

            // Remover la clase de todos los enlaces de categoría
            categoriaLinks.forEach(item => {
                item.classList.remove('categoria-seleccionada');
            });

            // Agregar la clase a la categoría seleccionada
            link.classList.add('categoria-seleccionada');

            filtrarProductosPorCategoria(categoriaId);
        });
    });

    inputBusqueda.addEventListener('input', function() {
        filtrarProductos();
    });

    btnClear.addEventListener('click', function() {
        inputBusqueda.value = '';
        filtrarProductos();
    });

    mostrarTodosLink.addEventListener('click', function(e) {
        e.preventDefault();
        mostrarTodosProductos();
    });

    function incrementarCantidad(boton) {
        let inputCantidad = boton.parentElement.previousElementSibling.querySelector('.cantidad');
        let cantidadActual = parseInt(inputCantidad.value);
        inputCantidad.value = cantidadActual + 1;
    }

    function decrementarCantidad(boton) {
        let inputCantidad = boton.parentElement.previousElementSibling.querySelector('.cantidad');
        let cantidadActual = parseInt(inputCantidad.value);
        if (cantidadActual > 1) {
            inputCantidad.value = cantidadActual - 1;
        }
    }

    function mostrarTodosProductos() {
        productos.forEach(producto => {
            producto.style.display = 'block';
        });
        mensajeNoResultados.style.display = 'none';
    }

    function filtrarProductosPorCategoria(categoriaId) {
        productos.forEach(producto => {
            const categoriaProducto = producto.getAttribute('data-categoria'); // Obtener el ID de categoría del producto
            if (categoriaId === '' || categoriaProducto === categoriaId) {
                producto.style.display = 'block';
            } else {
                producto.style.display = 'none';
            }
        });

        const algunProductoVisible = Array.from(productos).some(producto => producto.style.display !== 'none');
        mensajeNoResultados.style.display = algunProductoVisible ? 'none' : 'block';
    }

    function filtrarProductos() {
        const valorBusqueda = inputBusqueda.value.trim().toLowerCase();
        productos.forEach(producto => {
            const nombreProducto = producto.querySelector('h3').textContent.toLowerCase();
            const cumpleBusqueda = nombreProducto.includes(valorBusqueda) || valorBusqueda === '';
            if (cumpleBusqueda) {
                producto.style.display = 'block';
            } else {
                producto.style.display = 'none';
            }
        });

        const algunProductoVisible = Array.from(productos).some(producto => producto.style.display !== 'none');
        mensajeNoResultados.style.display = algunProductoVisible ? 'none' : 'block';
    }
});