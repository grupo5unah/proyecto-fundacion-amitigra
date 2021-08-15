$('#datos_buscar').datepicker({
    "locale": {
                "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
  
  format: "yyyy-mm-dd",
  autoclose: true

 });
 
 fetch_data('no');
 
 function fetch_data(is_date_search, start_date='', end_date='')
 {
  $('#managerBitacora').DataTable({

    columnDefs: [
        { className: "text-center ", targets: [0] },
        { className: "text-center ", targets: [1] },
        { className: "text-center ", targets: [2] },
        { className: "text-center ", targets: [3] },
        { className: "text-center ", targets: [4] },
        { className: "text-center ", targets: [5] },
      ],
      //para usar los botones
    responsive: "true",
    dom: "Bfrtip",
    buttons: [
      "pageLength",
      {
        extend: "colvis",
        className: "btn btn-primary",
        titleAttr: "Seleccione las columnas que desee ver",
      },
      {
        extend: "print",
        text: '<i class="fas fa-print">',
        titleAttr: "Imprimir",
        title: "FUNDACION AMIGOS DE LA TIGRA",
        messageTop: " REPORTE DE PERMISOS DEL SISTEMA.",
        className: "btn btn-dark",
        exportOptions: {
          modifier: {
            page: "current",
          },
        },
      },
      {
        sextend: "excelHtml5",
        title: "FUNDACION AMIGOS DE LA TIGRA",
        text: '<i class="fas fa-file-excel">',
        className: "btn btn-success",
        messageTop: " REPORTE DE PERMISOS DEL SISTEMA.",
        exportOptions: {
          columns: [0, ":visible"],
        },
      },

      {
        extend: "pdfHtml5",
        text: '<i class="fas fa-file-pdf">',
        titleAttr: "Exportara a PDF",
        orientation: "portrait",
        pageSize: "A4",
        title: "REPORTE DE PERMISOS DEL SISTEMA",
        //messageTop: " REPORTE DE PERMISOS DEL SISTEMA.",
        Image: "fotoPerfil/foto1.png",
        download: "open",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
          orthogonal: "export",
        },
        customize: function (doc) {
          doc["styles"] = {
            tableHeader: {
              bold: !0,
              fontSize: 10,
              color: "black",
              fillColor: "#F0F8FF",
              alignment: "center",
            },
            // athleteTable: {
            //     //salignment: 'center'
            // },
            // column: {
            //     alignment: 'center'
            // },

            title: {
              fontSize: 10,
              bold: true,
              margin: [0, 0, 0, 10],
              alignment: "center",
            },
          };
          moment.locale("es");
          var datetime = null,
            date = null;

          var update = function () {
            moment.locale("es");
            date = moment(new Date());
            datetime.html(date.format("HH:mm:ss"));
            datetime2.html(date.format("dddd, MMMM DD YYYY"));
          };
          datetime = $('.time h1');
          datetime2 = $('.time p');
          update();
          setInterval(update, 1000);
         

          var cols = [];
          cols[0] = {
            text:  '',
            alignment: "left",
            margin: [0, 0, 0, 0, 0],
          };
          cols[1] = {
            width: '35%',
            text: "FUNDACION AMIGOS DE LA TIGRA ",fontSize: 10, bold:true,
            alignment: "left",
            margin: [25, 25, 5, 0],
            with:[30,30],
          };
          cols[2] = {
            text:  date.format("dddd  D MMMM   YYYY, h:mm:ss"),
            alignment: "right",
            margin: [10, 10, 15, 15],
          };
          var objHeader = {};
          objHeader["columns"] = cols;
          doc["header"] = objHeader;

          doc["content"]["1"].layout = "lightHorizontalLines";
          //doc['content']['1'].table.widths = ['2%', 140, 10, 15];
          doc["content"]["1"].style = "Amitigra";

          var objFooter = {};
          objFooter["alignment"] = "center";
          doc["footer"] = function (currentPage, pageCount) {
            var footer = [
              {
                text: "",
                alignment: "left",
                color: "black",
                margin: [15, 15, 0, 15],
              },
              {
                text: "Pagina " + currentPage + " de " + pageCount,
                alignment: "center",
                color: "black",
                margin: [0, 15, 0, 15],
              },
              {
                text: "",
                alignment: "center",
                color: "black",
                margin: [0, 15, 15, 15],
              },
            ];
            objFooter["columns"] = footer;
            return objFooter;
          };
          doc.content.splice(1, 0, {
            margin: [0, 0, 0, 12],
            width: 50,
            height: 50,
            alignment: "center",

            image:
              "data:image/jpeg;base64,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",
          });
        },
        className: "btn btn-danger",
      },
    ],
    language: {
        buttons: {
          colvis: "Cambiar Colunnas",
          pageLength: "Mostrar Registros",
        },
        url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
      },
 
   "processing" : true,
   "serverSide" : true,
   "order" : [],
   "ajax" : {
    url:"./controlador/ctr.buscarBitacora.php",
    type:"POST",
    data:{
     is_date_search:is_date_search, start_date:start_date, end_date:end_date
    }
   }
  });
 }
 
 $('#search').click(function(){
  var start_date = $('#start_date').val();
  var end_date = $('#end_date').val();
  if(start_date != '' && end_date !='')
  {
   $('#managerBitacora').DataTable().destroy();
   fetch_data('yes', start_date, end_date);
  }
  else
  {
   swal({
     icon: "warning",
     title: "No hay argumento",
     text: "Debes de ingresar un rango de fecha para realizar la búsqueda."
   })
  }
 }); 
 