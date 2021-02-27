<?php
include_once("./modelo/conexionbd.php");
$id_objeto = 6;
global $columna;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id, fecha_ult_conexion FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON tbl_usuarios.rol_id = tbl_roles.id_rol 
                        WHERE tbl_roles.rol = ?");
$stmt->bind_Param("s",$rol_id);
$stmt->execute();
$stmt->bind_Result($id_rol, $fecha_ult_conexion);

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
            <span class="info-box-text">New Members</span>
            <span class="info-box-number">2,000</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <?php }?>
    </div>
      <!-- /.row -->
    
        <!-- Profile Image -->
        <div class="row">
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-body box-profile">
              
              <p class="text-center"><span class="text-center">Bienvenido(a): </span><?php echo ucwords($_SESSION['usuario']);?></p>
              <br>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Ultimo acceso:</b> <a class="pull-right"><?php echo $fecha_conexion;?></a>
                </li>
                <li class="list-group-item">
                  <b>Ultimo cambio de contrasena:</b> <a class="pull-right"><?php echo $_SESSION['primer_ingreso'];?></a>
                </li>
                <li class="list-group-item">
                  <?php
                  date_default_timezone_set('America/Tegucigalpa');
                  $fecha = date('Y-m-d H:i:s',time());
                  
                  setcookie('fecha', $fecha, time()+31536000);
                  
                  if (isset($_COOKIE['fecha'])) {?>
                  <b>Motivo ultima salida:</b> <a class="pull-right"><?php $_COOKIE['fecha'];}?></a>
                </li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
        </div>

        <!-- /.col -->
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
        
          <div class="row">
            <div class="col-md-3">
                <!-- INICIO DE LA INFORMACION DEL USUARIO-->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    <?php }}?>


                            <div id="clockdate">
                              <div class="clockdate-wrapper">
                                <div id="clock"></div>
                                <div id="date"></div>
                              </div>
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

        <!--INICIO DEL CARROUSEL-->
          <div class="row">
            
          </div>
        <!--FIN DEL CARROUSEL-->

    </section>
</div>