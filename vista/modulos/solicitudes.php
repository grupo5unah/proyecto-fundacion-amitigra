<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">

          <!-- INICIO DE LA INFORMACION DEL USUARIO-->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <p class="text-muted text-center">Datos solicitud</p>

              <?php

              include_once("./modelo/conexionbd.php");
                  //try {
                    $stmt = $conn->prepare("SELECT nombre_completo, correo, telefono, primer_ingreso, fecha_vencimiento FROM tbl_usuarios WHERE nombre_usuario = ?");
                    $stmt->bind_Param("s",$usuario);
                    $stmt->execute();
                    $stmt->bind_Result($nombre, $correo, $telefono, $ingreso, $vencimiento);
                 
                  if($stmt->affected_rows){

                    $existe = $stmt->fetch();

                    if($existe){
                      $_SESSION['nombre_completo'] = $nombre;
                      $_SESSION['correo'] = $correo;
                      $_SESSION['telefono'] = $telefono;
                      $_SESSION['fecha_vencimiento'] = $vencimiento;

                      $fecha_registro = new DateTime($ingreso);
                      date_default_timezone_set("America/Tegucigalpa");
                      $fecha_hoy = date('Y-m-d H:i:s', time());
                      $fecha_actual = new DateTime($fecha_hoy);
                      $diff = $fecha_registro->diff($fecha_actual);
                      $dias_transcurridos = $diff->days;

              ?>       
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>ID solicitud: </b> <a class="pull-right"><input type="text" placeholder="Ingresar id solicitud"></a>
                </li>
                <li class="list-group-item">
                  <b>ID Solicitante: </b> <a class="pull-right"><input type="text" placeholder="Ingresar id solicitante"></a>
                </li>
                <li class="list-group-item">
                  <b>Nombre completo: </b> <a class="pull-right"><input type="text" placeholder="Ingresar nombre completo"></a>
                </li>
                <li class="list-group-item">
                  <b>Tipo de solicitud: </b> <a class="pull-right"><input type="text" placeholder="Ingresar tipo de solicitud"></a>
                  <br>
                </li>
                <li class="list-group-item">
                  <b>Fecha de solicitud: </b> <a class="pull-right"><input type="text" placeholder="Fecha"></a>
                </li>
                <li class="list-group-item">
                  <b>Recibo de pago No.: </b> <a class="pull-right"><input type="text" placeholder="Ingresar recibo numero pago"></a>
                </li>
              </ul>
                 
            </div>
            <!-- /.box-body -->
          </div>
          <!--FIN DE LA INFORMACION DEL USUARIO-->

        </div>    
        
        <!--INICIO DE LA TABLA-->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a>Geolocalizacion FUNDACION AMITIGRA</a></li>
            </ul>
            <div class="tab-content">
            <div id="mapid" style="width: 816px; height: 460px;" ></div>
            </div>
            <!-- /.tab-content -->
          </div>
          <?php }}?>
          <!-- /.nav-tabs-custom -->
        </div>
        <!--FIN DE LA TABLA-->
      </div>
      
      <!--INICIO TABLA INFERIOR-->
      <!--ABRE DIV ROW-->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body pad table-responsive">
              <p>Verificar datos tabla</p>
              <table class="table table-bordered text-center">
                <!--INICIO TABLA-->
                <div class="box-body">

            <!--<a href="nuevo-registrado.php" class="btn btn-success">Añadir Nuevo</a>-->
            <table id="tablas" class="display responsive nowrap">
                <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>Nombre usuario</th>
                        <th>Correo</th>
                        <th>Genero</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Estado usuario</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        </tr>
                </thead>
                <tbody>

                <?php
                  try {
                    $stmt = "SELECT id_usuario, nombre_completo, nombre_usuario, correo, genero, telefono, tbl_roles.rol AS rol, tbl_estado.id_estado as estado_usuario FROM tbl_usuarios
                    INNER JOIN tbl_roles
                    ON tbl_usuarios.rol_id = tbl_roles.id_rol
                    INNER JOIN tbl_estado
                    ON tbl_usuarios.estado_id = tbl_estado.id_estado
                    ORDER BY id_usuario DESC;
                    ";
                    $resultado = $conn->query($stmt);
                  } catch (Exception $e) {
                    $error = $e->getMessage();
                  }
                 while( $registrado = $resultado->fetch_assoc() ) { ?>
                    <tr>
                    <td><?php echo $registrado['nombre_completo']; ?></td>  
                    <td><?php echo $registrado['nombre_usuario']; ?></td>
                    <td><?php echo $registrado['correo']; ?></td>
                    <td><?php echo $registrado['genero']; ?></td>
                    <td><?php echo $registrado['telefono']; ?></td>
                    <td><?php echo $registrado['rol']; ?></td>
                    <td><?php echo $registrado['estado_usuario']; ?></td>
                    <td>
                    <!--<a type="button" data-toggle="modal" data-target="#modal-default" class="btn bg-orange btn-flat"> <i class="fa fa-pencil"></i></a>-->
                    <a class="btn bg-orange btn-flat" href="hotel?id = <?php echo $registrado['id_usuario'];?>"><i class="fa fa-pencil"></i></a>  
                  </td>
                    <td>
                    <input type="hidden" name="eliminarUsuario" value="id=<?php echo $registrado['id_usuario'];?>">
                    <button type="submit" class="btn bg-maroon btn-flat"><i class="fa fa-trash"></i></button>
                    <?php
                    include_once("./controlador/ctr.borrarUser.php");

                    $borrar = new borrar();
                    $borrar->ctrBorrar();
                    ?>
                    </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Nombre</th>
                    <th>Nombre usuario</th>
                    <th>Correo</th>
                    <th>Genero</th>
                    <th>Telefono</th>
                    <th>Rol</th>
                    <th>Estado usuario</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                    </tr>
                </tfoot>
            </table>
          </div>
                <!--FINAL TABLA-->
              </table>
            </div>
          </div>
        </div>
      </div>
      <!--CIERRA DIV ROW-->
      <!--FINAL TABLA INFERIOR-->

    </section>
    <!-- /.content -->
  </div>