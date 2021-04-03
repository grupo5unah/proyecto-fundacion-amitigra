<?php
include("./modelo/conexionbd.php");

$id_objeto = 22;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] === 1){
?>
<div class="content-wrapper">
	
	<section class="content-header">
      <h1>Mantenimiento<small> estados</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="panel"><i class="fa fa-cogs"></i> panel de control</a></li>
		<li><a><i class="fa fa-users"></i> mantenimiento estados</a></li>
      </ol>
      <br>
    </section>

	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Estados</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-default btnCrearEstado glyphicon glyphicon-plus-sign" >Agregar Nuevo Estado</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantEstadoTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>

											<th class="text-center">Nombre Estado</th>
											<th class="text-center">Descripción</th>
											<th class="text-center">Creado por</th>
											<th class="text-center">Fecha creación</th>
											<th class="text-center">Modificado por</th>
											<th class="text-center">Fecha Modificación</th>
											<th class="text-center">Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_estado,nombre_estado,descripcion,creado_por,fecha_creacion,
                                                    modificado_por,fecha_modificacion
													FROM tbl_estado
                                                    WHERE estado_eliminado = 1";
											$resultado = $conn->query($sql);
										} catch (Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['nombre_estado'];
											$evento = array(
												'nombre_estado' => $eventos['nombre_estado'],
												'descripcion' => $eventos['descripcion'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_estado' => $eventos['id_estado']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td class="text-center"> <?php echo $evento['nombre_estado']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td class="text-center"> <?php echo $evento['creado_por']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_creacion']; ?></td>
													<td class="text-center"> <?php echo $evento['modificado_por']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarEstado glyphicon glyphicon-pencil"  data-idestado="<?= $evento['id_estado'] ?>" data-nombre="<?= $evento['nombre_estado'] ?>" 
														data-descripcion="<?= $evento['descripcion'] ?>"></button>

														<button class="btn btn-danger btnEliminarEstado glyphicon glyphicon-remove" data-idestad="<?php echo $evento['id_estado'] ?>"></button>
													</td>
												<?php }?>
											<?php }?>
												</tr>
									</tbody>
									<!--<?php //}
										?>-->

								</table>
								<!-- /table -->

							</div> <!-- /panel-body -->
						</div> <!-- /panel -->
					</div> <!-- /col-md-12 -->
					<?php $conn->close(); ?>
				</div> <!-- /row -->


			</div>
			<!-- /.box-body -->
	
			<div class="modal fade" id="modalEditarEstado" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Actualizar Estado</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="formEditarEstado" onpaste="return false">
								<div class="ingreso-producto form-group">
									
									<div class="campos">
										<label for="">Nombre Estado: </label>
										<input id="nombreEstado" class="form-control  modal-roles secundary text-uppercase" type="text" name="nombreEstado" placeholde="Escriba el nombre del estado" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

									</div>
									<div class="campos form-group">
										<label for="">Descripción: </label>
										<input id="descripcion" class="form-control  modal-roles secundary text-uppercase" type="text" name="descripcion"placeholde="Escriba la descripcion"  onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" required/>

									</div>
									
									<input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div>
								
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Estado</button>
						</div>
					</div>
				</div>
			</div>

			<!-- /.box-footer-->
			<!-- CREAR NUEVO ESTADO -->
				<div class="modal fade" id="modalCrearEstado" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Estado</h3>
									</div>
								</div>
								<div class="modal-body">
									<form name="" id="formEstado" onpaste="return false">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre Estado: </label>
												<input id="nombreE" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreE" placeholder="Nombre Estado" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Descripción: </label>
												<input id="descrip" name="descrip" class="form-control  modal-roles secundary text-uppercase" type="tex"  placeholder="Descripcion" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" required/>

											</div>
											
											
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Close</button>
										<button id=""type="submit" class=" btn btn-primary">Registrar Estado</button>
										</div>
										
									</form>
								</div>
								
							</div>
						</div>
					</div>

				
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