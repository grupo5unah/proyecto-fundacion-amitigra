<?php
  require "./modelo/conexionbd.php";

  $id_objeto = 5;
  $id_objeto2 = 48;

  global $mi_rol;
  global $columna;
  global $mi_rol;
  $rol_id = $_SESSION['rol'];
  $stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                          INNER JOIN tbl_roles
                          ON tbl_usuarios.rol_id = tbl_roles.id_rol 
                          WHERE tbl_roles.rol = ?");
  $stmt->bind_Param("s",$rol_id);
  $stmt->execute();
  $stmt->bind_Result($id_rol);

  if($stmt->affected_rows){

    $existe = $stmt->fetch();
  while($stmt->fetch()){
    $mi_rol = $id_rol;
  }

  if($existe){

    $stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,rol_id,objeto_id FROM tbl_permisos
    WHERE rol_id = '$id_rol' AND objeto_id = '$id_objeto';");
    $columna = $stmt->fetch_assoc();

    $stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,rol_id,objeto_id FROM tbl_permisos
    WHERE rol_id = '$id_rol' AND objeto_id = '$id_objeto2';");
    $columna2 = $stmt->fetch_assoc();

?>
<aside class="main-sidebar">

  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php
        $query = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

        $resultado = mysqli_query($conn,$query);
        
        while($imagen = mysqli_fetch_assoc($resultado)):
        ?>
        <img src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo ucwords($usuario);?></p>
        <!--Aqui agregar variable de sesion para que muestre el cargo-->
        <a href="perfil"><i class="text-success"></i>Cargo: <?php echo $rol_id;?></a>
        <!--Aqui ira el cargo del usuario-->
      </div>
    </div>

    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">Menú de Navegación</li>
        
        <!--ROL DE ADMINISTRACION-->
        <?php if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador"){?>
          
          <!--Inicio SOLICITUDES-->
          <!-- MUESTRA SOLICITUDES SOLO A ADMINISTRACION -->
          <?php if ($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "asistente") {?>
          <?php if($columna["permiso_consulta"] == 1){?>
            <li class="">
              <a href="solicitudes">
                <i class="fa fa-files-o"></i>
                <span>Solicitudes</span>
              </a>
            </li>
          <?php }}?>
        <!--Fin SOLICITUDES-->

          <!--Inicio RESERVACIONES-->
          <li class="treeview" name="admin">
          <!-- MUESTRA RESERVACIONES SOLO PARA ADMINISTRADOR Y COLABORADOR -->
            <?php if ($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "asistente") {?>
            <?php if($columna["permiso_consulta"] == 1){?>
              <a href="#">
                <i class="fa fa-calendar-check-o"></i>
                <span>Reservaciones</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="hotel"><i class=""></i> Hotel y Camping</a></li>
                <li><a href="senderos"><i class=""></i> Senderos</a></li>
              </ul>
          </li>
            <?php }}?>
        <!--Fin RESERVACIONES-->

        <!--Inicio INVENTARIO-->
        <li class="treeview">
        <!-- MUESTRA INVENTATIO SOLO A ADMINISTRACION -->
        <?php if ($_SESSION["rol"] === "administrador") {?>
        <?php if($columna['permiso_consulta'] == 1){?>
          <a href="#">
            <i class="fa fa-pencil-square-o"></i>
            <span>Inventario</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="movimientos"><i class=""></i>Movimientos</a></li>
            <li><a href="existencia"><i class=""></i> Inventario General</a></li>
            <!-- <li><a href="ordenes"><i class=""></i>Ordenes</a></li> -->
          </ul>
        </li>
        <?php
        }}?>
        <!--Final INVENTARIO-->

        <!--Inicio panel de ADMINISTRACION-->
        <!-- MUESTRA EL AREA DE CONFIGURACION DEL SISTEMA SOLO A ADMINISTRACION -->
        <li name="admin" id= "admin" class="treeview">
        <?php if ($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador") {?>
          <?php if($columna["permiso_consulta"] == 1){?>
          <a href="#">
            <i class="fa fa-gear"></i> <span>Panel de control</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class=""></i> Administración
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="panel"><i class=""></i>Administración <br> sistema</a></li>
                <li><a href="bitacora"><i class=""></i> bitácora </a></li>
                <li><a href="backup"><i class=""></i> copia de seguridad<br> Base de datos </a></li>
              </ul>
            </li>
            
            <li class="treeview">
              <a href="#"><i class=""></i> Mantenimiento
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="mantenimiento"><i class=""></i> Usuario</a></li>
                <li><a href="mantroles"><i class=""></i> Roles</a></li>
                <li><a href="mantpermisos"><i class=""></i> Permisos</a></li>
                <li><a href="mantpreguntas"><i class=""></i> Preguntas</a></li>
                <li><a href="mantparametros"><i class=""></i> Parámetros</a></li>
                <li><a href="mantObjetos"><i class=""></i> Objetos</a></li>
                <li><a href="mantTipoBoletos"><i class=""></i>Tipo y Precio <br> de Boletos</a></li>
                <li><a href="mantNacionalidad"><i class=""></i>Tipos de <br> Nacionalidad</a></li>
                <li><a href="mantHabiServ"><i class=""></i> Habitación Servicio</a></li>
                <li><a href="mantEstados"><i class=""></i> Estados</a></li>
                <li ><a href="mantReservaciones"><i class=""></i> Mantenimiento <br> Reservaciones</a></li>
                <li ><a href="mantLocalidadesyTipoProducto"><i class=""></i> localidad y <br> Tipo Producto</a></li>
                <li ><a href="mantProducto"><i class=""></i> Producto</a></li>
                <li><a href="mantTipoMovimiento"><i class=""></i>Tipo Movimiento</a></li>
                <li><a href="mantTipoBoletos"><i class=""></i> Tipo de Boletos</a></li>
                <li><a href="mantNacionalidad"><i class=""></i> Tipo de Nacionalidad</a></li>
                <li><a href="mantTipoSolicitudes"><i class=""></i>Tipo de Solicitudes</a></li>
                <li><a href="mantClientes"><i class=""></i> Clientes</a></li>
                <li><a href="mantHabiServ"><i class=""></i> Habitación Servicio</a></li>
                <li><a href="mantEstadosSolicitud"><i class=""></i> Estados de Solicitud</a></li>
              </ul>          
            </li>

            <li class="treeview">
              <a href="#"><i class=""></i> Seguridad
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="mantpermisos"><i class=""></i> Permiso acceso <br> al sistema</a></li>
                <li><a href="parametrosSistema"><i class=""></i> Parámetros<br>Sistema/Seguridad</a></li>
                <li><a href="parametrosSeguridad"><i class=""></i> Otros Parámetros</a></li>
                <li><a href="mantroles"><i class=""></i> Roles</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <!--Final ADMINISTRACION-->

        <?php }}?>
        <?php }?>
        <!-- <?php }}?> -->


  </section>
  <!-- /.sidebar -->
</aside>