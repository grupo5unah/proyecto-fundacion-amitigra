$(document).ready(function () {
    $('.sidebar-menu').tree()

    $('#reservacion').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      //esta propieda sirve para poder traducir la pagina y en ella se van a crerar objetos
      'language'    : {
        //este objeto es para cambiarle el idioma a la paginacion
        paginate :{
            next: 'Siguiente',
            previous: 'Anterior',
            last: 'Último',
            first: 'Primero'
        },
        //este objeto es para cambiarle el idioma a la infomacion de la parte inferior izquierda
        info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',
        emptyTable: 'No hay registros',
        infoEmpty: '0 registros',
        search: 'Buscar: '
      }
    });
  })
