<?php
//include_once()
include_once('funciones/sesiones.php');
$usuario = $_SESSION['usuario'];


/*$objeto = 3;
$rol_id = $_SESSION['rol'];

$stmt =*/ 

?>
<main>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="box">
        
        <div class="box-body">
          <!--LLamar al formulario aqui-->
          <form method="POST">
            <div class="contenedor-cs">
              <div class = "tam-logo">
                <img src="vista/dist/img/logo.png" alt="Logo fundacion AMITIGRA">
              </div>
              <br>
              <p class="text-center">Creación de copia de seguridad de la Base de Datos - Fundación AMITIGRA</p>
              <br>
              <input class="buttom-center" type="password" name="password" placeholder="ingrese su contrasena">
              <p class="text-center-msg"><i class="fa fa-warning"></i> Por seguridad es necesario que ingrese su contraseña.</p>
              <button id ="boton" name="boton" values="btn1" class = "buttom-center btn btn-success">Crear copia de seguridad</button>
              <p class="text-center">Es recomendable realizar una copia de seguridad.</p>
              <p class="text-center-msg">La copia se realiza automáticamente <a href="infoBackup">saber más</a></p>
                
            </div>

              <?php
                include_once('./controlador/ctr.backup.php');

                $CopiaSeguridad = new CopiaSeguridad();
                $CopiaSeguridad->ctrCopiaSeguridad();
          
              ?>
                    
          </form>
          <!--Fin llamado formulario-->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  </main>