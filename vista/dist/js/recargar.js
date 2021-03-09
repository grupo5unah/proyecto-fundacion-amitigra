
$(document).ready(function(){
  $('#perfil').on('submit',function(e){
    e.preventDefault();

    let usuario = $('#usuario').val();
        let password = $('#passConf').val();
        //let foto = document.querySelector('#imagen').value; 
        let tipo = $('#cambio').val();
        let nombre = $('#nombre').val();
        let telefono = $('#telefono').val();
        let correo = $('#correo').val();
    var datos = $(this).serializeArray();

    if(usuario == "" && password == ""){

      let timerInterval

      Swal.fire({
        icon:'error',
        title: 'Error',
        text:'Todos los campos son necesarios',
        timer: 3000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
              const b = content.querySelector('b')
              if (b) {
                b.textContent = Swal.getTimerLeft()
              }
            }
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
      })

    }else{
      

      $.ajax({
        type:$(this).attr("method"),
        url:"../../controlador/ctr.passwordperfil.php",
        data:datos,
        //async:true,
        datatype:'json',
        success: function(data){
          console.log(...data);
          let resultado = data;
          
          if(resultado.respuesta == 'exito'){
            Swal.fire({
              title: "Iniciando sesion",
              text: "",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            });
               window.location.href = "../../../index.php";
              

          }else{
            Swal.fire({
              title: "Deseas ser redirigido",
              text: "Pruebas"
            });
            window.location.href=('../../../index.php');
          }

        }
      })
    }

  });
});
