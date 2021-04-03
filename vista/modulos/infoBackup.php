<?php
require "./modelo/conexionbd.php";

//$id_objeto = ;

  $arreglo = ['NOMBRE_DATABASE','PUERTO_DATABASE','NOMBRE_SISTEMA','NOMBRE_ORGANIZACION','PUERTO_CORREO',
              'CORREO_SISTEMA','FOTO_ORGANIZACION','USUARIO_ADMIN','USUARIO_CONTRASENA','HOST_HOSPEDADOR','MENSAJE_CORREO'];

  //TRAE EL CORREO ELECTRONICO DE LA ORGANIZACION
  $correo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[5]';");
  $resultCorreo = mysqli_query($conn, $correo);
  $PCorreo = mysqli_fetch_assoc($resultCorreo);

  //TRAE EL PUERTO DEL CORREO DE LA ORGANIZACION
  $puerto = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[4]';");
  $resultPuerto = mysqli_query($conn, $puerto);
  $PPuerto = mysqli_fetch_assoc($resultPuerto);

  //TRAE EL MENSAJE QUE SE ENVIA POR CORREO ELECTRONICO
  $mensajeCorreo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[10]';");
  $resultMensaje = mysqli_query($conn, $mensajeCorreo);
  $PMensaje = mysqli_fetch_assoc($resultMensaje);
  


  //TRAE EL NOMBRE DEL HOST DE LA BASE DE DATOS
  $host = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[9]';");
  $resultHost = mysqli_query($conn, $host);
  $PHost = mysqli_fetch_assoc($resultHost);

  //TRAE EL PUERTO DE LA BASE DE DATOS
  $puertobd = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[1]';");
  $resultPuertobd = mysqli_query($conn, $puertobd);
  $PPuertoBD = mysqli_fetch_assoc($resultPuertobd);

  //TRAE EL NOMBRE DE LA BASE DE DATOS
  $nombreBD = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[0]';");
  $resultNombreBD = mysqli_query($conn, $nombreBD);
  $PNombreBD = mysqli_fetch_assoc($resultNombreBD);


  //TRAE EL NOMBRE DE LA ORGANIZACION
  $NombreOrganizacion = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[3]';");
  $resultOrganizacion = mysqli_query($conn, $NombreOrganizacion);
  $PNOrganizacion = mysqli_fetch_assoc($resultOrganizacion);

  //TRAE EL NOMBRE DEL SISTEMA
  $NSistema = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[2]';");
  $resultNSistema = mysqli_query($conn, $NSistema);
  $PNSistema = mysqli_fetch_assoc($resultNSistema);

  //TRAE EL NOMBRE DEL ADMINISTRADOR
  $administrador = ("SELECT valor FROM tbl_parametros WHERE parametro = '$arreglo[7]';");
  $resultAdmin = mysqli_query($conn, $administrador);
  $PNAdmin = mysqli_fetch_assoc($resultAdmin);
