<header class="main-header">
    <!-- Logo -->
    <a href="inicio" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>AT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sistema </b>AMITIGRA</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
      
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="vista/dist/img/avatar5.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Cuenta: <?php echo ucwords($usuario);?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="vista/dist/img/avatar5.png" class="img-circle" alt="User Image">

                <p>
                <?php echo ucwords($usuario); ?> - <?php echo ucwords($rol_id);?><!--<?php //echo $cargo;?>--> <!--Aqui ira la variable que traiga el rol del usuario-->
                  <small>Miembro desde: <br> <?php echo $ingreso;?></small> <!--Aqui ira variable que muestre la fecha en la que se unio el usuario-->
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <form method="POST">
                  <a href="perfil" class="btn btn-primary btn-flat">Perfil</a> <!--Boton que redirige al perfil o configuracion de usuario-->
                  
                  </form>
                </div>
                
                <div class="pull-right">
                  <a href="cerrarSesion" class="btn btn-danger btn-flat">Cerrar sesion</a> <!--Salir del sistema-->
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
          
  </header>