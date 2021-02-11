<?php include("./modelo/conexionbd.php"); ?>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de objetos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-default btnCrearObjeto glyphicon glyphicon-plus-sign" >Agregar Nuevo Objeto</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>

											<th>Objeto</th>
											<th>Tipo Objeto</th>
											<th>descripcion</th>
											<th>creado por</th>
                                            <th>Fecha creacion</th>
                                            <th>Modificado por</th>
											<th>Fecha modificacion</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_objeto, objeto, tipo_objeto, descripcion, creado_por,fecha_creacion, modificado_por, fecha_modificacion
                                         FROM tbl_objeto where estado_eliminado =1";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['objeto'];
											$evento = array(
												'nombre_objeto' => $eventos['objeto'],
												'tipo_objeto' => $eventos['tipo_objeto'],
												'descripcion' => $eventos['descripcion'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'modificado_por' => $eventos['modificado_por'],
                                                'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_objeto' => $eventos['id_objeto']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_objeto']; ?></td>
													<td> <?php echo $evento['tipo_objeto']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
                          							<td> <?php echo $evento['fecha_creacion']; ?></td>
                        							<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarObjeto glyphicon glyphicon-pencil"  data-idobjeto="<?= $evento['id_objeto'] ?>" data-nombreobjeto="<?= $evento['nombre_objeto'] ?>" 
														data-tipo_objeto="<?= $evento['tipo_objeto'] ?>" data-descripcion="<?= $evento['descripcion'] ?>"></button>

														<button class="btn btn-danger btnEliminarObjeto glyphicon glyphicon-remove" data-idobjeto="<?php echo $evento['id_objeto'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarObjeto" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
 									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Objeto</h3>
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
											<label for="">Nombre objeto: </label>
											<input id="nombre_Objeto" class="form-control  modal-roles secundary" type="text" name="objeto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">Tipo objeto: </label>
											<input id="tipo_Objeto" class="form-control  modal-roles secundary" type="text" name="tipo_objeto"placeholde="Escriba el tipo obj" required />

										</div>
										<div class="campos form-group">
											<label for="">Descripcion objeto: </label>
											<input id="descripcionObjeto" class="form-control  modal-roles secundary" type="tel" name="descripcion" placeholde="Escriba el producto" required />

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Objeto</button>
							</div>
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
			<!-- crear nuevos Objetos -->
				<div class="modal fade" id="modalCrearObjeto" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Objeto</h3>
									</div>
								</div>
								<div class="modal-body">
									<form name="" id="formObjeto">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre objeto: </label>
												<input id="nombreObjeto" class="form-control modal-roles secundary" type="text" name="Objeto" placeholder="Escriba el objeto" required />

											</div>
											<div class="campos form-group">
												<label for="">Tipo objeto: </label>
												<input id="tObjeto" class="form-control  modal-roles secundary" type="tex"  placeholder="tipo del objeto" required />

											</div>
											<div class="campos form-group">
												<label for="">Descripcion objeto: </label>
												<input id="descripcion" class="form-control  modal-roles secundary" type="text"  placeholder="Describa el objeto" required />

											</div>
											
											
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Close</button>
										<button id=""type="submit" class=" btn btn-primary">Registrar  Objeto</button>
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