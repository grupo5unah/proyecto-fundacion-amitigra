<?php

include("./modelo/conexionbd.php");

$id_objeto = 27;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_eliminacion, permiso_actualizacion, permiso_insercion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador") {
	if ($columna["permiso_consulta"] == 1) {
?>
		<div class="content-wrapper"  oncopy="return false" onpaste="return false">

			<section class="content-header">
				<h1>Mantenimiento<small>Tipo Movimiento</small></h1>
				<ol class="breadcrumb">
					<li class="btn btn-success  text-uppercase fw-bold"><a href="inicio"><i class="fa fa-home  "></i> Inicio</a></li>
					<li class="btn btn-success  text-uppercase fw-bold"><a href="panel"><i class="fa fa-cogs btn  "></i> panel de control</a></li>
					<li class="btn btn-success active text-uppercase fw-bold"><a><i class="fa fa-users btn  "></i> mantenimiento Tipo Movimientos</a></li>
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
										<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento de Tipo Movimiento</div>
									</div> <!-- /panel-heading -->
									<div class="panel-body">
										<div class="remove-messages"></div>
										<div class="div-action pull pull-right" style="padding-bottom:20px;">
											<a class="btn btn-success btnMovimiento glyphicon glyphicon-plus-sign text-uppercase"> Nuevo Movimiento </i></a>
										</div>
										<!-- <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>"> -->
										
										<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantMovimiento">
											<thead>
												<tr>
													<th>Movimiento</th>
													<th>Creado Por</th>
													<th>Fecha de Creacion</th>
													<th>Modificado por</th>
													<th>Fecha de Modificacion</th>
													<?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

													else : ?>
														<th>Acciones</th>
													<?php
													endif;
													?>

												</tr>
											</thead>
											<tbody>
												<?php
												try {
													$sql = "SELECT id_tipo_movimiento, movimiento, creado_por, fecha_creacion, modificado_por, fecha_modificacion  
											 FROM tbl_tipo_movimiento 								
											 ORDER BY id_tipo_movimiento";
													$resultado = $conn->query($sql);
												} catch (Exception $e) {
													echo  $e->getMessage();
												}
												//esta variable es para realizar un arreglo que permita mostrar los resultados en la modal
												$ver = array();
												while ($mostrar = $resultado->fetch_assoc()) {
													$captura = $mostrar['movimiento'];
													$mostrar = array(
														'movimiento' => $mostrar['movimiento'],
														'creado' => $mostrar['creado_por'],
														'creacion' => $mostrar['fecha_creacion'],
														'modificado' => $mostrar['modificado_por'],
														'fechaModificacion' => $mostrar['fecha_modificacion'],
														'id_movimiento' => $mostrar['id_tipo_movimiento']

													);
													$ver[$captura][] =  $mostrar;
												}
												foreach ($ver as $reserva => $lista) { ?>

													<?php foreach ($lista as $mostrar) { ?>
														<tr>
															<td><?php echo $mostrar['movimiento']; ?></td>
															<td><?php echo $mostrar['creado']; ?></td>
															<td><?php echo $mostrar['creacion']; ?></td>
															<td><?php echo $mostrar['modificado']; ?></td>
															<td><?php echo $mostrar['fechaModificacion']; ?></td>

															<td>
																<?php if ($columna['permiso_actualizacion'] == 1) : ?>
																	<button class="btn btn-warning btnEditarMovimiento glyphicon glyphicon-pencil" data-id_mo="<?= $mostrar['id_movimiento'] ?>" data-movimientos="<?= $mostrar['movimiento'] ?>"></button>
																<?php
																else :
																endif;

																if ($columna['permiso_eliminacion'] == 1) :
																?>
																	<button class="btn btn-danger btnEliminarmovimiento glyphicon glyphicon-remove" data-idmovimiento="<?= $mostrar['id_movimiento'] ?>"></button>
																<?php
																else :
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
					<div class="modal fade" id="modalEditarMovimiento" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Editar Movimiento</h3>
									</div>
								</div>
								<div class="modal-body">
									<form method="POST" id="formMovimiento">

										<div class="ingreso-producto form-group">

											<div class="campos">
												<label for="">Movimiento:</label>
												<input id="Movi" onkeypress="return soloLetrasNumeros(event)"  onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="" autocomplete="off" required />
											</div>

											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div> <!-- /.modal form-group -->

									</form> <!-- /.cierre de formulario -->
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar </button>

										<button id="" type="submit" class="btn btn-success btnEditarBD">Editar Movimiento</button>
									</div>
								</div> <!-- /.modal-body -->
								<?php
								if (isset($_GET['msg'])) {
									$mensaje = $_GET['msg'];
									print_r($mensaje);
									//echo "<script>alert(".$mensaje.");</script>";  
								}
								?>
							</div> <!-- /.modal content -->
						</div> <!-- /.modal-dialog -->
					</div> <!-- /.modal fade -->

					<!-- MODAL CREAR LA Movimiento-->
					<div class="modal fade" id="modalCrearMovimiento" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Crear de Movimiento</h3>
									</div>
								</div>
								<div class="modal-body">
									<form method="POST" id="formMovi" onpaste="return false">

										<div class="campos">
											<label for="">Movimiento:</label>
											<input id="movimiento" onkeypress="return soloLetrasNumeros(event)"  onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="NacionalidadN" autocomplete="off" required />
										</div>
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">

										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar </button>
										
											<button id="" type="submit" class="btn btn-success btnEditarBD">Crear Movimiento</button>
									    </div>
									</form>
									<!-- /.cierre de formulario -->

									
								</div> <!-- /.modal-body -->
								<?php
								if (isset($_GET['msg'])) {
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

	} else {
		echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";
	}
} ?>