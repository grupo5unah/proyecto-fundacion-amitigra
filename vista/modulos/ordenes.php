<?php require './modelo/conexionbd.php'; ?>

<div class="content-wrapper" oncopy="return false" onpaste="return false">

	<section class="content-header">
		<h1>Gestionar Ordenes</h1>
		<ol class="breadcrumb ">
			<li class="btn btn-success  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
			<li class="btn btn-success  fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
			<li class="btn btn-success  fw-bold"><a href="existencias"><i class="fas fa-inventory"></i> Inventario General</a></li>
			<li class="btn btn-success active  fw-bold "><a href="#"></a><i class="fab fa-product-hunt"></i> Ordenes </a></li>
		</ol>
	</section>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Ordenes</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="#" class="btn btn-success button1 btnCrearOrden text-uppercase" id=""> <i class="glyphicon glyphicon-plus-sign"></i> Agregar Orden de Productos </a>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="gestionOrdenes">
									<thead style="background-color: #222d32; color: white;">
										<tr>
											<th>Orden</th>
											<th>Localidad</th>
											<th>Usuario</th>
											<th>Total</th>
											<th>Estado</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try {

											$sql = "SELECT O.id_orden, l.nombre_localidad, u.nombre_usuario, E.nombre_estado, count(*) from tbl_ordenes O INNER JOIN tbl_localidad L on O.localidad_id = L.id_localidad INNER JOIN tbl_usuarios U ON O.usuario_id = U.id_usuario INNER JOIN tbl_estado E ON E.id_estado= o.estado_id INNER JOIN tbl_detalle_orden d ON d.ordenes_id = O.id_orden GROUP BY d.ordenes_id  ";

											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['id_orden'];
											$evento = array(
												'numeroOrden' => $eventos['id_orden'],
												'localidad' => $eventos['nombre_localidad'],
												'usuario' => $eventos['nombre_usuario'],
												'totalP' => $eventos['count(*)'],
												'estado' => $eventos['nombre_estado']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['numeroOrden']; ?></td>
													<td> <?php echo $evento['localidad']; ?></td>
													<td> <?php echo $evento['usuario']; ?></td>
													<td> <?php echo $evento['totalP']; ?></td>
													<td> <?php echo $evento['estado']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarProducto glyphicon glyphicon-pencil" data-idProduct="<?= $evento['id_P'] ?>" data-nomProducto="<?= $evento['nombreP'] ?>" data-precioP="<?= $evento['precioP'] ?>" data-cantProducto="<?= $evento['cantidadP'] ?>" data-desc="<?= $evento['descripcion'] ?>" data-TP="<?= $evento['tipo_producto'] ?>" data-precioAl="<?= $evento['precioAl'] ?>"></button>

														<button class="btn btn-danger btnDeleteP glyphicon glyphicon-remove" data-idP="<?php echo $evento['id_P'] ?>"></button>
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

				</div> <!-- /row -->


			</div>
			<!-- /.box-body -->

			<div class="modal fade" id="ModalCrearOrden" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content" style="width: 600px;">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title text-uppercase" id="exampleModalLabel">Nueva Orden</h3>
							</div>
						</div>
						<div class="modal-body">
							<form id="formOrden" name="">
								<div id="contFormOrden" class=" row d-flex ingreso-producto form-group">

									<div class=" form-group " style="width: 380px; margin-left:45px;">
										<label for="">LOCALIDAD</label>
										<select name="localidad" id="localidadO" style="width: 280px; margin-left:.5rem;" class="js-example-basic-multiple js-states typep">
											<option value="0"></option>
											<?php

											$sql = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while ($row = $result->fetch_assoc()) {
													echo "<option value=" . $row['id_localidad'] . ">" . $row['nombre_localidad'] . "</option>";
												}
											} else {
												echo "0 results";
											}
											$conn->close();
											?>
										</select>
									</div>
									<div id="productoPrincipal" class="productoPrincipal d-flex">


										<div class="col-md-4 " style="width:200px; margin-left:10px;">
											<select name="productoOrden[]" id="productoOrden" style="width:200px" class=" productoOrden js-example-responsive js-states form-control form-select ">
												<option value="0"></option>
											</select>
										</div>
										<div class="col-md-1 " style=" width:100px; margin-left:40px; padding:0;">
											<input name="cantidadPOr[]" id="cantidadPOr" class="col-md-1" style="margin:0;width: 80px;" type="number" placeholder="0" require>
										</div>
										<div class="col-md-3" style=" width:100px; margin-left:10px; padding:0;">
											<input name="descCanO" id="descCanO" class="col-md-2" style=" margin:0; width: 100px;" type="text" placeholder="UNIDADES" require>
										</div>
										<button type="button" class="btn btn-success btnAgregarFila aling-item">AGREGAR</button>
										<input type="hidden" id="btnProductUpdate" class=" btn btn-primary agregar-table" value="Finalizar Edicion">

									</div>

								</div>
								<div>
									<table id="ordenTable" data-page-length='10' class=" table table-hover table-condensed table-bordered">
										<thead>
											<tr>
												<td>Nombre Producto</td>
												<td>Cantidad</td>
												<td>Descripcion</td>
												<td>Acciones</td>
											</tr>
										</thead>
										<tbody id="row1" class="tbody">
										</tbody>
									</table>
								</div>

								<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary">REGISTRAR ORDEN</button>
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