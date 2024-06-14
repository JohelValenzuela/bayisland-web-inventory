
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



//EXPORTAR EXCEL
//Agrega un event listener al botón de exportar
document.getElementById("btnExportar").addEventListener("click", function() {
  // Obtiene la tabla
  const table = document.getElementById("tabla");

  // Crea una instancia de TableExport con la tabla y algunas opciones
  const tableExport = new TableExport(table, {
      exportButtons: false, // No queremos botones de exportación adicionales
      filename: "Reporte_de_Registros", // Nombre del archivo de Excel
      sheetname: "Registros", // Título de la hoja de Excel
  });

  // Obtiene los datos de exportación
  const datos = tableExport.getExportData();
  
  // Verifica si datos.tabla está definido y si datos.tabla.xlsx está presente
  if (datos.tabla && datos.tabla.xlsx) {
      const preferenciasDocumento = datos.tabla.xlsx;

      // Exporta los datos a un archivo con las preferencias específicas
      tableExport.export2file(
          preferenciasDocumento.data,
          preferenciasDocumento.mimeType,
          preferenciasDocumento.filename,
          preferenciasDocumento.fileExtension,
          preferenciasDocumento.merges,
          preferenciasDocumento.RTL,
          preferenciasDocumento.sheetname
      );
  } else {
      console.error('No se pudo exportar la tabla a Excel. Los datos de exportación no están disponibles.');
  }
});



//EXPORTAR EXCEL
// const $btnExportar = document.querySelector("#btnExportar"),
// $tabla = document.querySelector("#tabla");

// $btnExportar.addEventListener("click", function() {
// let tableExport = new TableExport($tabla, {
//     exportButtons: false, // No queremos botones
//     filename: "Reporte de Datos", //Nombre del archivo de Excel
//     sheetname: "Reporte de Datos", //Título de la hoja
// });
// let datos = tableExport.getExportData();
// let preferenciasDocumento = datos.tabla.xlsx;
// tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
// });