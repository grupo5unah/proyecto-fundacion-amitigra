<?php
include_once("./modelo/conexionbd.php");
$id_objeto = 6;
$id_usuario = $_SESSION['id'];
global $columna;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT fecha_ult_conexion, fecha_vencimiento, rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON tbl_usuarios.rol_id = tbl_roles.id_rol 
                        WHERE tbl_roles.rol = ? AND id_usuario = ?");
$stmt->bind_Param("si",$rol_id, $id_usuario);
$stmt->execute();
$stmt->bind_Result($fecha_ult_conexion, $fecha_vencimiento, $id_rol);

if($stmt->affected_rows){

  $existe = $stmt->fetch();
while($stmt->fetch()){
  $mi_rol = $id_rol;
  $fecha_conexion = $fecha_ult_conexion;
}

if($existe){



$stmt = $conn->query("SELECT permiso_consulta,rol_id,objeto_id FROM tbl_permisos
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
      <?php if ($_SESSION['rol'] === 'administrador'){ ?>

        <?php $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);?>


      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">CPU Traffic</span>
            <span class="info-box-number">90<small>%</small></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
        
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Likes</span>
            <span class="info-box-number">41,410</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sales</span>
            <span class="info-box-number">760</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
        
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <?php $visible = false;?>
          <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Usuarios registrados</span>
            <span class="info-box-number"><?php echo $fila['total'];?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <?php }?>
    </div>
      <!-- /.row -->
    
      <?php
    include_once "./modelo/conexionbd.php";
    
    $query = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

    $resultado = mysqli_query($conn,$query);

    while($imagen = mysqli_fetch_assoc($resultado)):?>


      <div class="row">
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <div class="widget-user-image">
                <img class="img-circle" src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"> <strong>Hola: </strong><span><?php echo ucwords($_SESSION['usuario']);?></span></h3>
              <h5 class="widget-user-desc">Informacion sobre tu actividad en la cuenta</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a><strong>Ultimo acceso:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $conexion = strftime("%d de %b de %G. A las %I:%M %p", strtotime($fecha_ult_conexion)); echo $conexion;?></span></a></li>
                <li><a><strong>Ult. cambio de contrasena:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $vencimiento = strftime("%d de %b de %G. A las %I:%M %p", strtotime($fecha_vencimiento)); echo $vencimiento;?></span></a></li>
                <li><a><strong>Prox. cambio de contrasena:</strong><span class="pull-right"><?php setlocale(LC_ALL,"es_ES.UTF-8"); $vencimiento = strftime("%d de %b de %G. A las %I:%M %p", strtotime($fecha_vencimiento)); echo $vencimiento;?></span></a></li>  
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    
        <!-- FIN INFORMACION ULTIMO ACCESO -->
        
        <div class="col-md-8">
              <div class="box box-solid">
                <!-- /.box-header -->
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
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        
        <!-- INICIO RELOJ -->
          <div class="row">
            <div class="col-md-3">
                <!-- INICIO DE LA INFORMACION DEL USUARIO-->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    <?php }}?>

                              <div class="clockdate-wrapper">
                                <div id="clock"></div>
                                <div id="date"></div>
                              </div>

                            <script>
                            function startTime() {
                                var today = new Date();
                                var hr = today.getHours();
                                var min = today.getMinutes();
                                var sec = today.getSeconds();
                                ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
                                hr = (hr == 0) ? 12 : hr;
                                hr = (hr > 12) ? hr - 12 : hr;
                                //Add a zero in front of numbers<10
                                hr = checkTime(hr);
                                min = checkTime(min);
                                sec = checkTime(sec);
                                document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec + " " + ap;
                                var time = setTimeout(function(){ startTime() }, 500);
                            }
                            function checkTime(i) {
                                if (i < 10) {
                                    i = "0" + i;
                                }
                                return i;
                            }
                            </script>

                        
                </div>
                <!--FIN DE LA INFORMACION DEL USUARIO-->
            </div>    
          
          </div>
        <!-- FIN RELOJ -->

        <!--INICIO DEL CARROUSEL-->
          
        <!--FIN DEL CARROUSEL-->

    </section>
</div>