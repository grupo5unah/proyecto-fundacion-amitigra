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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento parámetros</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="producto" class="btn btn-default button1" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar parametro </a>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>

											<th>Parámetro</th>
											<th>Valor</th>
											<th>Fecha creación</th>
											<th>Fecha modificaciÓn</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_parametro,parametro,valor,fecha_creacion,fecha_modificacion
                                                            FROM tbl_parametros";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['parametro'];
											$evento = array(
												'nombre_parametro' => $eventos['parametro'],
												'valor' => $eventos['valor'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_parametro' => $eventos['id_parametro']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_parametro']; ?></td>
													<td> <?php echo $evento['valor']; ?></td>
                                                    <td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarParam glyphicon glyphicon-pencil"  data-idparametro="<?= $evento['id_parametro'] ?>" data-nombreparametro="<?= $evento['nombre_parametro']?>" data-valor="<?= $evento['valor'] ?>"></button>

														<button class="btn btn-danger btnEliminarRol glyphicon glyphicon-remove" data-idparam="<?php echo $evento['id_rol'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarParam" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar parametro</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarParametro">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="campos">
											<label for="">Parametro: </label>
											<input id="nombreParam" class="form-control secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">valor parametro: </label>
											<input id="valorParam" class="form-control secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required />

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar parametro</button>
							</div>
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>