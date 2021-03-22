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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Reservaciones Camping</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="reservacamping" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Reservación </i></a>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantDetReservaCTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>
											<th class="text-center">Cliente</th>
											<th class="text-center">Reservacion</th>
											<th class="text-center">Entrada</th>
											<th class="text-center">Salida</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">accion</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try{
											$sql = "SELECT id_detalle_reservacion, tbl_reservaciones.fecha_reservacion,tbl_reservaciones.fecha_entrada,
													tbl_reservaciones.fecha_salida,tbl_clientes.nombre_completo,tbl_localidad.nombre_localidad  
													FROM tbl_detalle_reservacion 
													INNER JOIN tbl_reservaciones 
													ON tbl_detalle_reservacion.reservacion_id = tbl_reservaciones.id_reservacion 
													INNER JOIN tbl_clientes 
													ON tbl_reservaciones.cliente_id=tbl_clientes.id_cliente 
													INNER JOIN tbl_habitacion_servicio 
													ON tbl_detalle_reservacion.habitacion_id = tbl_habitacion_servicio.id_habitacion_servicio 
													INNER JOIN tbl_localidad
													ON tbl_habitacion_servicio.localidad_id = tbl_localidad.id_localidad
													WHERE tbl_detalle_reservacion.estado_eliminado = 1 AND tbl_habitacion_servicio.habitacion_area LIKE '%ar%'
											 		ORDER BY id_detalle_reservacion ";
											$resultado = $conn->query($sql);
										}catch (Exception $e){
											echo  $e->getMessage();
										}
										//esta variable es para realizar un arreglo que permita mostar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['nombre_completo'];
											$mostrar = array(
												'cliente'=>$mostrar['nombre_completo'],
												'fecha_reservacion'=>$mostrar['fecha_reservacion'],
												'fecha_entrada'=>$mostrar['fecha_entrada'],
												'fecha_salida'=>$mostrar['fecha_salida'],
												'localidad'=>$mostrar['nombre_localidad'],
												'id_reservacion' =>$mostrar['id_detalle_reservacion']
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td class="text-center"><?php echo $mostrar['cliente'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_reservacion'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_entrada'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_salida'];?></td>
													<td class="text-center"><?php echo $mostrar['localidad'];?></td>
													<td class="text-center">
								
													<button class="btn btn-primary btnDetalleCamping glyphicon glyphicon-list-alt" data-idreser="<?= $mostrar['id_detalle_reservacion'] ?>"> DETALLE</button>
													<button class="btn btn-warning btnEditarCamping glyphicon glyphicon-pencil"  data-idreserva="<?= $mostrar['id_reservacion'] ?>" data-res="<?= $mostrar['fecha_reservacion'] ?>"
													data-entrad="<?= $mostrar['fecha_entrada'] ?>" data-sali="<?= $mostrar['fecha_salida'] ?>" data-client<?= $mostrar['cliente'] ?>" 
													data-localid="<?= $mostrar['localidad'] ?>""></button>
													
													<button class="btn btn-danger btnEliminarCamping glyphicon glyphicon-remove" data-idreserva="<?= $mostrar['id_reservacion'] ?>"></button>
													
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
			<!-- MODAL DETALLE RESERVACION CAMPING -->
			<div class="modal fade" id="modalDetalleCamping" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Detalle de reservaión</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formDetalleCamping">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
									</u>
									<div class="tab-content">
										<div class="active tab-pane" id="activity2">
											<div class="post"><br>
												
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
														<label for=""> </label>
														<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
													</div>
													
													<div class="campos">
													<label for="">Fecha de reservación </label>
														<input id="freserva" class="form-control modal-roles secundary" type="text" name="freserva" required />
													</div>
													<div class="campos">
														<label for="">Fecha de entrada  </label>
														<input id="fentra" class="form-control modal-roles secundary" type="text" name="fentra"required />
													</div>
													<div class="campos">
														<label for="">Fecha de salida  </label>
														<input id="fsali" class="form-control modal-roles secundary" type="text" name="fsali"required />
													</div>
													<div class="campos">
														<label for="">Habitación: </label>
														<input id="habi" class="form-control modal-roles secundary" type="text" name="habi"required />
													</div>
														
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													
													<button class="btn btn-primary btnsigguiente1" href="#settings2" data-toggle="tab">Siguiente</button>
												</div>
												
												
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings2">
											<div class="post"> <br>
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
													<h4 class="nacional">NACIONALES</h4>
													</div><br><br><br>
													<!-- <input type="hide"> -->
													<div class="col-md-7">
														<div class="campos form-group">
															<label>Precio Adulto (N):</label>
															<div class="input-group col-xs-8">
																<span class="input-group-addon">L.</span>
																<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																maxlength="4"  requiered disabled="true"
																<?php
																require ('./modelo/conexionbd.php');
																$stmt = "SELECT id_habitacion_servicio, precio_adulto_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																$resultado1 = mysqli_query($conn,$stmt);
																?>
																<?php foreach($resultado1 as $opcion):?>
																value="<?php echo $opcion['precio_adulto_nacional']?>"> 
																<?php endforeach;?>
															</div>
														</div>
														<div class="campos form-group">
															<label>Precio Niño (N):</label>
															<div class= "input-group col-xs-8">
																<span class="input-group-addon">L.</span>
																<input type="text" class="form-control" name="precioNinoN" id="precioNinoN" onkeydown="return soloNumeros(event)"  placeholder="Precio habitacion"
																maxlength="4" requiered disabled="true"
																<?php
																$stmt = "SELECT id_habitacion_servicio, precio_nino_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																$resultado1 = mysqli_query($conn,$stmt);
																?>
																<?php foreach($resultado1 as $opcion):?>
																value="<?php echo $opcion['precio_nino_nacional']?>"> 
																<?php endforeach;?>
															</div>
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Cantidad Adultos (N): </label>
														<div class=" input-group col-xs-4">
															<input id="cAdultosN" class="form-control"  type="number" min="0" name="cAdultosN" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Adultos" />
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Cantidad Niños (N): </label>
														<div class=" input-group col-xs-4">
															<input id="cNin" class="form-control"  type="number" min="0" name="cNiN" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Niños" />
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Sub Total:</label>
														<div class="input-group col-xs-4">
															<input id="subt1" class="form-control modal-roles secundary" type="text" name="subt1" onkeydown="return soloNumeros(event)" placeholder="Total a pagar"required disabled />
														</div>
													</div>
													
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity2" id="prevtab" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary " href="#settings3" id="prevtab" data-toggle="tab">Siguiente</button>
												</div>
											
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings3">
											<div class="post"> <br>
												<div class="ingreso-producto form-group">
													<div class="campos" type="hidden">
													<h4 class="extranjeros">EXTRANJEROS</h4>
													</div><br><br><br>
													<!-- <input type="hide"> -->
													<div class="col-md-7">
														<div class="campos form-group">
															<label>Precio Adulto (E):</label>
															<div class="input-group col-xs-8">
																<span class="input-group-addon">$.</span>
																<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																maxlength="4"  requiered disabled="true"
																<?php
																require ('./modelo/conexionbd.php');
																$stmt = "SELECT id_habitacion_servicio, precio_adulto_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																$resultado1 = mysqli_query($conn,$stmt);
																?>
																<?php foreach($resultado1 as $opcion):?>
																value="<?php echo $opcion['precio_adulto_extranjero']?>"> 
																<?php endforeach;?>
															</div>
														</div>
														<div class="campos form-group">
															<label>Precio Niño (E):</label>
															<div class= "input-group col-xs-8">
																<span class="input-group-addon">$.</span>
																<input type="text" class="form-control" name="precioNinoE" id="precioNinoE" onkeydown="return soloNumeros(event)"  placeholder="Precio habitacion"
																maxlength="4" requiered disabled="true"
																<?php
																$stmt = "SELECT id_habitacion_servicio, precio_nino_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																$resultado1 = mysqli_query($conn,$stmt);
																?>
																<?php foreach($resultado1 as $opcion):?>
																value="<?php echo $opcion['precio_nino_extranjero']?>"> 
																<?php endforeach;?>
															</div>
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Cantidad Adultos (E): </label>
														<div class=" input-group col-xs-4">
															<input id="cAdultosE" class="form-control"  type="number" min="0" name="cAdultosE" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Adultos" />
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Cantidad Niños (E): </label>
														<div class=" input-group col-xs-4">
															<input id="cNiE" class="form-control"  type="number" min="0" name="cNiE" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Niños" />
														</div>
													</div>
													<div class="campos form-group">
														<label for="">Sub Total:</label>
														<div class="input-group col-xs-4">
															<input id="subt1" class="form-control modal-roles secundary" type="text" name="subt1" onkeydown="return soloNumeros(event)" placeholder="Total a pagar"required disabled />
														</div>
													</div>
													
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#settings2" id="settings2" data-toggle="tab">Anterior</button>
													<button id=""type="submit" class="btn btn-primary btnregistrar">Aceptar</button>
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
			<!-- MODAL EDITAR RESERVACION CAMPING -->
			<div class="modal fade" id="modalEditarCamping" tabindex="-1"
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
						 	<form method="POST" id="formCamping">
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
													<label for="">Cliente: </label>
														<input id="client" class="form-control modal-roles secundary" type="text" name="client" required disabled />
													</div>
													<div class="campos">
													<label for="">Fecha de reservación </label>
														<input id="fReservacion" class="form-control modal-roles secundary" type="text" name="fReservacion" required disabled/>
													</div>
													<div class="campos">
														<label for="">Fecha de entrada  </label>
														<input id="fEntrada" class="form-control modal-roles secundary" type="text" name="fEntrada"required />
													</div>
													<div class="campos">
														<label for="">Fecha de salida  </label>
														<input id="fSalida" class="form-control modal-roles secundary" type="text" name="fSalida"required />
													</div>
													<div class="campos">
														<label for="">Localidad  </label>
														<input id="local" class="form-control modal-roles secundary" type="text" name="local"required disabled />
													</div>
														
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
													<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Aceptar</button>
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