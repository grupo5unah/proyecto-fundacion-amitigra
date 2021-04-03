<?php

include "./modelo/conexionbd.php";

$id_objeto = 37;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] === 1){
?>

<div class="content-wrapper">
    <section class="content">
    <div class="box box-default color-palette-box">
        <div class="text-center">
            <p>Espacio creado para poder crear y gestionar las solicitudes</p><br>
            <p>Aqui podras generar las solicitudes</p>
        <a class="btn btn-primary text-center" href="solicitudes">Nueva solicitud</a>
        </div>
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

                <?php
                 include_once("./modelo/conexion.php");
                 ?>
            <!--<a href="nuevo-registrado.php" class="btn btn-success">Añadir Nuevo</a>-->
            <table id="tablas" class="display responsive nowrap">
                <thead>
                        <tr>
                        <th>Nombre</th>
                        <th>apellido</th>
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
                    $stmt = "SELECT id_usuario, nombre, apellido, nombre_usuario, correo, genero, telefono, tbl_roles.rol AS rol, estado_usuario FROM tbl_usuarios
                    INNER JOIN tbl_roles
                    ON
                    tbl_usuarios.rol_id = tbl_roles.id_rol
                    ORDER BY id_usuario DESC;
                    ";
                    $resultado = $conn->query($stmt);
                  } catch (Exception $e) {
                    $error = $e->getMessage();
                  }
                 while( $registrado = $resultado->fetch_assoc() ) { ?>
                    <tr>
                    <td><?php echo $registrado['nombre']; ?></td>
                    <td><?php echo $registrado['apellido']; ?></td>    
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
                    <th>apellido</th>
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

  <?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>