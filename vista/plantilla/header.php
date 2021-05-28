<?php

  require './modelo/conexionbd.php';

  $nombre_sistema = 'NOMBRE_SISTEMA';

  $nombre = $conn->prepare("SELECT parametro, valor FROM tbl_parametros WHERE parametro = ?;");
  $nombre->bind_Param("s",$nombre_sistema);
  $nombre->execute();
  $nombre->bind_Result($parametro,$valor);

  if($nombre->affected_rows){
    $existe = $nombre->fetch();

    if($existe){
      $extraer = substr($valor,5,8);
      $extraer2 = substr($valor,28,35);

?>
  <header class="main-header">
    <!-- Logo -->
    <a href="inicio" class="logo">
      <span class="logo-mini"><b>SA</b>AT</span>
      <span class="logo-lg"><b><?php echo $extraer;?> </b><?php echo $extraer2;}}?></span>
    </a>
    
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">


        <!-- NOTIFICACIONES INICIO -->
        
        <!-- NOTIFICACIONES FINAL -->


        <?php 
        require './modelo/conexionbd.php';
        
        $query = "SELECT foto FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";

        $resultado = mysqli_query($conn, $query);

        while($imagen = mysqli_fetch_assoc($resultado)):?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="fotoPerfil/<?php echo $imagen['foto'];?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><strong>Cuenta:</strong> <?php echo ucwords($usuario);?></span>
            </a>
            <ul class="dropdown-menu">

              <li class="user-header">
                <img src="fotoPerfil/<?php echo $imagen['foto']; endwhile;?>" class="img-circle" alt="User Image">

                <p>
                
                <?php echo ucwords($usuario); ?> - <?php echo ucwords($rol_id);?><!--<?php //echo $cargo;?>--> <!--Aqui ira la variable que traiga el rol del usuario-->
                  <small>Miembro desde: <br> <?php date_default_timezone_set('America/Tegucigalpa'); setlocale(LC_ALL,'Spanish_Honduras.UTF8'); $fecha = strftime('%A %d de %B del %G',strtotime($ingreso)); echo $fecha;?></small> <!--Aqui ira variable que muestre la fecha en la que se unio el usuario-->
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <form method="POST">
                    <a href="perfil" class="btn btn-primary btn-flat"><i class="fa fa-user"></i> Perfil</a> <!--Boton que redirige al perfil o configuracion de usuario--> 
                  </form>
                </div>
                
                <div class="pull-right">
                  <a href="cerrarSesion" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i> Cerrar sesion</a> <!--Salir del sistema-->
                </div>
              </li>
            </ul>
          </li>
          <li>
      </div>
    </nav>
          
  </header>