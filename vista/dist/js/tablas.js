$(document).ready(function() {
  $('#tablas').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
    },
    //para usar los botones 
    responsive:"true",
    dom: 'Bfrtip',
      buttons: [ 
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
  });
  $('#productTable').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
    },
    //para usar los botones 
    responsive:"true",
    dom: 'Bfrtip',
      buttons: [ 
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5'
    ]
  });
    
    $('#manageProductTable').DataTable({
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
      },
      //para usar los botones 
      responsive:"true",
      dom: 'Bfrtip',
        buttons: [ 
          'copyHtml5',
          'excelHtml5',
          'csvHtml5',
          'pdfHtml5'
      ]
        // {
        //   extend: 'excelHtml5',
        //   autoFilter: true,
        //   sheetName: 'Exported data',
        //   text:'<i class="fas fa-file-excel">',
        //   titleAttr:'Exportar a excel',
        //   className:'btn btn-success'
        // },
        // {
        //   extend:'pdfHtml5',
        //   text:'<i class="fas fa-file-pdf">',
        //   titleAttr:'Exportar a Pdf',
        //   className:'btn btn-danger'
        // },
        // {
        //   extend: 'print',
        //   text:'<i class="fas fa-fila-print">',
        //   titleAttr:'Imprimir',
        //   className:'btn btn-info'
        // },
     // ]


     } );
});