$(document).ready(function(){
    //image: 'sampleImage.jpg', 
    $('#mantenimientoProducto').DataTable({
 
      //para usar los botones 
      responsive:"true",
      dom: 'Bfrtip',
        buttons: [
          'pageLength',
          {
            extend:'colvis',
            className:'btn btn-primary',
            titleAttr:'Seleccione las columnas que desee ver',
   
        },
        {
            extend: 'print',
            text:'<i class="fas fa-print">',
            titleAttr:'Imprimir',
            title:'FUNDACION AMIGOS DE LA TIGRA',
            messageTop:' REPORTE DE LOCALIDADES',
            className:'btn btn-dark',
            exportOptions: {
              modifier: {
                  page: 'current'
              }
            }
          },
            {
                extend: 'excelHtml5',
                title: 'FUNDACION AMIGOS DE LA TIGRA',
                text:'<i class="fas fa-file-excel">',
                className:'btn btn-success',
                messageTop: 'REPORTE DE LOCALIDADES.',
                exportOptions: {
                  columns: [ 0, ':visible' ]
              },
            },
        
           
            {
                extend: "pdfHtml5",
                text: '<i class="fa fa-file-pdf-o text-red"></i>',
                titleAttr: 'Export to PDF',
                orientation: 'portrait',
                pageSize: 'A4',
                title:  '',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 8, 7, 8],
                    orthogonal: 'export'
                },
                customize: function(doc){
                    doc['styles'] = {
                        tableHeader: {
                            bold: !0,
                            fontSize: 11,
                            color: 'black',
                            fillColor: '#F0F8FF',
                            alignment: 'center'
                        },
                        athleteTable: {
                            //alignment: 'center'
                        },
                        column1: {
                            alignment: 'center'
                        },
                        title: {
                            fontSize: 18,
                            bold: true,
                            margin: [0, 0, 0, 10],
                            alignment: 'center'
                        }
                    };
                    var cols = [];
                    cols[0] = {text: 'Athlete', alignment: 'left', margin:[15, 10, 10, 10] };
                    cols[1] = {text: moment().format('MMMM do YYYY, h:mm:ss'), alignment: 'right', margin:[10, 10, 15, 15] };
                    var objHeader = {};
                    objHeader['columns'] = cols;
                    doc['header'] = objHeader;

                    doc['content']['1'].layout = 'lightHorizontalLines';
                    doc['content']['1'].table.widths = ['2%', 140, 10, 15, 25, 20, 140, 20];
                    doc['content']['1'].style = 'athleteTable';

                    var objFooter = {};
                    objFooter['alignment'] = 'center';
                    doc["footer"] = function(currentPage, pageCount) {
                        var footer = [
                            {
                                text: 'A .. Active, I .. Inactive',
                                alignment: 'left',
                                color: 'red',
                                margin:[15, 15, 0, 15]
                            },{
                                text: 'Page ' + currentPage + ' of ' + pageCount,
                                alignment: 'center',
                                color: 'blue',
                                margin:[0, 15, 0, 15]
                            },{
                                text: '',
                                alignment: 'center',
                                color: 'blue',
                                margin:[0, 15, 15, 15]
                            }
                        ];
                        objFooter['columns'] = footer;
                        return objFooter;
                    };
                }, className: 'btn btn-default'
            }
          
          ],
          language: {
            buttons: {
                colvis: 'Cambiar Colunnas',
                pageLength:'Mostrar Registros'
            }
           },
           "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
     
    });
    
   
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    } $("#typeP").change( function() {
        if ($(this).val() !== '3') {
            $("#Rprice").prop("disabled", true);
        } else {
            $("#Rprice").prop("disabled", false);
        }
    });
    

   
    $('.btnEditarProducto').on('click', function() {
        // info previa
        const idproduct = $(this).data('idproduct'); 
        const nombre = $(this).data('nomproducto');
        const precioP = $(this).data('preciop');
        const cantidadP = $(this).data('cantproducto');
        const descripcion = $(this).data('desc');
        const tipoProduct = $(this).data('tp');
        const precioAl = $(this).data('precioal');
        var usuario_actual = $("#usuario_actual").val();
        //llena los campos
        
        $("#product").val(nombre);
        $("#price").val(precioP);
        $("#count").val(cantidadP);
        $("#des").val(descripcion);
        $("#opcion").val(tipoProduct);
        $("#Rprice").val(precioAl);
               
     
        //mostrar el modal
        $('#modalEditarProductos').modal('show');
        
        $('.btnEditarBD').on('click', async function() {
            var IdP = Number(idproduct); 
            //console.log(IdRol);
            const formData = new FormData();
            formData.append('id_product', IdP);
            formData.append('nameP',$("#product").val());
            formData.append('priceP',$("#price").val());
            formData.append('countP',$("#count").val());
            formData.append('desc',$("#des").val());
            formData.append('typeP',$("#typeP").val());
            formData.append('rentalP',$("#Rprice").val());
            formData.append('usuario_actual', usuario_actual);
          
            
           const resp = await axios.post('./controlador/api.php?action=actualizarProducto', formData);
           const data = resp.data;
           // console.log(data);
            if(data.error){
                return swal("Error", data.msj, "error", {
                    timer:3000,
                    buttons:false
                });
            } else{
                $('#modalEditarProductos').modal('hide');
                return swal("Exito!", data.msj, "success", {
                    timer:3000,
                    buttons:false
                }).then(() => {
                    
                    $("#product").val('');
                    $("#price").val('');
                    $("#count").val('');
                    $("#des").val('');
                    //$("#opcion").val('');
                    $("#Rprice").val('');
                    location.reload(); 
                })
            }
                
        });
        
    })
    //eliminar productos
    $('.btnDeleteP').on('click', function (){
        
        const idproduct = $(this).data('idp');
        console.log(idproduct);
        swal("Eliminar Producto", "Esta seguro de eliminar este Producto?", "warning",{buttons: [true, "OK"]}).then(async (value) => {
            if (value){
                
                const formData = new FormData();
                formData.append('id_producto', idproduct);
                const resp = await axios.post('./controlador/api.php?action=eliminarProducto', formData);
                const data = resp.data;
                //console.log(data);
                if(data.error){
                    return swal("Error", data.msj, "error",{
                        buttons: false,
                        timer: 3000
                    });
                }
                return swal("Exito!", data.msj, "success",{
                    buttons: false,
                    timer: 3000
                }).then(() =>{ 
                    location.reload();
                });
            }
        });
    })

    // Botones de reporte
     
   

}); 