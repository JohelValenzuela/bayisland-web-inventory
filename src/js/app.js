
//SIDEBAR LAYOUT
let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e)=>{
 let arrowParent = e.target.parentElement.parentElement;
 arrowParent.classList.toggle("mostrarMenu");
  });
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
sidebarBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("close");
});

// EXPORTAR EXCEL
const $btnExportar = document.querySelector("#btnExportar"),
$tabla = document.querySelector("#tabla");

$btnExportar.addEventListener("click", function() {
let tableExport = new TableExport($tabla, {
    exportButtons: false, // No queremos botones
    filename: "Reporte de Datos", //Nombre del archivo de Excel
    sheetname: "Reporte de Datos", //Título de la hoja
});
let datos = tableExport.getExportData();
let preferenciasDocumento = datos.tabla.xlsx;
tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
});


