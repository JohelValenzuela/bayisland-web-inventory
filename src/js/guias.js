// MOSTRAR CAMPOS DE GUÍAS 2 A 5

document.addEventListener('DOMContentLoaded', function() {
    var maxGuias = 5;
    var currentGuia = 1; // Inicialmente mostramos el primer campo de guía

    // Función para mostrar el siguiente campo de guía
    function mostrarSiguienteGuia() {
        if (currentGuia <= maxGuias) {
            var guiaActual = document.getElementById('guia_' + currentGuia);
            if (guiaActual) {
                guiaActual.style.display = ''; // Mostramos el campo de guía actual
                currentGuia++; // Incrementamos para el siguiente campo de guía
            }

            // Si llegamos al máximo de guías, ocultamos el botón
            if (currentGuia > maxGuias) {
                document.getElementById('mostrar_siguiente_guia').style.display = 'none';
            }
        }
    }

    // Manejador del evento click del botón "Mostrar siguiente campo de guía"
    document.getElementById('mostrar_siguiente_guia').addEventListener('click', function() {
        mostrarSiguienteGuia();
    });
});