?>
<div class="content-wrapper">

    <section class="content-header">
      <h1>
        Configuracion<small> sistema</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="panel"><i class="fa fa-cogs"></i> Panel de control</a></li>
        <li class="active"><i class="fa fa-cog"></i> Otra configuración</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://ngnoticias.com/wp-content/uploads/2020/07/correo-electronico.png" alt="User Avatar">
              </div>
            
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Correo electronico</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#"><strong>Correo: </strong><span class="pull-right"><?php echo $PCorreo['valor'];?></span></a></li>
                <li><a><strong>Puerto: </strong><span class="pull-right"><?php echo $PPuerto['valor'];?></span></a></li>
                <!-- <li><a><strong>Mensaje correo: <br></strong><span class="pull-right"><?php //echo $PMensaje['valor'];?></span></a></li><br> -->
                <!-- <li><a><strong>Hola mundo</strong> <span class="pull-right">842</span></a></li> -->
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://cdn.pixabay.com/photo/2020/03/17/17/46/database-4941338_960_720.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Base de datos</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Host hospedador:</strong><span class="pull-right"><?php echo $PHost['valor'];?></span></a></li>
                <li><a><strong>Puerto:</strong><span class="pull-right"><?php echo $PPuertoBD['valor'];?></span></a></li>
                <li><a><strong>Nombre base de datos: </strong><span class="pull-right"><?php echo $PNombreBD['valor'];?></span></a></li>
                <li><a><strong>Estado conexon: </strong><span class="pull-right"><i class="fa fa-check has-success" for="inputSuccess"></i><?php if($conn->ping()){ echo "conectado"; } else { $fallo = ("error de conexion %s\n" + $mysqli->error); echo $fallo;}?></span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image">
                <img class="img-circle" src="https://cdn.pixabay.com/photo/2016/10/19/03/59/socialmedia-1752079_960_720.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Ajustes</h3>
              <h5 class="widget-user-desc"><strong>Sistema</strong></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Nombre organizacion: </strong><span class="pull-right"><?php echo $PNOrganizacion['valor'];?></span></a></li>
                <li><a><strong>Nombre sistema: </strong> <span class="pull-right"><?php echo $PNSistema['valor'];?></span></a></li>
                <li><a><strong>Usuario administrador</strong><span class="pull-right"><?php echo $PNAdmin['valor'];?></span></a></li>
                <!-- <li><a><strong>Followers</strong><span class="pull-right"><?php //echo $parametro['valor'];?></span></a></li> -->
              </ul>
            </div>
          </div>
        
        </div>

      </div>
    

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Parametros</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"></button>
          </div>
        </div>
        <!-- /.box-header -->


        <div class="box">

          <div class="box-body">
            <!--LLamar al formulario aqui-->
            <div class="row">
              <div class="col-md-12">

                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento parámetros</div>
                  </div> <!-- /panel-heading -->
                  <div class="panel-body">
                    <!-- /div-action -->
                    <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    
                    <button class="btn btn-default btnCrearParam glyphicon glyphicon-plus-sign" >Agregar Parametro</button>
                    </div>

                    <table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
                      <thead>
                        <tr>

                          <th>Parámetro</th>
                          <th>Valor</th>
                          <th>Fecha creación</th>
                          <th>Fecha modificaciÓn</th>
                          <th>Acciones</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        try {


                          $sql = "SELECT id_parametro,parametro,valor,fecha_creacion,fecha_modificacion
                                                                FROM tbl_parametros  where estado_eliminado=1";
                          $resultado = $conn->query($sql);
                        } catch (\Exception $e) {
                          echo $e->getMessage();
                        }

                        $vertbl = array();
                        while ($eventos = $resultado->fetch_assoc()) {

                          $traer = $eventos['parametro'];
                          $evento = array(
                            'nombre_parametro' => $eventos['parametro'],
                            'valor' => $eventos['valor'],
                            'fecha_creacion' => $eventos['fecha_creacion'],
                                                    'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                    'id_parametro' => $eventos['id_parametro']

                          );
                          $vertbl[$traer][] =  $evento;
                        }
                        foreach ($vertbl as $dia => $lista_articulo) { ?>


                          <?php foreach ($lista_articulo as $evento) { ?>
                            <?php	//echo $evento['nombre_arti']
                            ?>
                            <tr>
                              <td> <?php echo $evento['nombre_parametro']; ?></td>
                              <td> <?php echo $evento['valor']; ?></td>
                                                        <td> <?php echo $evento['fecha_creacion']; ?></td>
                              <td> <?php echo $evento['fecha_modificacion']; ?></td>
                              <td>
                                <button class="btn btn-warning btnEditarParam glyphicon glyphicon-pencil"  data-idparametro="<?= $evento['id_parametro'] ?>" data-nombreparametro="<?= $evento['nombre_parametro']?>" data-valor="<?= $evento['valor'] ?>"></button>

                                <button class="btn btn-danger btnEliminarParam glyphicon glyphicon-remove" data-idparametro="<?php echo $evento['id_parametro'] ?>"></button>
                              </td>
                            <?php  } ?>
                          <?php  } ?>
                            </tr>
                      </tbody>
                      <!--<?php //}
                        ?>-->

                    </table>
                    <!-- /table -->

                  </div> <!-- /panel-body -->
                </div> <!-- /panel -->
              </div> <!-- /col-md-12 -->
              <?php $conn->close(); ?>
            </div> <!-- /row -->


          </div>
          <!-- /.box-body -->
	
          <div class="modal fade" id="modalEditarParam" tabindex="-1"
          role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex justify-content-between">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i aria-hidden="true">&times;</i>
                    </button>
                    <h3 class="modal-title" id="exampleModalLabel">Actualizar parametro</h3>
                  </div>
                </div>
                <div class="modal-body">
                  <form name="formEditarParametro">
                    <div class="ingreso-producto form-group">
                      <div class="campos">
                        <label for="">Parametro: </label>
                        <input id="Param" class="form-control modal-roles secundary text-uppercase" type="text" name="" placeholde="Escriba el Paramenttro" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" />

                      </div>
                      <div class="campos form-group">
                        <label for="">valor parametro: </label>
                        <input id="valor" class="form-control  modal-roles  secundary text-uppercase" type="tel" name="" placeholde="Escriba el producto" required />

                      </div>
                      <input type="hidden" name="" id="id_usuario" value="<?= $_SESSION['id'] ?>">
                      <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                    </div>
                    
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar parametro</button>
                </div>
              </div>
            </div>
          </div>
          <!-- modal para crear un prametro -->
          <div class="modal fade" id="modalRegistrarParam" tabindex="-1"
          role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <div class="d-flex justify-content-between">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i aria-hidden="true">&times;</i>
                    </button>
                    <h3 class="modal-title" id="exampleModalLabel">Registrar Parametros</h3>
                  </div>
                </div>
                <div class="modal-body">
                <section class="">
                            <form method="POST" id="formParametros">
                              <div class="ingreso-producto form-group">
                                <div class="campos" type="hidden">
                                  <label for=""> </label>
                                    <input autocomplete="off" class="form-control secundary" type="hidden" name="idParametro" value="0" disabled>

                                </div>
    
                                <div class="campos">
                                  <label for="">Nombre del Parametro </label>
                                    <input id="nombrePara" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreParametro" placeholde="Escriba el parametro" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" />

                                    </div>
                                <div class="campos ">
                                  <label for=""> Valor </label>
                                    <input id="valorParam" class="form-control  modal-roles secundary text-uppercase" type="tel" placeholde="Describa el parametro" required onkeypress="return soloLetras(event)"onkeyup="javascript:this.value=this.value.toUpperCase()" />

                                  </div>
                  <input type="hidden" name="usuario_actual" id="id_usuario" value="<?= $_SESSION['id'] ?>">
                                  <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                                  </div>
                  <!-- <input type="submit" name="ingresarProducto" class="btn" value="Ingresar Parametro" />
                  </div> -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button id="btnEditarBD"type="submit" class=" btn btn-primary">Registrar Parametro</button>
                </div>
                            </form>
                        <?php 
                        if(isset($_GET['msg'])){
                          $mensaje = $_GET['msg'];
                          print_r($mensaje);
                  
                      }

                            ?>
                            </section>
                
              </div>
            </div>
          </div>
          
		    </div>


        
        <!-- /.box-body -->
        <div class="box-footer">
          Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
          the plugin.
        </div>
      </div>
      <!-- /.box -->



    </section>
    
    <!-- /.content -->
  </div>