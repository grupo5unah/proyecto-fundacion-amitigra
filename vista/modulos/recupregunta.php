<?php
include_once('../../funciones/sesionCambioContrasena.php');
$correo = $_SESSION['correo'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">

  <div class="register-box-body">
    <form method="post">
      <p class="register-box-msg">Recuperación por pregunta</p>
      <div class="row">
        <div class="col-md-18">
          <!--INICIO FORM-->
          
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li><a></a></li>               
                <li><a></a></li> 
                <li><a></a></li>
                <li><a></a></li>
                <li><a></a></li>
              </ul>
              <div class="tab-content">
             
                <!--TERCER PREGUNTA-->
                <div class="active tab-pane" id="activity">
                  <div class="post text-center">
                    <div class="form-group">
                    <label class="color-enlaces" for="">Pregunta de recuperación</label>
                    <br>
                      <label class="color-enlaces">Selecciona su pregunta</label>
                      <select name = "pregunta_id" class="form-control">
                      <option>Seleccione una pregunta...</option>
                        <?php
                             include_once ('../../modelo/conexion.php');
      
                             $stmt = "SELECT id_pregunta, pregunta FROM tbl_preguntas";
                             $resultado = mysqli_query($conn,$stmt);
                            ?>
                            <?php foreach($resultado as $opciones):?>
                                <option value="<?php echo $opciones['id_pregunta']?>"><?php echo $opciones['pregunta']?></option>
                            <?php endforeach;?>
                      </select>
                    </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="preg3" class="form-control" name="RespuestaValidar" placeholder="Respuesta" onkeypress="return soloLetras(event); return soloNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <br>
                      <div class="columna">
                      <button class="btn btn-primary" href="olvide_contrasena.php" id="prevtab" data-toggle="tab">Anterior</button>
                      <button class="btn btn-success" href="#timeline" id="nexttab" data-toggle="tab">Siguiente</button>
                      
                    </div>
                  </div>
                </div>
                <!--CONFIGURACION DE LA CONTRASENA-->
                <div class="tab-pane" id="timeline">
                  <div class="post text-center">
                        <div class="input-group col-sm-11 has-feedback">
                        <input id="PassNuevo" type="password" class="form-control" name="password" placeholder="Contraseña">
                        </span>
                      </div>
                      <br>
                      <div class="input-group has-feedback">
                        <input id="ConfPass" type="password" class="form-control" name="password2" placeholder="Confirmar contraseña">
                        <span class="input-group-btn" onclick="mostrarPassword()">
                          <button class="btn btn-default" type="button"><i class="fa fa-eye-slash icon"></i></button>
                        </span>
                      </div>
                      <br>
                      <div class="columna">
                        <button class="btn btn-primary" href="#activity" data-toggle="tab">Anterior</button>
                        <input type="hidden" name="tipo" value="registro">
                        <button type="submit" name="submit" class="btn btn-success">Actualizar</button>
                      </div>
                      
                  </div>
                </div>
                </div>
              </div>
              <!-- /.tab-content -->
            </div>
          
          <!--FIN FORM-->
        </div>   
      </div>
      <?php
                      include("../../controlador/ctr.nuevaPassPregunta.php");

                      $AtualizarPassword = new NuevaPassPregunta();
                      $AtualizarPassword->ctrNuevaPassPregunta();
                      ?>
    </form>
  </div>
  <!-- /.form-box -->
</div>
<script type="text/javascript">
    function mostrarPassword(){

      var nueva = document.getElementById("PassNuevo");
      if(nueva.type == "password"){
        nueva.type = "text";
        $('.icon_nuevo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        nueva.type = "password";
        $('.icon_nuevo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }

      var conf = document.getElementById("ConfPass");
      if(conf.type == "password"){
        conf.type = "text";
        $('.icon_conf').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
      }else{
        conf.type = "password";
        $('.icon_conf').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
      }
    } 
  </script>

<script>
//Botones
var btnEnviar = document.getElementById("enviar");
var btnpreg1 = document.getElementById("preg1");
var btnpreg2 = document.getElementById("preg2");
var btnpreg3 = document.getElementById("preg3");
var btnpass = document.getElementById("pass");

//Inputs
var nombre = document.getElementById("nombre");
var apellido = document.getElementById("apellido");
var preg1 = document.getElementById("pregunta1");
var preg2 = document.getElementById("pregunta2");
var preg3 = document.getElementById("pregunta3");

btnEnviar.disabled = true;
apellido.disabled = true;

function verificar2(valor) {
  if (apellido.value.length>=4){
    btnEnviar.disabled = false;
    btnEnviar.classList.remove("disabled");
  } else {
      btnEnviar.disabled = true;
  }
}

function verificar(valor) {
  if (valor.length>=4){
  	apellido.style.background = "#FFFFFF";
    apellido.disabled = false
  } else {
    //caja2.style.background = "grey";
    apellido.disabled = true;
    apellido.value = "";
    btnEnviar.disabled = true;
  }
   
}
  </script>

  <script>
  var $tabs = $('.nav-tabs li');

$('#prevtab').on('click', function() {
       $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
});

$('#nexttab').on('click', function() {
       $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
});
  </script>

  <!--Solo numero para TELEFONO-->
	<script>
		window.addEventListener("load", function() {
		formulario.telefono.addEventListener("keypress", soloNumeros, false);
		});

		//Solo permite introducir numeros.
		function soloNumeros(e){
		var key = window.event ? e.which : e.keyCode;
		if (key < 48 || key > 57) {
			e.preventDefault();
		}
		}
	</script>

	<!--Solo letras CAMPOS DE NOMBRE, APELLIDO y NOMBRE_USUARIO-->
	<script>
	function soloLetras(e) {
		var key = e.keyCode || e.which,
		tecla = String.fromCharCode(key).toLowerCase(),
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
		especiales = [8, 37, 39, 46],
		tecla_especial = false;

		for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
		}

		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
		}
	}
	</script>

	<!--Permitir solo un ESPACIO-->
	<script>
		espacioLetras=function(input){
		input.value=input.value.replace('  ',' ');}
	</script>

	<script>
		SinEspacio=function(input){
		input.value=input.value.replace(' ','');}
	</script>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>