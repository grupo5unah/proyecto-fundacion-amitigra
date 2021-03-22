<?php require './modelo/conexionbd.php'; ?>

<div class="content-wrapper" oncopy="return false" onpaste="return false">


	<section class="content-header">
	<h1>
	Mantenimiento de Localidades y Tipo Producto
	</h1>      
	<ol class="breadcrumb ">
        <li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="btn btn-success uppercase fw-bold" ><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
		<li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fa fa-users"></i> Localidades y Tipo Producto</a></li>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Tipo Producto</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">				    <button class="btn btn-success btnCrearTipo glyphicon glyphicon-plus-sign" >AGREGAR TIPO PRODUCTO</button>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>
											<th>Nombre_Tipo_Producto</th>
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

											$sql = "SELECT id_tipo_producto,nombre_tipo_producto, creado_por,fecha_creacion,modificado_por,fecha_modificacion
                                            FROM tbl_tipo_producto where estado_eliminado=1";

											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['nombre_tipo_producto'];
											$evento = array(
												'nombre_tipoP' => $eventos['nombre_tipo_producto'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
												'id_tipoP' => $eventos['id_tipo_producto']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_tipoP']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
													<td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarTP glyphicon glyphicon-pencil"  data-idTipoP="<?= $evento['id_tipoP'] ?>" data-tipoProductoP="<?= $evento['nombre_tipoP'] ?>" ></button>

														<button class="btn btn-danger btnEliminarTP glyphicon glyphicon-remove" data-idTipo="<?php echo $evento['id_tipoP'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarTP" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Tipo Producto</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="">
									<div class="ingreso-producto form-group">
										
										<div class="campos">
											<label for="">Nombre Tipo Producto </label>
											<input id="tipo_producto" class="form-control modal-roles secundary text-uppercase" type="text"  required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

										</div>
																				
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Tipo Producto</button>
							</div>
						</div>
					</div>
				</div>
				<!-- modal registrar rol -->
				<div class="modal fade" id="modalRegistrarTP" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Tipo Producto </h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="" id="formTP">
									<div class=" form-group">
										

										<div class="campos">
											<label for="">Nombre Tipo Producto </label>
											<input  id="tipoP" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholder="Escriba el tipo producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />

										</div>
									
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="" type="submit"  name="ingresarProducto" class=" btn btn-primary">Registrar Tipo Producto</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Localidades</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar rol  
									</button> -->
									<button class="btn btn-default btnCrearLocalidad glyphicon glyphicon-plus-sign" >AGREGAR LOCALIDAD  </button>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="managerLocalidades">
									<thead>
										<tr>
											<th>Localidad</th>
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

											$sql = "SELECT id_localidad, nombre_localidad, creado_por,fecha_creacion, modificado_por, fecha_modificacion
                                            FROM tbl_localidad where estado_eliminado=1";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['nombre_localidad'];
											$evento = array(
												'localidad' => $eventos['nombre_localidad'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
												'id_localidad' => $eventos['id_localidad']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['localidad']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
													<td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarLocalidad glyphicon glyphicon-pencil"  data-idlocalidad="<?= $evento['id_localidad'] ?>" data-nombrelocalidad="<?= $evento['localidad'] ?>" ></button>

														<button class="btn btn-danger btnEliminarLocalidad glyphicon glyphicon-remove" data-idlocalidad="<?php echo $evento['id_localidad'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarLocalidad" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Localidad</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										
										<div class="campos">
											<label for="">Nombre de la localidad </label>
											<input id="localidad" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"  autocomplete="off"/>

										</div>
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Localidad</button>
							</div>
						</div>
					</div>
				</div>
				<!-- modal registrar rol -->
				<div class="modal fade" id="modalRegistrarLocalidad" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Localidad</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="" id="formLocalidad">
									<div class=" form-group">
										

										<div class="campos">
											<label for="">Nombre de la localidad</label>
											<input autocomplete="off" id="nomLocalidad" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>									
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="" type="submit"  name="ingresarProducto" class=" btn btn-primary">Registrar Localidad</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
			<!-- /.box-footer-->
		</div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>