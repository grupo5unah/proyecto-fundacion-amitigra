<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAAT | Registro Usuario</title>
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
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">

  <div class="register-box-body">
    <p class="register-box-msg">Registro de usuario</p>
      <div class="row">
        <div class="col-md-18">
      
          <!--INICIO FORM-->
        
              
              <div class="tab-content">
              <!--INFORMACION DEL USUARIO-->
                
                  <div class="columna">
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="nombre" value="<?php if(isset($_POST['nombre'])){echo $_POST['nombre'];}?>" class="form-control" onkeyup="verificar(this.value)" name="nombre" placeholder="Ingrese su nombre" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <input type="text" maxlength="15" id="apellido" value="<?php if(isset($_POST['apellido'])){echo $_POST['apellido'];}?>" class="form-control" onkeyup="verificar2(this.value)" name="apellido" placeholder="Ingrese su apellido" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                        <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                      </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="15" value="<?php if(isset($_POST['usuario'])){echo $_POST['usuario'];}?>" class="form-control" name="usuario" placeholder="Ingrese su nombre de usuario" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                          <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="50" class="form-control" name="correo" placeholder="Ingrese su correo electrónico" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                          <span class="glyphicon glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                          <select class="form-control">
                            <option disabled selected>Seleccione genero</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                          </select>
                        </div>
                        <div class="form-group has-feedback">
                          <input type="text" maxlength="15" class="form-control" name="usuario" placeholder="Ingrese su número de teléfono" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this)">
                          <span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="text-center form-group has-feedback">
                          <a href="registro.php" class="btn btn-danger">Cancelar</a>
                        </div>
                        <div class="text-center form-group has-feedback">
                          <a href="#" class="btn btn-success">Siguiente</a>
                        </div>
                  </div> 
                

              </div>
              <?php

include("../../controlador/ctr.registro-user.php");

$registroUsuario = new Registro();
$registroUsuario->ctrRegistro();

?>
          
          <!--FIN FORM-->
        </div>   
      </div>
  </div>
</div>

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

<script src="../dist/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../dist/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
</body>
</html>
