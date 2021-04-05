<?php

include("./modelo/conexionbd.php");

$id_objeto = 27;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">

	<section class="content-header">
      <h1>Mantenimiento<small> nacionalidad</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="panel"><i class="fa fa-cogs"></i> panel de control</a></li>
		<li><a><i class="fa fa-users"></i> mantenimiento nacionalidad</a></li>
      </ol>
      <br>
    </section>

	<section class="content">
 
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento de Nacionalidades</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a class=" btn btn-default btnNuevaNacionalidad glyphicon glyphicon-plus-sign"> Nueva Nacionalidad </i></a>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantNacionalidad">
									<thead>
										<tr>
											<th>Nacionalidad</th>
											<th>Creado Por</th>
											<th>Fecha de Creacion</th>
											<th>Modificado por</th>
											<th>Fecha de Modificacion</th>											
											<?php if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
											else:?>
											<th>accion</th>
											<?php
											endif;
											?>

										</tr>
									</thead>
									<tbody>
										<?php
										try{
											$sql = "SELECT id_tipo_nacionalidad, nacionalidad, creado_por, fecha_creacion, modificado_por, fecha_modificacion  
											 FROM tbl_tipo_nacionalidad 											 
											 WHERE estado_eliminado = 1
											 ORDER BY id_tipo_nacionalidad";
											$resultado = $conn->query($sql);
										}catch (Exception $e){
											echo  $e->getMessage();
										}
										//esta variable es para realizar un arreglo que permita mostrar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['nacionalidad'];
											$mostrar = array(
												'nacionalidad'=>$mostrar['nacionalidad'],
												'creado_por'=>$mostrar['creado_por'],
												'fecha_creacion'=>$mostrar['fecha_creacion'],
												'modificado_por'=>$mostrar['modificado_por'],
												'fecha_modificacion'=>$mostrar['fecha_modificacion'],
												'id_tipo_nacionalidad' =>$mostrar['id_tipo_nacionalidad']
												
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td><?php echo $mostrar['nacionalidad'];?></td>													
													<td><?php echo $mostrar['creado_por'];?></td>
													<td><?php echo $mostrar['fecha_creacion'];?></td>
													<td><?php echo $mostrar['modificado_por'];?></td>
													<td><?php echo $mostrar['fecha_modificacion'];?></td>
													
													<td>
													<?php if($columna['permiso_actualizacion'] == 1):?>
													<button class="btn btn-warning btnEditarNacionalidad glyphicon glyphicon-pencil"  data-idnacionalidad="<?= $mostrar['id_tipo_nacionalidad'] ?>" 
													data-nacionalidad="<?= $mostrar['nacionalidad'] ?>"	data-fmodificacion="<?= $mostrar['fecha_modificacion'] ?>" 
													data-modificadoPor="<?= $mostrar['modificado_por'] ?>"></button>
													<?php
														else:
														endif;

														if($columna['permiso_eliminacion'] == 1):
													?>
													<button class="btn btn-danger btnEliminarNacionalidad glyphicon glyphicon-remove" data-idnacionalidad="<?= $mostrar['id_tipo_nacionalidad'] ?>"></button>
													<?php
														else:
														endif;
													?>									
												</td>
											<?php  } ?>
										<?php  } ?>
												</tr>
									</tbody>
								</table>
								<!-- /table -->
							</div> <!-- /panel-body -->
						</div> <!-- /panel -->
					</div> <!-- /col-md-12 -->
					<?php $conn->close(); ?>
				</div> <!-- /row -->
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer-->
			<!-- MODAL EDITAR LA NACIONALIDAD -->
			<div class="modal fade" id="modalEditarNacionalidad" data-backdrop="static" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Editar Nacionalidad</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formNacionalidad">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
														<label for=""> </label>
														<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
													</div>
													
													<div class="campos">
													<label for="">Nacionalidad:</label>
														<input id="Nacionalidad" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="Nacionalidad" autocomplete="off" required />
													</div>
													<div class="campos">
														<label for="">Fecha Modificada Nacionalidad:</label>
														<input id="Femodificacion" class="form-control modal-roles secundary" type="datetime" name="Femodificacion" <?php
																														date_default_timezone_set("America/Tegucigalpa");
																														$fec=date('Y-m-d H:i:s',time());
																														?> value="<?php echo $fec;?>" disabled="true" />
													</div>
													<div class="campos">
														<label for="">Modificado Por:  </label>			
														<input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>"> 											
														<input id="ModificadoPoru" style="text-transform: uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="usuario_actual" value="<?= $usuario ?>" disabled="true"/>
													</div>
														
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
													<button id=""type="submit" class="btn btn-primary btnEditarBD">Editar Nacionalidad</button>
												</div>				
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->	
									</div> <!-- /.tab-content -->	
								</div> <!-- /.tabs-custom -->	
							</form> <!-- /.cierre de formulario -->
						</div> <!-- /.modal-body -->
						<?php 
						if(isset($_GET['msg'])){
						$mensaje = $_GET['msg'];
						print_r($mensaje);
						//echo "<script>alert(".$mensaje.");</script>";  
						}
						?>
					</div> <!-- /.modal content -->
				</div> <!-- /.modal-dialog -->
			</div> <!-- /.modal fade -->

			<!-- MODAL CREAR LA NACIONALIDAD -->
			<div class="modal fade" id="modalCrearNacionalidad" data-backdrop="static" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Creacion de Nacionalidad</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formCrearNacionalidad" onpaste= "return false">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
														<label for=""> </label>
														<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
													</div>
													
													<div class="campos">
													<label for="">Nacionalidad:</label>
														<input id="NacionalidadN" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="NacionalidadN" autocomplete="off" required />
													</div>													
													<div class="campos">
														<label for="">Creado Por:  </label>			
														<input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>"> 											
														<input id="CreadoPor" style="text-transform: uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="usuario_actual" value="<?= $usuario ?>" disabled="true"/>
													</div>
														
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
													<button id=""type="submit" class="btn btn-primary btnEditarBD">Crear Nacionalidad</button>
												</div>				
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->	
									</div> <!-- /.tab-content -->	
								</div> <!-- /.tabs-custom -->	
							</form> <!-- /.cierre de formulario -->
						</div> <!-- /.modal-body -->
						<?php 
						if(isset($_GET['msg'])){
						$mensaje = $_GET['msg'];
						print_r($mensaje);
						//echo "<script>alert(".$mensaje.");</script>";  
						}
						?>
					</div> <!-- /.modal content -->
				</div> <!-- /.modal-dialog -->
			</div> <!-- /.modal fade -->

		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>