<?php
require "./modelo/conexionbd.php";
global $mi_rol;
$id_objeto = 5;
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

?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
      <?php
      $query = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

      $resultado = mysqli_query($conn,$query);
      
      while($imagen = mysqli_fetch_assoc($resultado)):?>
        <img src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo ucwords($usuario);?></p>
        <!--Aqui agregar variable de sesion para que muestre el cargo-->
        <a href="perfil"><i class="text-success"></i>Cargo: <?php echo $rol_id;?></a>
        <!--Aqui ira el cargo del usuario-->
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
<?php //}}?>   
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú de Navegación</li>
        <!--Pendiente-->
        
        <!--ROL DE ADMINISTRACION-->
        <?php if($_SESSION['rol'] === 'administrador' OR $_SESSION['rol'] === 'asistente' OR $_SESSION['rol'] === 'usuario'){?>
          <!--Inicio SOLICITUDES-->
          <?php if ($columna["permiso_consulta"] == 1) {?><li class="">
          <a href="solicitudes">
            <i class="fa fa-files-o"></i>
            <span>Solicitudes</span>
          </a>
        </li>
        <?php }?>
        <!--Fin SOLICITUDES-->

          <!--ROL DE USUARIO-->
          <!--Inicio RESERVACIONES-->
          <li class="treeview" name="admin">
          <?php if ($columna['permiso_consulta'] == 1 OR $columna["permiso_consulta"] == 0) {?>
          <a href="#">
            <i class="fa fa-calendar-check-o"></i>
            <span>Reservaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li class="active"><a href="camping"><i class=""></i> Camping</a></li>
            <li><a href="hotel"><i class=""></i> Hotel</a></li>
            <li><a href="senderos"><i class=""></i> Senderos</a></li>
          </ul>
        </li>
        <?php }?>
        <!--Fin RESERVACIONES-->

        <!--Inicio INVENTARIO-->
        <li class="treeview">
        <?php if ($columna['permiso_consulta'] == 1 OR $columna["permiso_consulta"] == 0) {?>
          <a href="#">
            <i class="fa fa-pencil-square-o"></i>
            <span>Inventario</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="producto"><i class=""></i> Producto</a></li>
            <li><a href="existencia"><i class=""></i> Existencia</a></li>
          </ul>
        </li>
        <?php }?>
        <!--Final INVENTARIO-->

          <!-- Reportes -->
        <li class="treeview">
        <?php if ($columna['permiso_consulta'] == 1 OR $columna["permiso_consulta"] == 0) {?>
          <a href="#">
            <i class="fa fa-pencil"></i>
            <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="reportes"><i class=""></i> Reportes</a></li>
            <li><a href="mantroles"><i class=""></i> Roles de Usuario</a></li>
            <!-- <li><a href="mantlocalidad"><i class=""></i> Localidad</a></li> -->
            <li><a href="mantparametros"><i class=""></i> Parametros del sistema</a></li>
            <li><a href="mantpermisos"><i class=""></i> Permisos de usuarios</a></li>
            <li><a href="mantpreguntas"><i class=""></i> Preguntas de Usuario</a></li>
            <li><a href="mantObjetos"><i class=""></i> Objetos del sistema</a></li>
          </ul>
        </li>
        <!--Fin REPORTES-->
        <?php }?>

        <!--Inicio panel de ADMINISTRACION-->
        <li name="admin" id= "admin" class="treeview">
        <?php if ($_SESSION['rol'] == 'administrador' and $columna['permiso_consulta'] == 1) {?>
          <a href="#">
            <i class="fa fa-gear"></i> <span>Panel de control</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="panel"><i class=""></i>Administración sistema</a></li>
            <li><a href="configuracion"><i class=""></i>Configuración sistema</a></li>
            <li class="treeview">
              <a href="#"><i class=""></i> Mantenimiento
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <!--<li><a href="#"><i class=""></i> Bitácora</a></li>
                <li><a href="#"><i class=""></i> Productos</a></li>
                <li><a href="#"><i class=""></i> Localidad</a></li>-->
                <li><a href="mantroles"><i class=""></i> Roles</a></li>
                <li><a href="mantpermisos"><i class=""></i> Permisos</a></li>
                <li><a href="mantpreguntas"><i class=""></i> Preguntas</a></li>
                <li><a href="mantparametros"><i class=""></i> Parametros</a></li>
                <li><a href="mantObjetos"><i class=""></i> Objetos</a></li>
              </ul>
            </li>
            <li><a href="backup"><i class=""></i>Copia de seguridad BD</a></li>
          </ul>
        </li>
        <!--Final ADMINISTRACION-->

        <?php }}
        }}?>


  </section>
  <!-- /.sidebar -->
</aside>