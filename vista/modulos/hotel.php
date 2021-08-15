<?php include("./modelo/conexionbd.php");

$id_objeto = 10;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_eliminacion, permiso_actualizacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "asistente"){
  if($columna["permiso_consulta"] == 1){

?>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Reservaciones Hotel y Camping</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<?php
								if($columna["permiso_insercion"] == 1):?>
									<button type="button" class=" btn btn-success btnCrearReservacion text-uppercase"><i class="glyphicon glyphicon-plus-sign"> AGREGAR NUEVA RESERVACIÓN </i></button>
								<?php
								else:
								endif;?>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantDetReservaTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>
											<th class="text-center">N°</th>
											<th class="text-center">Cliente</th>
											<th class="text-center">Reservación</th>
											<th class="text-center">Entrada</th>
											<th class="text-center">Salida</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">Tipo Reservación</th>
											<?php
											if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
											else:?>
											<th class="text-center">Acciones</th>
											<?php
											endif;
											?>
										</tr>
									</thead>
									<tbody>
										<?php
										try{
											$sql = "SELECT id_detalle_reservacion, tbl_reservaciones.fecha_reservacion,tbl_reservaciones.fecha_entrada, 
											tbl_reservaciones.fecha_salida,tbl_clientes.nombre_completo, tbl_clientes.identidad, tbl_clientes.telefono,
											tbl_tipo_nacionalidad.nacionalidad,tbl_localidad.nombre_localidad, reservacion_id, tbl_habitacion_servicio.habitacion_area,
											tbl_producto.nombre_producto, id_inventario, tbl_detalle_reservacion.total_pago, tbl_detalle_reservacion.creado_por, tbl_reservaciones.tipo_reservacion 
											FROM tbl_detalle_reservacion 
																								INNER JOIN tbl_reservaciones 
																								ON tbl_detalle_reservacion.reservacion_id = tbl_reservaciones.id_reservacion 
																								INNER JOIN tbl_clientes 
																								ON tbl_reservaciones.cliente_id=tbl_clientes.id_cliente 
																								INNER JOIN tbl_tipo_nacionalidad
																								ON tbl_clientes.tipo_nacionalidad = tbl_tipo_nacionalidad.id_tipo_nacionalidad
																								INNER JOIN tbl_habitacion_servicio 
																								ON tbl_detalle_reservacion.habitacion_id = tbl_habitacion_servicio.id_habitacion_servicio 
																								INNER JOIN tbl_localidad
																								ON tbl_habitacion_servicio.localidad_id = tbl_localidad.id_localidad
																								INNER JOIN tbl_inventario i
																								ON tbl_detalle_reservacion.inventario_id = i.id_inventario
																								INNER JOIN tbl_producto
																								ON i.producto_id= tbl_producto.id_producto
																								WHERE tbl_detalle_reservacion.estado_eliminado = 1
											 		ORDER BY tbl_reservaciones.fecha_reservacion ASC ";
											$resultado = $conn->query($sql);
										}catch (Exception $e){
											echo  $e->getMessage();
										}
										//esta variable es para realizar un arreglo que permita mostar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['nombre_completo'];
											$mostrar = array(
												'numreserva'=>$mostrar['reservacion_id'],
												'cliente'=>$mostrar['nombre_completo'],
												'identidad'=>$mostrar['identidad'],
												'telefono'=>$mostrar['telefono'],
												'habitacion_area'=>$mostrar['habitacion_area'],
												'nombre_producto'=>$mostrar['nombre_producto'],
												'nacion'=>$mostrar['nacionalidad'],
												'fecha_reservacion'=>$mostrar['fecha_reservacion'],
												'fecha_entrada'=>$mostrar['fecha_entrada'],
												'fecha_salida'=>$mostrar['fecha_salida'],
												'localidad'=>$mostrar['nombre_localidad'],
												'usuario'=>$mostrar['creado_por'],
												'tipo_reservacion'=>$mostrar['tipo_reservacion'],
												'total'=>$mostrar['total_pago'],
												'id_reservacion' =>$mostrar['id_detalle_reservacion']
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td class="text-center"><?php echo $mostrar['numreserva'];?></td>
													<td class="text-center"><?php echo $mostrar['cliente'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_reservacion'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_entrada'];?></td>
													<td class="text-center"><?php echo $mostrar['fecha_salida'];?></td>
													<td class="text-center"><?php echo $mostrar['localidad'];?></td>
													<td class="text-center"><?php echo $mostrar['tipo_reservacion'];?></td>
													<td class="text-center">
								
													<button class="btn btn-default btnDetalle glyphicon glyphicon-eye-open" data-idreserva="<?= $mostrar['numreserva'] ?>"
													data-iddetallereserva="<?= $mostrar['id_reservacion']; ?>"
													data-fechreserva="<?= $mostrar['fecha_reservacion'] ?>" data-idlocal="<?= $mostrar['localidad'] ?>" data-usuario="<?= $mostrar['usuario'] ?>"
													data-total="<?= $mostrar['total'] ?>" data-cliente="<?= $mostrar['cliente'] ?>" data-identidad="<?= $mostrar['identidad'] ?>"
													data-telefono="<?= $mostrar['telefono'] ?>" data-nacion="<?= $mostrar['nacion'] ?>"></button>
													<?php
													if($columna["permiso_actualizacion"] == 1):
													?>
													<button class="btn btn-warning btnEditarReservacion glyphicon glyphicon-pencil"  data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
													data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>" data-cliente="<?= $mostrar['cliente']?>" 
													data-localidad="<?= $mostrar['localidad'] ?>" ></button>
													<?php
													else:
													endif;

													if($columna["permiso_eliminacion"] == 1):
													?>
													<button class="btn btn-primary btnSalida glyphicon glyphicon-log-out" data-idreservasali="<?= $mostrar['numreserva'] ?>"
													data-idsalidareserva="<?= $mostrar['id_reservacion']; ?>" data-habiarea =" <?= $mostrar['habitacion_area'] ?>" 
													data-arti =" <?= $mostrar['nombre_producto'] ?>" 
													data-usuario="<?= $mostrar['usuario'] ?>" data-salidacliente="<?= $mostrar['cliente']?>"></button>
													<button class="btn btn-danger btnEliminarReservacion glyphicon glyphicon-remove cancelacioneliminarreserva" data-idreser="<?= $mostrar['numreserva'] ?>"></button>
													<?php
													else:
													endif;
													?>
													
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

			<!-- MODAL Tipo de reservacion -->
			<div class="modal fade" id="tipoReserva" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" id="cancelar2" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Tipo de reservación</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="">
							 	<div class="box-body">
									<div class="row">
										<p class="text-center">¿Que tipo de reservación desea realizar?</p>
									</div><br>
									<div class="text-center">
										<button id="Hotel" class="btn btn-primary  glyphicon glyphicon-bed"> HOTEL</button>
										<button id="Camping" class="btn btn-success  glyphicon glyphicon-tent"> CAMPING</button>
										<br><br>
										<button id="" class="btn btn-danger">CANCELAR</button>
									</div>
								</div>
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
			<!-- MODAL NUEVA RESERVACIÓN PARA HOTEL -->
			<div class="modal fade" id="modalReservaHotel" tabindex="-1"  data-backdrop="static" data-keyboard="false"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content modal-reserva">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" id="" class="close cancelacionhotel" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar reservación hotel</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formReserva" onpaste="return false" autocomplete="off">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content" >
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="box-body" id="regitroClientes" >
													<div class="box-header with-border">
													<h3 class="box-title">Datos Cliente</h3>
													</div> 
													<div class="col-xs-3">
														<button class="btn btn-success btnCrearCliente glyphicon glyphicon-plus-sign" > AGREGAR NUEVO CLIENTE</button>
													</div><br>
													<input type="hidden" name="action" value="agregarCliente">
													<input type="hidden" id="idCliente" name="idCliente" value="" required>
													<div class="box-header with-border">
														<!-- <h3 class="box-title">Datos Cliente</h3> -->
													</div>
													<div class="box-body">
														<div class="row clientes">
															
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Identidad:</label>
																		<input type="text" class="form-control" name="identidad" id="identidad" placeholder="Identidad"  required
																		maxlength="13" onkeypress="return soloNumero(event)"> 
																	</div>
																	<div class="form-group">
																		<label for="">Nacionalidad: </label>
																		<select class="form-control" name="nacionalidad" id="nacionalidad" disabled required>
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			include ('./modelo/conexionbd.php');

																			$stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
																			<?php endforeach;?>
																		</select>
																	</div>
																	<br><br>
																	<div class="form-group">
																		<label for="">localidad</label><br>
																		<select class="form-control selectLocalidad" name="localidad" id="localidad" disabled>
																		<option value="" disabled selected>Selecione...</option>
																		<?php
																		require ('./modelo/conexionbd.php');

																		$stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
																		$resultado = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado as $opciones):?>
																		<option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
																		<?php endforeach;?>
																		</select>
																	</div>
																	
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Cliente:</label>
																		<input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacio_Letras(this);"
																		disabled required maxlength="60">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="campos form-group">
																		<label for="">Teléfeno: </label>
																		<input id="telefono" maxlength="15"  name="telefono" class="form-control" type="tex"  placeholder="Telefono" onkeypress="return soloNumero(event)" disabled required>
																	</div>
																</div>
																<div class="col-md-6">
																<div id="guardarCliente">
																	<button type="submit" class="btnGuardarCliente btn btn-success" ><i class=""></i>Guardar</button>
																	<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
																</div>
																
															</div>
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button type="button" class="btn btn-danger cancelacionhotel" id="" data-dismiss="modal">Cancelar </button>
													<button id=""type="button" href="#timeline" class="btn btn-primary siguiente1" data-toggle="tab" disabled>Siguiente</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="timeline">
											<div class="post"><br>
												
												<div class="box-body">
													<div class="box-header with-border">
													<h3 class="box-title"> Fechas</h3>
													</div>
													<div class="box-body">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Fecha de reservación:</label>
																	<input type="text" class="form-control" name="reservacion" id="reservacion" required
																	maxlength="13" 
																	<?php
																		date_default_timezone_set("America/Tegucigalpa");
																		$fecha=date('Y-m-d H:i:s',time());
																	?> value="<?php echo $fecha;?>" disabled="true"> 
																</div>
																<div class="form-group">
																	<label>Fecha entrada:</label>
																	<input type="text" class="form-control" name="entrada" id="entrada" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label></label>
																	<input type="hidden" class="form-control" name="" id="" required>
																</div>
															</div>
															<div class="col-md-6 salida">
																<div class="form-group">
																	<label>Fecha salida:</label>
																	<input type="text" class="form-control" name="salida" id="salida" required>
																</div>
															</div>	
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary" href="#settings" data-toggle="tab" >Siguiente</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings">
											<div class="post"><br>
												
												<div class="box-body">
													<div class="form-group col-md-4">
														<label for="">Nacionalidad: </label>
														<select class="form-control" name="nacionalid" id="nacionalid"  required>
															<option value="" disabled selected>Selecione...</option>
															<?php 
															include ('./modelo/conexionbd.php');

															$stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
															$resultado = mysqli_query($conn,$stmt);
															?>
															<?php foreach($resultado as $opciones):?>
															<option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
															<?php endforeach;?>
														</select>
													</div>
													
													<div class="box-body jutiapa">
														<div id="reservajutiapa">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group habitacion">
																		<label>Habitación:</label>
																		<select class="form-control col-md-2" name="habitacionN" id="habitacionN" disabled>
																			<option value="" disabled selected>Selecione...</option>
																			<?php

																			$stmt = "SELECT id_habitacion_servicio, habitacion_area, estado_id FROM tbl_habitacion_servicio
																						WHERE habitacion_area LIKE '%h%' AND localidad_id = 1 AND estado_id = 4";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
																			<?php endforeach;?>
																		</select> 
																	</div>
																	
																</div>
																<div class="form-group col-md-2 adultojutiapa" >
																		<label>Adulto:</label>
																		<input name="cantAN" id="cantAN" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																		oninput="calculo();">
																</div>
																<div class="form-group col-xs-4 preadult">
																	<label>Precio:</label>
																	<div class="input-group col-xs-4 ">
																		<span class="input-group-addon moned"></span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder=""  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true">
																	</div>
																</div>
																<div class="form-group col-md-2 reserva" >
																		<label>Niños:</label>
																		<input name="cantNN" id="cantNN" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																		oninput="calculo();">
																</div>
																<div class="form-group col-xs-4 precioh">
																	<label>Precio:</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon moned"></span>
																		<input type="text" class="form-control " name="precioNinoN" id="precioNinoN" placeholder=""  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true">
																	</div>
																</div>
																<input type="hidden" name="totalNJ" id="totalNJ" value="">
																<button id="btnAgregarN" class="btn btn-success btnAgregarN addnacional glyphicon glyphicon-plus-sign" ></button>
															</div>
														</div>
														<!-- <div id="lista"></div> -->
															<table id="tableJutiapa" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<th class="text-center tablaJutiapa">#</th>
																		<th class="text-center tablaJutiapa">Habitaciones</th>
																		<th class="text-center tablaJutiapa">Adultos</th>
																		<th class="text-center tablaJutiapa">Precio</th>
																		<th class="text-center tablaJutiapa">Niños</th>
																		<th class="text-center tablaJutiapa">Precio</th>
																		<th class="text-center tablaJutiapa">Total</th>
																		<th class="text-center tablaJutiapa">Acciones</th>
																	</tr>
																</thead>
																<tbody class="hotelju">
																</tbody>
															</table>
															<!-- <button id="vaciartabla" class="btn btn-primary glyphicon glyphicon-trash"> Limpiar</button> -->
														
													</div><!-- box-body -->
													
													<div class="box-body rosario">
													<div class="row">
															<div class="col-md-4">
																<div class="form-group habitac">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="hnr" id="hnr" disabled>
																		<option value="" disabled selected>Selecione...</option>
																		<?php 
																		//include_once ('./modelo/conexionbd.php');

																		$stmt = "SELECT id_habitacion_servicio, habitacion_area, estado_id FROM tbl_habitacion_servicio
																					WHERE habitacion_area LIKE '%h%' AND localidad_id = 2 AND estado_id = 4";
																		$resultado = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado as $opciones):?>
																		<option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
																		<?php endforeach;?>
																	</select> 
																</div>
																
															</div>
															<div class="form-group col-md-2 adultorosario" >
																	<label>Adulto:</label>
																	<input name="anr" id="anr" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																	oninput="calculaRosario();">
															</div>
															<div class="form-group col-xs-4 precioadultr">
																<label>Precio:</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon mone"></span>
																	<input type="text" class="form-control" name="pnar" id="pnar"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true">
																</div>
															</div>
															<div class="form-group col-md-2 reserva" >
																	<label>Niños:</label>
																	<input name="nnr" id="nnr" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																	 oninput="calculaRosario();">
															</div>
															<div class="form-group col-xs-4 precioh">
																<label>Precio:</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon mone"></span>
																	<input type="text" class="form-control" name="pnnr" id="pnnr" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true">
																</div>
															</div>
															<input type="hidden" name="totalNR" id="totalNR" value="">
															<button id="btnAgregarNR" class="btn btn-success  glyphicon glyphicon-plus-sign"></button>
														</div>
														<!-- <div id="listados"></div> -->
														<table id="tableRosario" data-page-length='10' class=" table table-hover table-condensed table-bordered">
															<thead>
																<tr>
																	<th class="text-center tablaJutiapa">#</th>
																	<td class="tablaRosario">Habitaciones</td>
																	<td class="tablaRosario">Adultos</td>
																	<td class="tablaRosario">Precio</td>
																	<td class="tablaRosario">Niños</td>
																	<td class="tablaRosario">Precio</td>
																	<td class="tablaRosario">Total</td>
																	<td class="tablaRosario">Acciones</td>
																</tr>
															</thead>
															<tbody class="hotelro">
															</tbody>
														</table>
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<input type="hidden" name="tipo_hotel" id="tipo_hotel" value="Hotel">
													<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id']; ?>">
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
													<button class="btn btn-default" href="#timeline" data-toggle="tab">Anterior</button>
													<button class="btn btn-success" id="registre" data-toggle="tab">Registrar</button>
													<button class="btn btn-success" id="registro" data-toggle="tab">Registrar</button>
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

			<!-- MODAL NUEVA RESERVACION CAMPING -->
			<div class="modal fade" id="modalReservaCamping" tabindex="-1"  data-backdrop="static" data-keyboard="false"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content modal-reserva">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" id="" class="close cancelacioncamping" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar reservación camping</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" onpaste="return false" id="formCamping" autocomplete="off">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content" >
										<div class="active tab-pane" id="activity3">
											<div class="post"><br>
												
												<div class="box-body" id="regitroClientes" >
													<div class="box-header with-border">
													<h3 class="box-title">Datos Cliente</h3>
													</div>
													<div class="col-xs-3">
														<button class="btn btn-success btnCrearClient glyphicon glyphicon-plus-sign" > AGREGAR NUEVO CLIENTE</button>
													</div><br>
													<input type="hidden" name="action" value="addCliente">
													<input type="hidden" id="idClient" name="idClient" value="" required>
													<div class="box-header with-border">
														<!-- <h3 class="box-title">Datos Cliente</h3> -->
													</div>
													<div class="box-body">
														<div class="row clientes">
															
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Identidad:</label>
																		<input type="text" class="form-control" name="identi" id="identi" placeholder="Identidad"  required
																		maxlength="13" onkeypress="return soloNumero(event)"> 
																	</div>
																	<div class="form-group">
																		<label for="">Nacionalidad: </label>
																		<select class="form-control" name="nacion" id="nacion" disabled required>
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			include ('./modelo/conexionbd.php');

																			$stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
																			<?php endforeach;?>
																		</select>
																	</div>
																	<br><br>
																	<div class="form-group">
																		<label for="">localidad</label><br>
																		<select class="form-control selectLocal" name="localidad" id="localidad" disabled>
																		<option value="" disabled selected>Selecione...</option>
																		<?php
																		require ('./modelo/conexionbd.php');

																		$stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad
																		WHERE nombre_localidad LIKE '%JU%'";
																		$resultado = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado as $opciones):?>
																		<option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
																		<?php endforeach;?>
																		</select>
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Cliente:</label>
																		<input type="text" class="form-control" name="client" id="client" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacio_Letras(this);"
																		disabled required maxlength="60">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="campos form-group">
																		<label for="">Telefeno: </label>
																		<input id="tele" maxlength="15"  name="tele" class="form-control" type="tex"  placeholder="Telefono" onkeypress="return soloNumero(event)" disabled required>
																	</div>
																</div>
																<div class="col-md-6">
																<div id="guardarClient">
																	<button type="submit" class="btnGuardarCliente btn btn-success" ><i class=""></i>Guardar</button>
																	<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
																</div>
																
															</div>
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button type="button" class="btn btn-danger cancelacioncamping" id="" data-dismiss="modal">Cancelar </button>
													<button id=""type="button" href="#timeline3" class="btn btn-primary siguiente1" data-toggle="tab" disabled>Siguiente</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="timeline3">
											<div class="post"><br>
												
												<div class="box-body">
													<div class="box-header with-border">
													<h3 class="box-title"> Fechas</h3>
													</div>
													<div class="box-body">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Fecha de reservación:</label>
																	<input type="text" class="form-control" name="reserva" id="reserva" required
																	maxlength="13" 
																	<?php
																		date_default_timezone_set("America/Tegucigalpa");
																		$fecha=date('Y-m-d H:i:s',time());
																	?> value="<?php echo $fecha;?>" disabled="true"> 
																</div>
																<div class="form-group">
																	<label>Fecha Entrada:</label>
																	<input type="text" class="form-control" name="entra" id="entra" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label></label>
																	<input type="hidden" class="form-control" name="" id="" required>
																</div>
															</div>
															<div class="col-md-6 salida">
																<div class="form-group">
																	<label>Fecha Salida:</label>
																	<input type="text" class="form-control" name="sale" id="sale" required>
																</div>
															</div>	
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity3" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary" href="#settings4" data-toggle="tab">Siguiente</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings4">
											<div class="post"><br>
												
												<div class="box-body">
													<div class="form-group col-md-4">
														<label for="">Nacionalidad: </label>
														<select class="form-control" name="nacionali" id="nacionali"  required>
															<option value="" disabled selected>Selecione...</option>
															<?php 
															include ('./modelo/conexionbd.php');

															$stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
															$resultado = mysqli_query($conn,$stmt);
															?>
															<?php foreach($resultado as $opciones):?>
															<option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
															<?php endforeach;?>
														</select>
													</div>
													<div class="box-body">
														<!-- <button class="btn btn-warning btnArticulos fa fa-list"> Articulos</button><br> -->
														<div class="row ">
																<div class="col-md-4 area">
																	<div class="form-group">
																		<label>Area:</label>
																		<select class="form-control col-md-2" name="area" id="area" disabled>
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			//include_once ('./modelo/conexionbd.php');

																			$stmt = "SELECT id_habitacion_servicio, habitacion_area, estado_id FROM tbl_habitacion_servicio
																						WHERE habitacion_area LIKE '%are%' AND localidad_id = 1 AND estado_id = 4";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
																			<?php endforeach;?>
																		</select> 
																	</div><br><br>
																</div>
																<div class="form-group col-md-2 adulto" >
																		<label>Adulto:</label>
																		<input name="anc" id="anc" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																		oninput="calcularCampingNacional();">
																</div>
																<div class="form-group col-xs-4 precioadulto">
																	<label>Precio:</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon moneda"></span>
																		<input type="text" class="form-control" name="pac" id="pac" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"> 
																		
																	</div>
																</div>
																<div class="form-group col-md-2 niños" >
																		<label>Niños:</label>
																		<input name="nnc" id="nnc" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																		oninput="calcularCampingNacional();">
																</div>
																<div class="form-group col-xs-4 precioniño">
																	<label>Precio:</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon moneda"></span>
																		<input type="text" class="form-control" name="pnnc" id="pnnc" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true">
																	</div>
																</div>
																<div class="form-group col-md-2 canA" >
																	<label>Cantidad:</label>
																	<input name="canTi" id="canTi" class="form-control col-md-2" type="number" min="0" placeholder="0" require disabled
																	oninput="calcularCampingNacional();">
																</div>
																<div class="form-group col-md-4 canT">
																	<label>Tipo Tienda:</label><br>
																	<select id="lista1" class="form-control col-md-2" name="lista1" disabled>
																		<?php
																			include_once ('./modelo/conexionbd.php');
																		$stmt = "SELECT id_producto, nombre_producto FROM tbl_producto
																		WHERE nombre_producto LIKE '%Ti%' OR nombre_producto LIKE '%ninguno%' 
																		OR nombre_producto LIKE '%sleeping%'";
																		$resultado = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado as $opciones):?>
																		<option value="<?php echo $opciones['id_producto']?>"><?php echo $opciones['nombre_producto']?></option>
																		<?php endforeach;?>
																	</select>
																	
																</div>
																<div class="form-group col-xs-2">
																<input type="text" class="form-control col-xs-4" id="miprecio" value="" disabled>
																</div>
																<input type="hidden" name="totalNC" id="totalNC" value="">
																<button id="btnAgregarNC" class="btn btn-success  glyphicon glyphicon-plus-sign" disabled> Agregar</button>
														</div><!-- row nacionales -->
															<!-- <div id="listaC"></div> -->
															<table id="tableCamping" data-page-length='10' class=" table table-hover table-condensed table-bordered campinge">
																<thead>
																	<tr>
																		<td class="tablaCamping">#</td>
																		<td class="tablaCamping">Área</td>
																		<td class="tablaCamping">Adultos</td>
																		<td class="tablaCamping">Precio</td>
																		<td class="tablaCamping">Niños</td>
																		<td class="tablaCamping">Precio</td>
																		<td class="tablaCamping">Articulo</td>
																		<td class="tablaCamping">cantidad</td>
																		<td class="tablaCamping">Precio</td>
																		<td class="tablaCamping"> Total</td>
																		<td class="tablaCamping">Acciones</td>
																	</tr>
																</thead>
																<tbody class="camp campe">
																</tbody>
															</table>
															
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													
													<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id']; ?>">
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
													<button class="btn btn-default" href="#timeline3" data-toggle="tab">Anterior</button>
													<button class="btn btn-success" id="registrar" data-toggle="tab">Registrar</button>
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
			<!-- MODAL DETALLE RESERVACION -->
			<div class="modal fade" id="modalDetalle" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content" style="width: 600px;">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Fundación AMITIGRA</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formDetalle">
							 	<div class="box-body">
								 	
									 
									 <div id="contenido">

									 </div>
									<table class="table table-striped">
										<thead>
										<tr>
											<th>N°</th>
											<th>Habitación/Área</th>
											<th>Adulto</th>
											<th>Precio</th>
											<th>Niños</th>
											<th>Precio</th>
											<th>Artículo</th>
											
										</tr>
										</thead>
										<tbody id="detalle">
										</tbody>
										
									</table>
								</div><br>
								<div id="total">

								</div>
							</form> <!-- /.cierre de formulario -->
							<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
									<button target="_blank" class="btn btn-primary" id="btnimprimir" ><i class=""></i> Imprimir</button>
									
							</div>
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

			<!-- MODAL EDITAR RESERVACION -->
			<div class="modal fade" id="modalEditarReservacion" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close cancelacioneditarreserva" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Actualizar reservación</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formReservacion">
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
														<input id="cli" class="form-control modal-roles secundary" type="text" name="cli" required disabled>
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
													<button type="button" class="btn btn-danger cancelacioneditarreserva" data-dismiss="modal">Cancelar </button>
													<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
													<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-success">Actualizar</button>
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

			<!-- MODAL SALIDA DE RESERVACION -->
						<div class="modal fade" id="modalsalidaReservacion" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close cancelacionsalidareserva" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Chequeo de salida</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formSalida">
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
														<input id="clie" class="form-control modal-roles secundary" type="text" name="clie" required disabled>
													</div>
													<div class="campos">
													<label for="">Habitación/Área </label>
														<input id="habiarea" class="form-control modal-roles secundary" type="text" name="habiarea" required disabled>
													</div>
													<div class="campos">
													<label for="">Estado: </label>
													<select class="form-control modal-roles secundary" name="estados" id="estados">
														<option value="" disabled selected>Selecione...</option>
														<?php
														require ('./modelo/conexionbd.php');

														$stmt = "SELECT id_estado, nombre_estado FROM tbl_estado
														WHERE nombre_estado = 'DISPONIBLE'";
														$resultado = mysqli_query($conn,$stmt);
														?>
														<?php foreach($resultado as $opciones):?>
														<option value="<?php echo $opciones['id_estado']?>"><?php echo $opciones['nombre_estado']?></option>
														<?php endforeach;?>
													</select>
													</div>
													<div class="campos">
														<label for="">Artículo:</label>
														<input id="artihab" class="form-control modal-roles secundary" type="text" name="artihab"required disabled/>
													</div>
													<div class="campos">
														<label for="">Movimiento:</label>
														<select class="form-control modal-roles secundary" name="movi" id="movi">
															<option value="" disabled selected>Selecione...</option>
															<?php
															require ('./modelo/conexionbd.php');

															$stmt = "SELECT id_tipo_movimiento, movimiento FROM tbl_tipo_movimiento";
															$resultado = mysqli_query($conn,$stmt);
															?>
															<?php foreach($resultado as $opciones):?>
															<option value="<?php echo $opciones['id_tipo_movimiento']?>"><?php echo $opciones['movimiento']?></option>
															<?php endforeach;?>
														</select>
													</div>
														
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
													<button type="button" class="btn btn-danger cancelacionsalidareserva" data-dismiss="modal">Cancelar </button>
													<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
													<button id="btnEditarBD"type="button" class="btnsalida btn btn-success">Actualizar</button>
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
			<!-- MODAL SALIDA 
			<div class="modal fade" id="modalsalida" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content" style="width: 600px;">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Fundación AMITIGRA</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formSalida">
							 	<div class="box-body">
								 	
									 
									 <div id="conte">

									 </div>
									<table class="table table-striped">
										<thead>
										<tr>
											<th>N°</th>
											<th>Habitacion</th>
											<th>Estado</th>
											<th>Articulos</th>
											<th>Estado</th>
											
										</tr>
										</thead>
										<tbody id="salida">
										</tbody>
										
									</table>
								</div>
								<div>

								</div>
							</form> <!-- /.cierre de formulario -->
							<div class="modal-footer">
									
							</div>
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
<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>