<?php
include_once("./modelo/conexionbd.php");
$id_objeto = 6;
global $columna;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON
                        tbl_usuarios.rol_id = tbl_roles.id_rol 
                        WHERE tbl_roles.rol = ?");
$stmt->bind_Param("i",$rol_id);
$stmt->execute();
$stmt->bind_Result($id_rol);

if($stmt->affected_rows){

  $existe = $stmt->fetch();
while($stmt->fetch()){
  $mi_rol = $id_rol;
}

if($existe){



$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,rol_id,objeto_id FROM tbl_permisos
WHERE rol_id = '$mi_rol' AND objeto_id = '$id_objeto'");
$columna = $stmt->fetch_assoc();

?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Accesos directos
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
      </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <!-- INICIO DE LA INFORMACION DEL USUARIO-->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                    <?php }}?>
                        <?php if ($columna["permiso_consulta"] == 0) {?><div class="col-lg-16">
                            <div class="small-box bg-red">
                                <div class="inner">
                                <p>Reservación hotel</p>
                                </div>
                                <div class="icon">
                                <i class=""></i>
                                </div>
                                <a href="hotel" class="small-box-footer">
                                Click para realizar reservación <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><?php }?>

                        <?php if($columna["permiso_consulta"] == 0) {?><div class="col-lg-16">
                            <div class="small-box bg-green">
                                <div class="inner">

                                <p>Reservación camping</p>
                                </div>
                                <div class="icon">
                                <i class=""></i>
                                </div>
                                <a href="camping" class="small-box-footer">
                                Click para realizar reservación <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><?php }?>

                        <?php if($columna["permiso_consulta"] == 0) {?><div class="col-lg-16">
                            <div class="small-box bg-blue">
                                <div class="inner">

                                <p>Solicitudes</p>
                                </div>
                                <div class="icon">
                                <i class=""></i>
                                </div>
                                <a href="solicitudes" class="small-box-footer">
                                Click para realizar solicitud <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><?php }?>

                        <?php if($columna["permiso_consulta"] == 1) {?><div class="col-lg-16">
                            <div class="small-box bg-orange">
                                <div class="inner">

                                <p>Inventario</p>
                                </div>
                                <div class="icon">
                                <i class=""></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                Click aqui para ir a inventario <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><?php }?>

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

                        <?php if($columna["permiso_consulta"] == 1) {?><div class="col-lg-16">
                            <div class="small-box bg-aqua">
                                <div class="inner">

                                <p>Panel de administración</p>
                                </div>
                                <div class="icon">
                                <i class=""></i>
                                </div>
                                <a href="panel" class="small-box-footer">
                                Click para ir al panel <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><?php }?>
                        
                    </div>
                </div>
                <!--FIN DE LA INFORMACION DEL USUARIO-->
            </div>    
            
            <!--INICIO DEL CARROUSEL-->
            <div class="col-md-9">
                    <div class="tab-content">
                        <div class="" id="settings">
                            <form method="POST" class="form-horizontal">
                                <!--AQUI TODO LO DEL CARRUSEL-->
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                    <h3 class="box-title">Inicio FUNDACION AMITIGRA</h3>
                                    </div>
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
                                                FUNDACION AMITIGRA
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img src="https://www.radiohouse.hn/wp-content/uploads/2019/10/Portada-La-Tigra.-990x660.jpg" alt="Second slide">

                                                <div class="carousel-caption">
                                                Second Slide
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img src="https://www.hondurastips.hn/wp-content/uploads/2020/09/0000.jpg" alt="Third slide">

                                                <div class="carousel-caption">
                                                Third Slide
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
                                </div>
                            <!--FIN DE TODO DEL CARRUSEL-->
                            </form>
                        </div>
                    </div>
              
            </div>
            <!--FIN DEL CARROUSEL-->
        </div>
    </section>
</div>