<<<<<<< Updated upstream
<?php include("./modelo/conexionbd.php"); ?>
=======
<?php require "./modelo/conexionbd.php"; ?>
>>>>>>> Stashed changes
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
								
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>
<<<<<<< Updated upstream

										    <th>Rol</th>
											<th>Objeto</th>
=======
										    
>>>>>>> Stashed changes
											<th>Permiso insertar</th>
                                            <th>Permiso eliminar</th>
                                            <th>Permiso actualizar</th>
                                            <th>Permiso consulta</th>
											<th>Rol</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


<<<<<<< Updated upstream
											$sql = "SELECT id_permiso, rol, objeto, permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta FROM tbl_permisos inner join tbl_roles INNER JOIN tbl_objeto where tbl_permisos.rol_id = tbl_roles.id_rol and tbl_permisos.objeto_id = tbl_objeto.id_objeto";
=======
											$sql = "SELECT id_permiso, rol_id, permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta
                                                    FROM tbl_permisos
													INNER JOIN tbl_roles
													ON tbl_permisos.rol_id = tbl_roles.id_rol";
>>>>>>> Stashed changes
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['permiso_insercion'];
											$evento = array(
<<<<<<< Updated upstream
												'rol' => $eventos['rol'],
												'objeto' => $eventos['objeto'],
=======
												'rol' => $eventos['rol_id'],
>>>>>>> Stashed changes
												'insercion' => $eventos['permiso_insercion'],
                                                'eliminacion' => $eventos['permiso_eliminacion'],
                                                'actualizacion' => $eventos['permiso_actualizacion'],
												'consulta' => $eventos['permiso_consulta'],
<<<<<<< Updated upstream
												'id_permiso' =>$eventos['id_permiso']
=======
												'id_permisos' =>$eventos['id_permiso']
>>>>>>> Stashed changes
										
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
<<<<<<< Updated upstream
												    <td> <?php echo $evento['rol']; ?></td>
													<td> <?php echo $evento['objeto']; ?></td>
=======
												    
>>>>>>> Stashed changes
													<td> <?php echo $evento['insercion']; ?></td>
                                                    <td> <?php echo $evento['eliminacion']; ?></td>
                                                    <td> <?php echo $evento['actualizacion']; ?></td>
													<td> <?php echo $evento['consulta']; ?></td>
													<td> <?php echo $evento['rol']; ?></td>

													<td>
<<<<<<< Updated upstream
													<button class="btn btn-warning btnEditarPermisos glyphicon glyphicon-pencil"  data-idpermiso="<?= $evento['id_permiso'] ?>" data-insercion="<?= $evento['insercion']?>" data-eliminar="<?= $evento['eliminacion'] ?>" 
													data-actualizacion="<?= $evento['actualizacion'] ?>" data-consulta="<?= $evento['consulta'] ?>"></button>
=======
													<button class="btn btn-warning btnEditarPermisos glyphicon glyphicon-pencil"  data-idpermiso="<?php $evento['id_permisos']; ?>" data-insercion="<?php $evento['insercion'];?>" data-eliminar="<?php $evento['eliminacion'];?>"></button>
>>>>>>> Stashed changes
											
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
								<form name="">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="campos">
											<label for="">Permiso Insertar</label>
											<input id="Insertar" class="form-control modal-roles secundary" type="text"   required />

										</div>
										<div class="campos">
											<label for="">Permiso Eliminar</label>
											<input id="Eliminar" class="form-control modal-roles secundary" type="text" name="" required />

										</div>
										<div class="campos">
											<label for="">Permiso Actualizar</label>
											<input id="Actualizar" class="form-control modal-roles secundary" type="text" name="" required />

										</div>
										<div class="campos form-group">
											<label for="">Permiso de Consulta</label>
											<input id="Cosulta" class="form-control modal-roles secundary" type="text" name=""requared />

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Permiso</button>
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