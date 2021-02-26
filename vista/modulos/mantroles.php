<?php require './modelo/conexionbd.php'; ?>

<div class="content-wrapper">


	<section class="content-header">
	<h1>
	Mantenimiento Roles
	</h1>      
	<ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="panel"><i class="fa fa-user-plus"></i> Panel de control</a></li>
		<li class="active"><i class="fa fa-users"></i> Roles</li>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de roles</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar rol  
									</button> -->
									<button class="btn btn-default btnCrearRol glyphicon glyphicon-plus-sign" >Agregar Rol</button>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>
											<th>Rol</th>
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

											$sql = "SELECT id_rol,rol,descripcion,creado_por,fecha_creacion,modificado_por,fecha_modificacion
                                            FROM tbl_roles where estado_eliminado=1";

											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['rol'];
											$evento = array(
												'nombre_rol' => $eventos['rol'],
												'descripcion' => $eventos['descripcion'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
												'id_rol' => $eventos['id_rol']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_rol']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
													<td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarRol glyphicon glyphicon-pencil"  data-idrol="<?= $evento['id_rol'] ?>" data-nombrerol="<?= $evento['nombre_rol'] ?>" data-descripcion="<?= $evento['descripcion'] ?>"></button>

														<button class="btn btn-danger btnEliminarRol glyphicon glyphicon-remove" data-idrol="<?php echo $evento['id_rol'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarRol" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Rol</h3>
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
											<label for="">Nombre rol </label>
											<input id="nombreRol" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										<div class="campos form-group">
											<label for="">Descripcion </label>
											<input id="descripcionRol" class="form-control modal-roles secundary text-uppercase" type="tel" name="cantidad" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" />

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
				<!-- modal registrar rol -->
				<div class="modal fade" id="modalRegistrarRol" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Rol</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="" id="formRol">
									<div class=" form-group">
										

										<div class="campos">
											<label for="">Nombre rol </label>
											<input autocomplete="on" id="nombre" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										<div class="campos form-group">
											<label for="">Descripcion </label>
											<input id="descripcion" class="form-control modal-roles secundary text-uppercase" type="tel" name="cantidad" placeholde="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="" type="submit"  name="ingresarProducto" class=" btn btn-primary">Registrar rol</button>
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