  <?php
  include_once("./modelo/conexionbd.php");
  $id_objeto = 6;
  $id_usuario = $_SESSION['id'];
  global $columna;
  //$rol = $_SESSION['mi_rol'];
  $rol_id = $_SESSION['rol'];
  $stmt = $conn->prepare("SELECT fecha_ult_conexion, fecha_vencimiento, fecha_mod_contrasena, rol_id
                          FROM tbl_usuarios
                          INNER JOIN tbl_roles
                          ON tbl_usuarios.rol_id = tbl_roles.id_rol 
                          WHERE tbl_roles.rol = ? AND id_usuario = ?");
  $stmt->bind_Param("si",$rol_id, $id_usuario);
  $stmt->execute();
  $stmt->bind_Result($fecha_ult_conexion, $fecha_vencimiento, $fecha_mod_contrasena, $id_rol);

  if($stmt->affected_rows){

    $existe = $stmt->fetch();
  while($stmt->fetch()){
    $mi_rol = $id_rol;
    $fecha_conexion = $fecha_ult_conexion;
  }

  if($existe){

  $stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
  WHERE rol_id = '$id_rol' AND objeto_id = '$id_objeto'");
  $columna = $stmt->fetch_assoc();

  ?>
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1>Inicio<small> Fundacion Amitigra</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
      </ol>
      <br>
    </section>
    
    <section class="content">
      <div class="row">
        <?php if ($_SESSION["rol"] === "administrador" OR $_SESSION["rol"] === "ADMINISTRADOR" OR $_SESSION["rol"] === "admin"){ ?>

          <?php $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);
          ?>

          <?php $reservaciones = "SELECT COUNT(*) reserva FROM tbl_detalle_reservacion";
          $result2 = mysqli_query($conn, $reservaciones);
          $fila2 = mysqli_fetch_assoc($result2);
          ?>

          <?php $boleteria = "SELECT COUNT(*) boleto FROM tbl_boletos_detalle";
          $result3 = mysqli_query($conn, $boleteria);
          $fila3 = mysqli_fetch_assoc($result3);
          ?>

          <?php $roles = "SELECT COUNT(*) roles FROM tbl_roles";
          $result4 = mysqli_query($conn, $roles);
          $fila4 = mysqli_fetch_assoc($result4);
          ?>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reservacion hotel</span>
                <span class="info-box-number"><strong>Total: </strong><?php echo $fila2['reserva'];?><br></span>
              </div>
            </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Reservación camping</span>
                <span class="info-box-number"><strong>Total: </strong><?php //echo $fila4['roles'];?></span>
              </div>
            </div>
          </div>
            
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-ticket"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Boleteria</span>
                <span class="info-box-number"><strong>Total: </strong><?php echo $fila3['boleto'];?></span>
              </div>
            </div>
          </div>
            
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <?php $visible = false;?>
              <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Usuarios registrados</span>
                <span class="info-box-number"><strong>Total: </strong><?php echo $fila['total'];?></span>
              </div>
            </div>
          </div>
        <?php }?>
      </div>
      
      <?php
      include_once "./modelo/conexionbd.php";
      
      $query = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

      $resultado = mysqli_query($conn,$query);

      while($imagen = mysqli_fetch_assoc($resultado)):?>

        <div class="row">
          <div class="col-md-4">
            <div class="box box-widget widget-user-2">
              <div class="widget-user-header bg-green">
                <div class="widget-user-image">
                  <img class="img-circle" src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" alt="User Avatar">
                </div>
                <h3 class="widget-user-username"> <strong>Hola: </strong><span><?php echo ucwords($_SESSION['usuario']);?></span></h3>
                <h5 class="widget-user-desc">Información sobre tu actividad en la cuenta</h5>
              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a><strong>Último acceso:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $conexion = strftime("%d/%b/%g. hr %I:%M %p", strtotime($fecha_ult_conexion)); echo $conexion;?></span></a></li>
                  <li><a><strong>Últ. cambio contraseña:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $modificado = strftime("%d/%b/%g. hr %I:%M %p", strtotime($fecha_mod_contrasena)); echo $modificado;?></span></a></li>
                  <li><a><strong>Próx. cambio contraseña:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $vencimiento = strftime("%d/%b/%g. hr %I:%M %p", strtotime($fecha_vencimiento)); echo $vencimiento;?></span></a></li>  
                </ul>
              </div>
            </div>

            <?php

                include "./modelo/conexionbd.php";

                $solicitudes = "SELECT COUNT(*) solicitud FROM tbl_solicitudes;";
                $resultadoSoli = mysqli_query($conn, $solicitudes);
                
                $solis = mysqli_fetch_assoc($resultadoSoli);

                $solicitudes2 = "SELECT COUNT(estatus_solicitud) estatus FROM tbl_solicitudes WHERE estatus_solicitud = 1;";
                $resultadoSoli2 = mysqli_query($conn, $solicitudes2);
                
                $solis2 = mysqli_fetch_assoc($resultadoSoli2);

                $solicitudes3 = "SELECT COUNT(estatus_solicitud) estatus FROM tbl_solicitudes WHERE estatus_solicitud = 2;";
                $resultadoSoli3 = mysqli_query($conn, $solicitudes3);
                
                $solis3 = mysqli_fetch_assoc($resultadoSoli3);

                $solicitudes4 = "SELECT COUNT(estatus_solicitud) estatus FROM tbl_solicitudes WHERE estatus_solicitud = 3;";
                $resultadoSoli4 = mysqli_query($conn, $solicitudes4);
                
                $solis4 = mysqli_fetch_assoc($resultadoSoli4);
            ?>

            <script type="text/javascript">
            function informacion(){

            }

            setTimeout(informacion,1000);
            </script>

            <!-- INICIO INFORMACION DE SOLICITUDES -->
            <?php if($_SESSION["rol"] === "administrador"):?>
            <div class="box box-primary">
              <div class="box-body box-profile">
                <!-- <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture"> -->

                
                <h3 class="profile-username text-center"><strong><i class="fa fa-edit"></i> Solicitudes</strong></h3>
                <p class="text-muted text-center">Resumen solicitudes</p>

                <ul class="list-group list-group-unbordered">
                  
                  <li class="list-group-item">
                  <label for="">Ultimas solicitudes:</label>
                  <table class="display table table-hover table-condensed">
                    <thead>
                    <tr>
                      <th>Nombre cliente</th>
                      <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                  <?php
                  include "./modelo/conexionbd.php";

                  $mostrar = 2;
                  $modo = "DESC";

                  $solicitudes = "SELECT id_solicitud ,tbl_clientes.nombre_completo AS cliente, tbl_estatus_solicitud.estatus AS estado FROM tbl_solicitudes
                                  INNER JOIN tbl_clientes
                                  ON tbl_solicitudes.cliente_id = tbl_clientes.id_cliente
                                  INNER JOIN tbl_estatus_solicitud
                                  ON tbl_solicitudes.estatus_solicitud = tbl_estatus_solicitud.id_estatus_solicitud
                                  ORDER BY cliente_id $modo limit $mostrar;";
                  $resultadoSoli = mysqli_query($conn, $solicitudes);
         
                  $vertbl = array();
                  while($ver = $resultadoSoli->fetch_assoc()){

											$traer = $ver["id_solicitud"];
											$evento = array(
												'cliente' => $ver['cliente'],
                        'estado' => $ver['estado']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) {

                    foreach ($lista_articulo as $evento) { ?>
												<tr>
													<td> <?php echo $evento['cliente']; ?></td>
                          <td> <?php echo $evento['estado']; ?></td>
												<?php }}?>
                      </tr>
                    </tbody>
                  </table>

                  </li>
                  <li class="list-group-item">
                    <b>En proceso:</b> <a class="pull-right label label-warning"><?php echo $solis2["estatus"];?></a><br>
                    <!-- <span class="label label-success">Shipped</span> -->
                    <b>Aprobadas:</b> <a class="pull-right label label-success"><?php echo $solis3["estatus"];?></a><br>
                    <b>Canceladas:</b> <a class="pull-right label label-danger"><?php echo $solis4["estatus"];?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Total solicitudes:</b> <a class="pull-right label label-primary"><?php echo $solis["solicitud"];?></a>
                  </li>
                </ul>

                <a href="solicitudes" class="btn btn-block"><b>Ir a solicitudes</b></a>
              </div>
              <!-- FIN IFORMACION DE SOLICITUDES -->
            </div>
            <?php endif;?>

          </div>
          <!-- FIN INFORMACION ULTIMO ACCESO -->
          
          <div class="col-md-8">
            <div class="box box-solid">
              <div class="box-body">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="https://i1.wp.com/www.marcahonduras.hn/wp-content/uploads/2020/07/La-Tigra-1.jpg?resize=1536%2C864&ssl=1" alt="First slide">

                      <div class="carousel-caption">
                        Parque Nacional la Tigra
                      </div>
                    </div>
                    <div class="item">
                      <img src="https://www.toptravelsights.com/wp-content/uploads/2020/12/Jungle-path-in-La-Tigra-National-Park-1024x576.jpg" alt="Second slide">

                      <div class="carousel-caption">
                        Senderos
                      </div>
                    </div>
                    <div class="item">
                      <img src="https://i1.wp.com/www.marcahonduras.hn/wp-content/uploads/2020/07/La-Tigra-1.jpg?resize=1536%2C864&ssl=1" alt="Third slide">

                      <div class="carousel-caption">
                        Vista desde las montañas
                      </div>
                    </div>
                  </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- INICIO RELOJ -->
          <div class="row">
              <div class="col-md-3">
                <div class="box">
                  <div class="box-body">
                    <?php }}?>
                    <div class="clockdate-wrapper">
                      <div id="clock"></div>
                      <div id="date"></div>
                    </div>
                  </div>
                </div>    
              </div>
          </div>
          <!-- FIN RELOJ -->
    </section>
  </div>