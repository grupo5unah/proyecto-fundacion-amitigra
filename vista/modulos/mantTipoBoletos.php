<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
 
		<!-- Default box -->
		<div class="box">
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento de Tipos de Boletos y Descripcion</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a class=" btn btn-default glyphicon glyphicon-plus-sign"> Nuevo Tipo de Boleto </i></a>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="tablas">
									<thead>
										<tr>
											<th>Nombre Tipo de Boleto</th>
											<th>Precio de Venta</th>
											<th>Descripcion</th>
											<th>Fecha de Creacion</th>
											<th>Modificado por</th>
											<th>Fecha de Modificacion</th>											
											<th>accion</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try{
											$sql = "SELECT nombre_tipo_boleto, precio_venta, descripcion, fecha_creacion, modificado_por, fecha_modificacion  
											 FROM tbl_tipo_boletos 											 
											 WHERE estado_eliminado = 1
											 ORDER BY id_tipo_boleto ";
											$resultado = $conn->query($sql);
										}catch (Exception $e){
											echo  $e->getMessage();
										}
										//esta variable es para realizar un arreglo que permita mostrar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['nombre_tipo_boleto'];
											$mostrar = array(
												'nombre_tipo_boleto'=>$mostrar['nombre_tipo_boleto'],
												'precio_venta'=>$mostrar['precio_venta'],
												'descripcion'=>$mostrar['descripcion'],
												'fecha_creacion'=>$mostrar['fecha_creacion'],
												'modificado_por'=>$mostrar['modificado_por'],
												'fecha_modificacion'=>$mostrar['fecha_modificacion']
												
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td><?php echo $mostrar['nombre_tipo_boleto'];?></td>
													<td><?php echo $mostrar['precio_venta'];?></td>
													<td><?php echo $mostrar['descripcion'];?></td>
													<td><?php echo $mostrar['fecha_creacion'];?></td>
													<td><?php echo $mostrar['modificado_por'];?></td>
													<td><?php echo $mostrar['fecha_modificacion'];?></td>
													
													<td>
								
													<button class="btn btn-warning btnEditarHotel glyphicon glyphicon-pencil"  data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
													data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>" data-adultos="<?= $mostrar['adultos'] ?>" 
													data-ninos="<?= $mostrar['ninos'] ?>" data-total="<?= $mostrar['total'] ?>"></button>

													<button class="btn btn-danger btnEliminarHotel glyphicon glyphicon-remove" data-idreservacion="<?= $mostrar['id_detalle_reservacion'] ?>"></button>
													
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
			<!-- MODAL EDITAR RESERVACION HOTEL -->
			<div class="modal fade" id="modalEditarHotel" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar reservaión</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formHotel">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
														<label for=""> </label>
														<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
													</div>
													
													<div class="campos">
													<label for="">Fecha de reservación </label>
														<input id="fReservacion" class="form-control modal-roles secundary" type="date" name="fReservacion" required />
													</div>
													<div class="campos">
														<label for="">Fecha de entrada  </label>
														<input id="fEntrada" class="form-control modal-roles secundary" type="date" name="fEntrada"required />
													</div>
													<div class="campos">
														<label for="">Fecha de salida  </label>
														<input id="fSalida" class="form-control modal-roles secundary" type="date" name="fSalida"required />
													</div>
														
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
													<button class="btn btn-primary" href="#settings" data-toggle="tab">Siguiente</button>
												</div>
												
												
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings">
											<div class="post"> <br>
												
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
														<label for=""> </label>
														<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
													</div>
														<!-- <input type="hide"> -->
													<div class="campos">
														<label for="">Cantidad Adultos </label>
														<input id="cAdultos" class="form-control modal-roles secundary" type="text" name="cAdultos" onkeypress="return soloNumeros(event)" placeholder="Cantidad Adultos"required />
													</div>
													<div class="campos">
														<label for="">Cantidad Niños  </label>
														<input id="cNinos" class="form-control modal-roles secundary" type="text" name="cNinos" onkeypress="return soloNumeros(event)" placeholder="Cantidad Niños"required />
													</div>
													<div class="campos">
														<label for="">Total  </label>
														<input id="total" class="form-control modal-roles secundary" type="text" name="total" onkeypress="return soloNumeros(event)" placeholder="Total a pagar"required />
													</div>
													
														
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity" id="prevtab" data-toggle="tab">Anterior</button>
													<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
													<button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button>
												</div>
												
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->	
									</div> <!-- /.tab-content -->	
								</div> <!-- /.tabs-custom -->	
							</form> <!-- /.cierre de formulario -->
						</div> <!-- /.modal-body -->
						<?php 
						if(isset($_GET['msg'])){
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