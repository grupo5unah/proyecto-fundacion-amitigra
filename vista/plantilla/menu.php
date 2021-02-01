<?php
include_once("./modelo/conexion.php");
$id_objeto = 6;
//$rol = $_SESSION['mi_rol'];
$rol_id = $_SESSION['rol'];
$stmt = $conn->prepare("SELECT rol_id FROM tbl_usuarios
                        INNER JOIN tbl_roles
                        ON
                        tbl_usuarios.rol_id = tbl_roles.id_rol 
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

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta,id_rol,id_objeto FROM tbl_permisos
WHERE id_rol = '$mi_rol' AND id_objeto = '$id_objeto'");
$columna = $stmt->fetch_assoc();

?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="vista/dist/img/avatar5.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo ucwords($usuario);?></p>
        <!--Aqui agregar variable de sesion para que muestre el cargo-->
        <a href="perfil"><i class="text-success"></i>Cargo: <?php echo $rol_id;?></a>
        <!--Aqui ira el cargo del usuario-->
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
<?php }}?>   
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú de Navegación</li>
        <!--Pendiente-->
        
        <!--ROL DE ADMINISTRACION-->
        <?php if($_SESSION['rol'] == "administrador"){?>
          <!--Inicio SOLICITUDES-->
          <?php if ($columna["permiso_consulta"] == 1) {?><li class="">
          <a href="solicitudes">
            <i class="fa fa-files-o"></i>
            <span>Solicitudes</span>
          </a>
        </li><?php }?>
        <!--Fin SOLICITUDES-->

        <!--Inico REPORTES-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="reporteBitacora"><i class=""></i> Reporte Bitácora</a></li>
            <li><a href="reporteProducto"><i class=""></i> Reporte Producto</a></li>
            <li><a href="pruebaTab"><i class=""></i> Prueba TAB</a></li>
            <li><a href="senderos"><i class=""></i> Senderos</a></li>
            <li><a href="#"><i class=""></i> Timeline</a></li>
            <li><a href="#"><i class=""></i> Reporte Bitacora</a></li>
            <li><a href="bitacora"><i class=""></i> Bitacora</a></li>
          </ul>
        </li>
        <!--Fin REPORTES-->

          <!--Inicio panel de ADMINISTRACION-->
        <li name="admin" id= "admin" class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Panel de control</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="panel"><i class=""></i>Administración sistema</a></li>
            <li><a href="configuracion"><i class=""></i>Otra configuracion</a></li>
            <!--<li><a href="mantroles"><i class=""></i>Mantenimiento Roles</a></li>
            <li><a href="mantObjetos"><i class=""></i>Mantenimiento Objetos</a></li>
            <li><a href="#"><i class=""></i>A</a></li>
            <li><a href="#"><i class=""></i>B</a></li>
            <li><a href="#"><i class=""></i>C</a></li>-->
            <li><a href="backup"><i class=""></i>Copia de seguridad BD</a></li>
          </ul>
        </li>
        <!--Final ADMINISTRACION-->

          <!--ROL DE SECRETARIO(A)-->
        <?php } elseif ($_SESSION['rol'] == "secretaria"){?>
          <!--Inicio SOLICITUDES-->
        <li class="">
          <a href="solicitudes">
            <i class="fa fa-files-o"></i>
            <span>Solicitudes</span>
          </a>
        </li>
        <!--Fin SOLICITUDES-->

          <!--Inico REPORTES-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="reporteBitacora"><i class="fa fa-circle-o"></i> Reporte Bitácora</a></li>
            <li><a href="reporteProducto"><i class="fa fa-circle-o"></i> Reporte Producto</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Senderos</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Reporte Bitacora</a></li>
          </ul>
        </li>
        <!--Fin REPORTES-->

          <!--ROL DE USUARIO-->
        <?php } elseif ($_SESSION['rol'] == "usuario") {?>

          <!--Inicio RESERVACIONES-->
          <li class="treeview" name="admin">
          <a href="#">
            <i class="fa fa-calendar-check-o"></i><span>Reservaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if ($columna["permiso_consulta"] == 1) {?><li class="active"><a href="camping"><i class="fa fa-circle-o"></i> Camping</a></li><?php }?>
            <li><a href="hotel"><i class="fa fa-circle-o"></i> Hotel</a></li>
            <li><a href="senderos"><i class="fa fa-circle-o"></i> Senderos</a></li>
          </ul>
        </li>
        <!--Fin RESERVACIONES-->

        <!--Inicio INVENTARIO-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pencil-square-o"></i>
            <span>Inventario</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="producto"><i class="fa fa-circle-o"></i> Producto</a></li>
            <li><a href="existencia"><i class="fa fa-circle-o"></i> Existencia</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Item Inventario</a></li>
          </ul>
        </li>
        <!--Final INVENTARIO-->

        <!--Inico mantenimientos-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-copy"></i>
            <span>Mantenimientos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="mantObjetos"><i class="fa fa-circle-o"></i> Pantallas del sistema</a></li>
            <li><a href="mantroles"><i class="fa fa-circle-o"></i> Roles de Usuario</a></li>
            <li><a href="mantlocalidad"><i class="fa fa-circle-o"></i> Localidad</a></li>
            <li><a href="mantparametros"><i class="fa fa-circle-o"></i> Parametros del sistema</a></li>
            <li><a href="mantpermisos"><i class="fa fa-circle-o"></i> Permisos de usuarios</a></li>
            <li><a href="mantpreguntas"><i class="fa fa-circle-o"></i> Preguntas de Usuario</a></li>
            <li><a href="mantObjetos"><i class="fa fa-circle-o"></i> Objetos del sistema</a></li>
          </ul>
        </li>
        <!-- Reportes -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-copy"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="reportes"><i class="fa fa-circle-o"></i> Reportes</a></li>
            <li><a href="mantroles"><i class="fa fa-circle-o"></i> Roles de Usuario</a></li>
            <li><a href="mantlocalidad"><i class="fa fa-circle-o"></i> Localidad</a></li>
            <li><a href="mantparametros"><i class="fa fa-circle-o"></i> Parametros del sistema</a></li>
            <li><a href="mantpermisos"><i class="fa fa-circle-o"></i> Permisos de usuarios</a></li>
            <li><a href="mantpreguntas"><i class="fa fa-circle-o"></i> Preguntas de Usuario</a></li>
            <li><a href="mantObjetos"><i class="fa fa-circle-o"></i> Objetos del sistema</a></li>
          </ul>
        </li>

        <!--Fin REPORTES-->
        <?php }else{
          echo "El rol no existe";
        }?>
  </section>
  <!-- /.sidebar -->
</aside>