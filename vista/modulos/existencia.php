<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Existencia</h3>

			</div>
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de productos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="producto" class="btn btn-default button1" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar producto </a>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>

											<th>Nombre del producto</th>
											<th>Precio</th>
											<th>Existencia</th>
											<th>Fecha de Entrada</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


<<<<<<< Updated upstream
											$sql = "SELECT id_inventario, nombre_articulo,existencias, costo, fecha_entrada FROM tbl_inventario WHERE estado_eliminar=1";
=======
											$sql = "SELECT id_inventario, nombre_articulo,existencia, costo, fecha_entrada FROM tbl_inventario;";
>>>>>>> Stashed changes
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['existencias'];
											$evento = array(
												'nombre_arti' => $eventos['nombre_articulo'],
												'existencia_inve' => $eventos['existencias'],
												'costo_art' => $eventos['costo'],
												'fecha_art' => $eventos['fecha_entrada'],
												'id_inventario' => $eventos['id_inventario'],

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_arti']; ?></td>
													<td> <?php echo $evento['costo_art']; ?></td>
													<td> <?php echo $evento['existencia_inve']; ?></td>
													<td> <?php echo $evento['fecha_art']; ?></td>
													<td>
														<button class="btn btn-warning btnEditar glyphicon glyphicon-pencil"  data-idproducto="<?php $evento['id_inventario'] ?>" data-nombreArti="<?php $evento['nombre_arti'] ?>" data-existencia="<?php $evento['existencia_inve'] ?>" data-costo="<?php $evento['costo_art'] ?>"></button>

														<button class="btn btn-danger btnEliminar glyphicon glyphicon-remove" data-idproductodel="<?php echo $evento['id_inventario'] ?>"></button>
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
			<div class="box-footer">
				Footer
				<div class="modal fade" id="modalEditarProducto" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Producto</h3>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
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
											<label for="">Nombre del Producto </label>
											<input id="nombreInven" class="form-control secundary" type="text" name="nombreProducto" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">Cantidad </label>
											<input id="cantInven" class="form-control secundary" type="tel" name="cantidad" placeholde="Escriba el producto" required />

										</div>
										<div class="campos form-group">
											<label for="">Precio de Compra </label>
											<input id="precioInven" class="form-control secundary" type="tel" name="precio" placeholde="Escriba el producto" required />

										</div>
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="  btnEditarBD btn btn-primary">Actualizar producto</button>
							</div>
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