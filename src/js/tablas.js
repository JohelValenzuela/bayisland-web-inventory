
let dataTable = new DataTable("#tabla", {
    
    responsive: true,

    columnDefs: [
        {
            "targets": "_all",
            "defaultContent": ""
        }
    ],

    buttons: [{
        extend: 'excelHtml5',
        text: '  Excel',
        className: 'btn btn-primary glyphicon glyphicon-list-alt',
        title: 'User Report',
        footer: true
      }, {
        extend: 'pdfHtml5',
        text: '  PDF',
        className: 'btn btn-primary glyphicon glyphicon-file',
        title: 'User Report'
      }, {
        extend: 'csvHtml5',
        text: '  CSV',
        className: 'btn btn-primary glyphicon glyphicon-save-file',
        title: 'User Report'
      }, {
        extend: 'copy',
        text: '  Copy',
        className: 'btn btn-primary glyphicon glyphicon-duplicate'
      }, {
        extend: 'print',
        text: '  Print',
        title: 'User Report',
        className: 'btn btn-primary glyphicon glyphicon-print',
        message: 'User Report'
      }],

    layout:{
        // top2Start: 'paging',
        topStart: 'pageLength',
        topEnd: 'search',
        bottonStart: 'info',
        bottonEnd: 'paging',

        topStart: {
            pageLength: {
                menu: [5, 10, 20, 50, 100]
            }
        },

        topEnd: {
            search: {
                placeholder: 'Buscar...'
            }
        },
    },

    language: {
        emptyTable:     "No hay registros disponibles en la tabla",
        info:           "Mostrando _END_ de _MAX_ registros",
        infoEmpty:      "",
        infoFiltered:   "(filtrado de _MAX_ registros)",
        infoPostFix:    "",
        thousands:      ",",
        lengthMenu:     "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing:     "",
        search:         "Buscar:",
        zeroRecords:    "No se encontraron registros",
        paginate: {
            first:      "<<",
            last:       ">>",
            next:       "Siguiente >",
            previous:   "< Anterior"
        },
        aria: {
            orderable:  "Ordenar por esta columna",
            orderableReverse: "Ordenar por esta columna (Reversa)"
        }
    }

});

$('#categoriaId').on('change',function(){
    dataTable.search.fixed('categoria', $(this).val()).draw();
})

$('#medidas').on('change',function(){
    dataTable.search.fixed('medida', $(this).val()).draw();
})

$('#estado').on('change',function(){
    dataTable.search.fixed('estado', $(this).val()).draw();
})

$('#movimiento').on('change',function(){
    dataTable.search.fixed('movimiento', $(this).val()).draw();
})

$('#productoId').on('change',function(){
    dataTable.search.fixed('producto', $(this).val()).draw();
})

$('#cliente_id').on('change',function(){
    dataTable.search.fixed('cliente_id', $(this).val()).draw();
})

$('#cliente_id').on('change',function(){
    dataTable.search.fixed('cliente', $(this).val()).draw();
})

$('#roles').on('change',function(){
    dataTable.search.fixed('rol', $(this).val()).draw();
}
)
$('#bodegaId').on('change',function(){
    dataTable.search.fixed('bodega', $(this).val()).draw();
})


let dataTable2 = new DataTable("#movimientos", {   
    responsive: true,

    layout:{
        // top2Start: 'paging',
        topStart: 'pageLength',
        topEnd: 'search',
        bottonStart: 'info',
        bottonEnd: 'paging',

        topStart: {
            pageLength: {
                menu: [5, 10, 20, 50, 100]
            }
        },

        topEnd: {
            search: {
                placeholder: 'Buscar...'
            }
        },
    },

    language: {
        emptyTable:     "No hay registros disponibles en la tabla",
        info:           "Mostrando _END_ de _MAX_ registros",
        infoEmpty:      "",
        infoFiltered:   "(filtrado de _MAX_ registros)",
        infoPostFix:    "",
        thousands:      ",",
        lengthMenu:     "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing:     "",
        search:         "Buscar:",
        zeroRecords:    "No se encontraron registros",
        paginate: {
            first:      "<<",
            last:       ">>",
            next:       "Siguiente >",
            previous:   "< Anterior"
        },
        aria: {
            orderable:  "Ordenar por esta columna",
            orderableReverse: "Ordenar por esta columna (Reversa)"
        }
    }
    
});

let dataTable3 = new DataTable("#pedidos", {   
    responsive: true,

    layout:{
        // top2Start: 'paging',
        topStart: 'pageLength',
        topEnd: 'search',
        bottonStart: null,
        bottonEnd: null,

        topStart: {
            pageLength: {
                menu: [5, 10, 20, 50, 100]
            }
        },

        topEnd: {
            search: {
                placeholder: 'Buscar...'
            }
        },
    },

    language: {
        emptyTable:     "No hay registros disponibles en la tabla",
        info:           "Mostrando _END_ de _MAX_ registros",
        infoEmpty:      "",
        infoFiltered:   "(filtrado de _MAX_ registros)",
        infoPostFix:    "",
        thousands:      ",",
        lengthMenu:     "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing:     "",
        search:         "Buscar:",
        zeroRecords:    "No se encontraron registros",
        paginate: {
            first:      "<<",
            last:       ">>",
            next:       "Siguiente >",
            previous:   "< Anterior"
        },
        aria: {
            orderable:  "Ordenar por esta columna",
            orderableReverse: "Ordenar por esta columna (Reversa)"
        }
    }
    
});

let dataTable4 = new DataTable("#minimo", {   
    responsive: true,
    pageLength: 5,

    layout:{
        // top2Start: 'paging',
        topStart: 'pageLength',
        topEnd: 'search',
        bottonStart: null,
        bottonEnd: null,

       

        topEnd: {
            search: {
                placeholder: 'Buscar...'
            }
        },
    },

    language: {
        emptyTable:     "No hay registros disponibles en la tabla",
        info:           "Mostrando _END_ de _MAX_ registros",
        infoEmpty:      "",
        infoFiltered:   "(filtrado de _MAX_ registros)",
        infoPostFix:    "",
        thousands:      ",",
        lengthMenu:     "Mostrar _MENU_ registros",
        loadingRecords: "Cargando...",
        processing:     "",
        search:         "Buscar:",
        zeroRecords:    "No se encontraron registros",
        paginate: {
            first:      "<<",
            last:       ">>",
            next:       "Siguiente >",
            previous:   "< Anterior"
        },
        aria: {
            orderable:  "Ordenar por esta columna",
            orderableReverse: "Ordenar por esta columna (Reversa)"
        }
    }
    
});