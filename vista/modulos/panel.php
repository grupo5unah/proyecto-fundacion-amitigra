<div class="content-wrapper">

<section class="content-header">
<h1>Panel <small>administración</small></h1>      
<ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active"> <i class="fa fa-cogs"></i> Panel de administración</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!--CAJAS INICIO PRIMERA LINEA-->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <?php
          include_once("./modelo/conexionbd.php");
            //TOTAL DE USUARIOS
            $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);
            
            //TOTAL ACTIVIDADES REALIZADAS
            $actividades = "SELECT COUNT(*) total FROM tbl_bitacora";
            $result = mysqli_query($conn, $actividades);
            $total = mysqli_fetch_assoc($result);
            
            //TOTAL ROLES
            $rol_admin = "SELECT COUNT(*) admon FROM tbl_usuarios
                      WHERE rol_id = 2";
            $verificar = mysqli_query($conn, $rol_admin);
            $total_roles = mysqli_fetch_assoc($verificar);

            $rol_sec = "SELECT COUNT(*) sec FROM tbl_usuarios
                      WHERE rol_id = 3";
            $verificar_sec = mysqli_query($conn, $rol_sec);
            $total_sec = mysqli_fetch_assoc($verificar_sec);

            $preguntas = "SELECT COUNT(*) preguntas FROM tbl_preguntas";
            $verificar_preguntas = mysqli_query($conn,$preguntas);
            $total_preguntas = mysqli_fetch_assoc($verificar_preguntas);
          ?>     
          <div class="small-box bg-blue">
            <div class="inner">
            <h2><?php echo $fila['total'];?></h2>

              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="mantenimiento" class="small-box-footer">
              Click aquí para mantenimiento <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h2><?php echo $total['total'];?></h2>
              <p>actividades realizadas</p>
            </div>
            <div class="icon">
              <i class="fa fa-mouse-pointer"></i>
            </div>
            <a href="bitacora" class="small-box-footer">
              Click aquí para consultar la bitácora <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <p>ROLES</p>
              <p>Administracion: <?php echo $total_roles['admon'];?></p>
              <p>Asistentes: <?php echo $total_sec['sec'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="mantroles" class="small-box-footer">
              Click aquí para mantenimiento roles <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            
              <h2><?php echo $total_preguntas['preguntas'];?></h2>
              <p>Preguntas registradas</p>
            </div>
            <div class="icon">
              <i class="fa  fa-question"></i>
            </div>
            <a href="mantpreguntas" class="small-box-footer">
              Click aqui para consultar preguntas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    <!--CAJAS FINAL PRIMERA LINEA-->

    <!--CAJAS INICIO SEGUNDA LINEA-->
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->

          <?php
          include_once("./modelo/conexionbd.php");
            //TOTAL DE USUARIOS
            $registros = "SELECT COUNT(*) total FROM tbl_usuarios";
            $result = mysqli_query($conn, $registros);
            $fila = mysqli_fetch_assoc($result);
            
            //TOTAL ACTIVIDADES REALIZADAS
            $actividades = "SELECT COUNT(*) total FROM tbl_bitacora";
            $result = mysqli_query($conn, $actividades);
            $total = mysqli_fetch_assoc($result);
            
            //TOTAL ROLES
            $rol_admin = "SELECT COUNT(*) admon FROM tbl_usuarios
                      WHERE rol_id = 1";
            $verificar = mysqli_query($conn, $rol_admin);
            $total_roles = mysqli_fetch_assoc($verificar);

            $rol_sec = "SELECT COUNT(*) sec FROM tbl_usuarios
                      WHERE rol_id = 2";
            $verificar_sec = mysqli_query($conn, $rol_sec);
            $total_sec = mysqli_fetch_assoc($verificar_sec);
          ?>     
          <div class="small-box bg-aqua">
            <div class="inner">
            <h2><?php echo $fila['total'];?></h2>

              <p>Preguntas registradas</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-powerpoint-o"></i>
            </div>
            <a href="mantpreguntas" class="small-box-footer">
              Click aquí para preguntas <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h2><?php echo $total['total'];?></h2>
              <p>actividades realizadas</p>
            </div>
            <div class="icon">
              <i class="fa  fa-ban"></i>
            </div>
            <a href="mantpermisos" class="small-box-footer">
              Click aquí para consultar permisos <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <p>ROLES</p>
              <p>Administradores(as): <?php echo $total_roles['admon'];?></p>
              <p>Asistentes: <?php echo $total_sec['sec'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="mantroles" class="small-box-footer">
              Click aquí para mantenimiento roles <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
              <h4>65</h4>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    <!--CAJAS FINAL SEGUNDA LINEA-->

      <!--INICIO DE OTRA INFORMACION-->
      
        <!--FIN DE OTRA INFORMACION-->  
        
        <!--INICIO DE LA TABLA-->
        
        <!--FIN DE LA TABLA-->

      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>