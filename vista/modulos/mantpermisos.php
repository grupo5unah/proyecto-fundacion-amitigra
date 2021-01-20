<?php include("./modelo/conexion.php"); ?>
<div class="content-wrapper">
	<!-- Main content -->
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de permisos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="producto" class="btn btn-default button1" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar permiso </a>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>

										    <th>Rol</th>
											<th>Permiso insertar</th>
                                            <th>Permiso eliminar</th>
                                            <th>Permiso actualizar</th>
                                            <th>Permiso consulta</th>
											
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_permisos, rol, permiso_insercion,permiso_eliminacion, permiso_actualizacion, permiso_consulta
                                                    FROM tbl_permisos inner join tbl_roles where tbl_permisos.id_rol = tbl_roles.id_rol";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['permiso_insercion'];
											$evento = array(
												'rol' => $eventos['rol'],
												'permiso_insercion' => $eventos['permiso_insercion'],
                                                'permiso_eliminacion' => $eventos['permiso_eliminacion'],
                                                'permiso_actualizacion' => $eventos['permiso_actualizacion'],
												'permiso_consulta' => $eventos['permiso_consulta']
										
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
												    <td> <?php echo $evento['rol']; ?></td>
													<td> <?php echo $evento['permiso_insercion']; ?></td>
                                                    <td> <?php echo $evento['permiso_eliminacion']; ?></td>
                                                    <td> <?php echo $evento['permiso_actualizacion']; ?></td>
													<td> <?php echo $evento['permiso_consulta']; ?></td>
													
													<td>
														<button class="btn btn-warning btnEditarPermiso glyphicon glyphicon-pencil"  data-id_permisos="<?= $evento['id_permisos'] ?>" data-PInsertar="<?= $evento['permiso_insercion'] ?>" data-PEliminar="<?= $evento['permiso_eliminar'] ?>"  data-PActualizacion="<?= $evento['permiso_actualizacion'] ?>"data-PConsulta="<?= $evento['permiso_consulta'] ?>"   ></button>

														<button class="btn btn-danger btnEliminarPermisos glyphicon glyphicon-remove" data-id_permisos="<?php echo $evento['id_permisos'] ?>"></button>
													</td>
												<?php  } ?>
											<?php  } ?>
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
	
				<div class="modal fade" id="modalEditarPermisos" tabindex="-1"
			    	role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Permiso</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="campos">
											<label for="">Permiso Insertar</label>
											<input id="PInsertar" class="form-control modal-roles secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos">
											<label for="">Permiso Eliminar</label>
											<input id="PEliminar" class="form-control modal-roles secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos">
											<label for="">Permiso Actualizar</label>
											<input id="PActualizar" class="form-control modal-roles secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">Permiso de Consulta</label>
											<input id="PConsulta" class="form-control modal-roles secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required />

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar rol</button>
							</div>
						</div>
					</div>
				</div>
				<!-- //modal para crear nuevos permisos -->
				<!-- <div class="modal fade" id="modalCrearPermisos" tabindex="-1"
			    	role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Permiso</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="campos">
											<label for="">Nombre rol </label>
											<input id="nombreRol" class="form-control secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">Descripcion </label>
											<input id="descripcionRol" class="form-control secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required />

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar rol</button>
							</div>
						</div>
					</div>
				</div> -->

			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>