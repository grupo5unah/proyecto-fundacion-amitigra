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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Reservaciones Hotel</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<?php
								if($columna["permiso_insercion"] == 1):?>
									<button type="button" class=" btn btn-success btnCrearReservacion text-uppercase"><i class="glyphicon glyphicon-plus-sign"> Nueva Reservación </i></button>
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
											<th class="text-center">Reservacion</th>
											<th class="text-center">Entrada</th>
											<th class="text-center">Salida</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">Tipo Reservación</th>
											<?php
											if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
											else:?>
											<th class="text-center">accion</th>
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
													tbl_tipo_nacionalidad.nacionalidad,tbl_localidad.nombre_localidad, reservacion_id,
													tbl_detalle_reservacion.total_pago, tbl_detalle_reservacion.creado_por  
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
												'nacion'=>$mostrar['nacionalidad'],
												'fecha_reservacion'=>$mostrar['fecha_reservacion'],
												'fecha_entrada'=>$mostrar['fecha_entrada'],
												'fecha_salida'=>$mostrar['fecha_salida'],
												'localidad'=>$mostrar['nombre_localidad'],
												'usuario'=>$mostrar['creado_por'],
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
													<td class="text-center"><?php echo "Hotel";?></td>
													<td class="text-center">
								
													<button class="btn btn-default btnDetalle glyphicon glyphicon-eye-open" data-idreserva="<?= $mostrar['numreserva'] ?>"
													data-fechreserva="<?= $mostrar['fecha_reservacion'] ?>" data-idlocal="<?= $mostrar['localidad'] ?>" data-usuario="<?= $mostrar['usuario'] ?>"
													data-total="<?= $mostrar['total'] ?>" data-cliente="<?= $mostrar['cliente'] ?>" data-identidad="<?= $mostrar['identidad'] ?>"
													data-telefono="<?= $mostrar['telefono'] ?>" data-nacion="<?= $mostrar['nacion'] ?>"></button>
													<?php
													if($columna["permiso_actualizacion"] == 1):
													?>
													<button class="btn btn-warning btnEditarReservacion glyphicon glyphicon-pencil"  data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
													data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>" data-cliente="<?= $mostrar['cliente'] ?>" 
													data-localidad="<?= $mostrar['localidad'] ?>" ></button>
													<?php
													else:
													endif;

													if($columna["permiso_eliminacion"] == 1):
													?>
													<button class="btn btn-danger btnEliminarReservacion glyphicon glyphicon-remove" data-idreser="<?= $mostrar['numreserva'] ?>"></button>
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
			<!-- MODAL NUEVA RESERVACIÓN -->
			<div class="modal fade" id="modalNuevaReserva" tabindex="-1"  data-backdrop="static" data-keyboard="false"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content modal-reserva">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar reservaión</h3>
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
												
												<div class="box-body" >
													<div class="box-header with-border">
													<h3 class="box-title">Datos Cliente</h3>
													</div> 
													<div class="col-xs-3">
														<button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
													</div><br>
													<input type="hidden" name="action" value="agregarCliente">
													<input type="hidden" id="idCliente" name="idCliente" value="" required>
													<div class="box-header with-border">
														<!-- <h3 class="box-title">Datos Cliente</h3> -->
													</div>
													<div class="box-body">
														<div class="row clientes" id="regitroClientes">
															
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
																	<!-- radio -->
																	<div class="form-group" id="radio">
																		<label>
																		<input type="radio" id="hotel" name="r1" class="minimal" value="1" disabled> Hotel
																		</label>
																		<label>
																		<input type="radio" id="camping" name="r1" class="minimal" value="2" disabled> Camping
																		</label>
																	</div>
																	<div class="form-group hotel">
																		<label for="">localidad</label><br>
																		<select class="form-control selectLocalidad" name="localidad" id="localidad">
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
																	<div class="form-group camping">
																		<label for="">localidad</label><br>
																		<select class="form-control selectLocalidad" name="localidad" id="localidad">
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
																		<input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacio_Letras(this);"
																		disabled required maxlength="60">
																	</div>
																</div>
																<div class="col-md-6">
																	<div class="campos form-group">
																		<label for="">Telefeno: </label>
																		<input id="telefono" maxlength="15"  name="telefono" class="form-control" type="tex"  placeholder="Telefono" onkeypress="return soloNumero(event)" disabled required>
																	</div>
																</div>
																<div class="col-md-6">
																<div id="guardarCliente">
																	<button type="submit" class="btnGuardarCliente" ><i class="glyphicon glyphicon-floppy-save"></i> Guardar Cliente</button>
																	<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
																</div>
																
															</div>
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" id="cancelar" data-dismiss="modal">Cerrar </button>
													<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
													<button id=""type="button" href="#timeline" class="btn btn-primary" data-toggle="tab">Siguiente</button>
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
																	<label>Fecha Entrada:</label>
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
																	<label>Fecha Salida:</label>
																	<input type="text" class="form-control" name="salida" id="salida" required>
																</div>
															</div>	
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary" href="#settings" data-toggle="tab">Siguiente</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->
										<div class="tab-pane" id="settings">
											<div class="post"><br>
												
												<div class="box-body">
													<button class="btn btn-primary  fa fa-user" id="nacionales"> Nacionales</button>
													<button class="btn btn-primary  fa fa-user" id="extranjeros"> Extranjeros</button>
													<!-- <input type="checkbox" id="check" name="check">Extranjeros -->
													
													<div class="box-body jutiapa">
														<div id="reservajutiapa">
															<div class="row nacional" id="nacionales">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Habitación:</label>
																		<select class="form-control col-md-2" name="habitacionN" id="habitacionN">
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			//include_once ('./modelo/conexionbd.php');

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
																<div class="form-group col-md-2" >
																		<label>Adulto:</label>
																		<input name="cantAN" id="cantAN" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calculo();">
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder=""  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_adulto_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_adulto_nacional']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<div class="form-group col-md-2 reserva" >
																		<label>Niños:</label>
																		<input name="cantNN" id="cantNN" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calculo();">
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="precioNinoN" id="precioNinoN" placeholder=""  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_nino_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_nino_nacional']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<input type="hidden" name="totalNJ" id="totalNJ" value="">
																<button id="btnAgregarN" class="btn btn-success btnAgregarN addnacional glyphicon glyphicon-plus-sign" > Agregar</button>
															</div><!-- row nacionales -->
															<div class="row extranjero">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Habitación:</label>
																		<select class="form-control col-md-2" name="habitacionE" id="habitacionE">
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			//include_once ('./modelo/conexionbd.php');

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
																<div class="form-group col-md-2" >
																		<label>Adulto:</label>
																		<input name="cantAE" id="cantAE" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calcular2();">
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="precioAdultoE" id="precioAdultoE" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_adulto_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_adulto_extranjero']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<div class="form-group col-md-2 reserva" >
																		<label>Niños:</label>
																		<input name="cantNE" id="cantNE" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calcular2();">
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="precioNinoE" id="precioNinoE" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_nino_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_nino_extranjero']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<input type="hidden" name="totalEJ" id="totalEJ" value="">
																<button id="btnAgregarE" class="btn btn-success   glyphicon glyphicon-plus-sign"> Agregar</button>
															</div><!-- row extranjeros-->
														</div>
														<div id="lista"></div>
															<table id="tableJutiapa" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<td class="text-center tablaJutiapa">Habitaciones</td>
																		<td class="text-center tablaJutiapa">Adultos</td>
																		<td class="text-center tablaJutiapa">P.Adultos</td>
																		<td class="text-center tablaJutiapa">Niños</td>
																		<td class="text-center tablaJutiapa">P.Niños</td>
																		<td class="text-center tablaJutiapa">Total</td>
																		<td class="text-center tablaJutiapa">Acciones</td>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
															<!-- <button id="vaciartabla" class="btn btn-primary glyphicon glyphicon-trash"> Limpiar</button> -->
														
													</div><!-- box-body -->
													
													<div class="box-body rosario">
													<div class="row nacional">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="hnr" id="hnr">
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
															<div class="form-group col-md-2" >
																	<label>Adulto:</label>
																	<input name="anr" id="anr" class="form-control col-md-2" type="number" min="0" placeholder="0" require 
																	oninput="calculaRosario();">
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="pnar" id="pnar"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true"
																	<?php
																	$stmt = "SELECT id_habitacion_servicio, precio_adulto_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																	$resultado1 = mysqli_query($conn,$stmt);
																	?>
																	<?php foreach($resultado1 as $opcion):?>
																	value="<?php echo $opcion['precio_adulto_nacional']?>"> 
																	<?php endforeach;?>
																</div>
															</div>
															<div class="form-group col-md-2 reserva" >
																	<label>Niños:</label>
																	<input name="nnr" id="nnr" class="form-control col-md-2" type="number" min="0" placeholder="0" require oninput="calculaRosario();">
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="pnnr" id="pnnr" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true"
																	<?php
																	$stmt = "SELECT id_habitacion_servicio, precio_nino_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																	$resultado1 = mysqli_query($conn,$stmt);
																	?>
																	<?php foreach($resultado1 as $opcion):?>
																	value="<?php echo $opcion['precio_nino_nacional']?>"> 
																	<?php endforeach;?>
																</div>
															</div>
															<input type="hidden" name="totalNR" id="totalNR" value="">
															<button id="btnAgregarNR" class="btn btn-success  glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row nacionales -->
														<div class="row extranjero">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="her" id="her">
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
															<div class="form-group col-md-2" >
																	<label>Adulto:</label>
																	<input name="aer" id="aer" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																	oninput="calculaRosarioE();">
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="paer" id="paer" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true"
																	<?php
																	$stmt = "SELECT id_habitacion_servicio, precio_adulto_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																	$resultado1 = mysqli_query($conn,$stmt);
																	?>
																	<?php foreach($resultado1 as $opcion):?>
																	value="<?php echo $opcion['precio_adulto_extranjero']?>"> 
																	<?php endforeach;?>
																</div>
															</div>
															<div class="form-group col-md-2 reserva" >
																	<label>Niños:</label>
																	<input name="ner" id="ner" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																	oninput="calculaRosarioE();">
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="pner" id="pner" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																	maxlength="4"  requiered disabled="true"
																	<?php
																	$stmt = "SELECT id_habitacion_servicio, precio_nino_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=1";
																	$resultado1 = mysqli_query($conn,$stmt);
																	?>
																	<?php foreach($resultado1 as $opcion):?>
																	value="<?php echo $opcion['precio_nino_extranjero']?>"> 
																	<?php endforeach;?>
																</div>
															</div>
															<input type="hidden" name="totalER" id="totalER" value="">
															<button id="btnAgregarER" class="btn btn-success  glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row extranjeros-->
														<div id="lista">
															<table id="tableRosario" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<td class="tablaRosario">Habitaciones</td>
																		<td class="tablaRosario">Adultos</td>
																		<td class="tablaRosario">P.Adultos</td>
																		<td class="tablaRosario">Niños</td>
																		<td class="tablaRosario">P.Niños</td>
																		<td class="tablaRosario">Total</td>
																		<td class="tablaRosario">Acciones</td>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>
													</div><!-- box-body -->
													<div class="box-body camping">
														<button class="btn btn-warning btnArticulos fa fa-list"> Articulos</button><br>
														<div class="row nacional">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Area:</label>
																		<select class="form-control col-md-2" name="area" id="area">
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
																	</div>
																	
																</div>
																<div class="form-group col-md-2" >
																		<label>Adulto:</label>
																		<input name="anc" id="anc" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calcularCampingNacional();">
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="pac" id="pac" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_adulto_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_adulto_nacional']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<div class="form-group col-md-2 reserva" >
																		<label>Niños:</label>
																		<input name="nnc" id="nnc" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calcularCampingNacional();">
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="pnnc" id="pnnc" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_nino_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_nino_nacional']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<input type="hidden" name="totalNC" id="totalNC" value="" oninput="calcularTotalesCamping();">
																<button id="btnAgregarNC" class="btn btn-success  glyphicon glyphicon-plus-sign"> Agregar</button>
															</div><!-- row nacionales -->
															<div class="row extranjero">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Area:</label>
																		<select class="form-control col-md-2" name="areae" id="areae">
																			<option value="" disabled selected>Selecione...</option>
																			<?php 
																			//include_once ('./modelo/conexionbd.php');

																			$stmt = "SELECT id_habitacion_servicio, habitacion_area, estado_id FROM tbl_habitacion_servicio
																						WHERE habitacion_area LIKE '%area%' AND localidad_id = 1 AND estado_id = 4";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
																			<?php endforeach;?>
																		</select> 
																	</div>
																	
																</div>
																<div class="form-group col-md-2" >
																		<label>Adulto:</label>
																		<input name="aec" id="aec" class="form-control col-md-2" type="number" min="0" placeholder="0" require oninput="calcularCampingExtranjero();">
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="paec" id="paec" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_adulto_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_adulto_extranjero']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<div class="form-group col-md-2 reserva" >
																		<label>Niños:</label>
																		<input name="nec" id="nec" class="form-control col-md-2" type="number" min="0" placeholder="0" require
																		oninput="calcularCampingExtranjero();">
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="pnec" id="pnec" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
																		maxlength="4"  requiered disabled="true"
																		<?php
																		$stmt = "SELECT id_habitacion_servicio, precio_nino_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
																		$resultado1 = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado1 as $opcion):?>
																		value="<?php echo $opcion['precio_nino_extranjero']?>"> 
																		<?php endforeach;?>
																	</div>
																</div>
																<input type="hidden" name="totalEC" id="totalEC" value="" oninput="calcularTotalesCamping();">
																<button id="btnAgregarEC" class="btn btn-success  glyphicon glyphicon-plus-sign"> Agregar</button>
															</div><!-- row extranjeros-->
															<div id="lista">
																<table id="tableCamping" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																	<thead>
																		<tr>
																			<td class="tablaCamping">Descripcion</td>
																			<td class="tablaCamping">Adultos</td>
																			<td class="tablaCamping">P.Adultos</td>
																			<td class="tablaCamping">Niños</td>
																			<td class="tablaCamping">P.Niños</td>
																			<td class="tablaCamping">cantidad Articulo</td>
																			<td class="tablaCamping">P.Articulo</td>
																			<td class="tablaCamping"> Sub-Total</td>
																			<td class="tablaCamping">Acciones</td>
																		</tr>
																	</thead>
																	<tbody>
																	</tbody>
																	<!-- <div class="total-camping input-group col-xs-4">
																		<label for="">Total:</label>
																		<input type="text" class="form-control" id="totalCamping" disabled>
																	</div> -->
																</table>
															</div>
													</div><!-- box-body -->
													
														
													
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id']; ?>">
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
													<button class="btn btn-default" href="#timeline" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary" id="registro" data-toggle="tab">Registrar Reservación</button>
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
			<!-- MODAL ARTICULOS -->
			<div class="modal fade" id="modalArticulos" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content" style="width: 600px;">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Artículos</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formArticulos">
							 	<div class="box-body">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>Tipo Tienda:</label>
												<select class="form-control col-md-2" name="tipotienda" id="tipotienda">
													<option value="" disabled selected>Selecione...</option>
													<?php 
													//include_once ('./modelo/conexionbd.php');

													$stmt = "SELECT id_producto, nombre_producto FROM tbl_producto
																WHERE nombre_producto LIKE '%Ti%'";
													$resultado = mysqli_query($conn,$stmt);
													?>
													<?php foreach($resultado as $opciones):?>
													<option value="<?php echo $opciones['id_producto']?>"><?php echo $opciones['nombre_producto']?></option>
													<?php endforeach;?>
												</select> 
											</div>
											
										</div>
										<!-- este div es para cuando sellecione la tienda para 2 personas -->
										<div id="tienda2">
											<div class="form-group col-md-2" >
													<label>Cantidad:</label>
													<input name="canTi" id="canTi" class="form-control col-md-2" type="number" min="0" placeholder="0" require oninput="calcularCamping();">
											</div>
											<div class="form-group col-xs-5">
												<label>Precio Tienda:</label>
												<div class="input-group col-xs-6">
													<span class="input-group-addon">L.</span>
													<input type="text" class="form-control" name="precioT2" id="precioT2" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
													maxlength="4"  requiered disabled="true"
													<?php
													$stmt = "SELECT id_producto, precio_alquiler FROM tbl_producto WHERE id_producto = 1";
													$resultado1 = mysqli_query($conn,$stmt);
													?>
													<?php foreach($resultado1 as $opcion):?>
													value="<?php echo $opcion['precio_alquiler']?>"> 
													<?php endforeach;?>
												</div>
											</div>
											<input type="hidden" name="totaltienda2" id="totaltienda2" value="">
										</div>
										<!-- este div es para cuando sellecione la tienda para 4 personas -->
										<div id="tienda4">
											<div class="form-group col-md-2" >
													<label>Cantidad:</label>
													<input name="canTi4" id="canTi4" class="form-control col-md-2" type="number" min="0" placeholder="0" require oninput="calcularCamping();">
											</div>
											<div class="form-group col-xs-5">
												<label>Precio Tienda:</label>
												<div class="input-group col-xs-6">
													<span class="input-group-addon">L.</span>
													<input type="text" class="form-control" name="precioT4" id="precioT4" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
													maxlength="4"  requiered disabled="true" oninput="calcularCamping4();"
													<?php
													$stmt = "SELECT id_producto, precio_alquiler FROM tbl_producto WHERE id_producto = 2";
													$resultado1 = mysqli_query($conn,$stmt);
													?>
													<?php foreach($resultado1 as $opcion):?>
													value="<?php echo $opcion['precio_alquiler']?>"> 
													<?php endforeach;?>
												</div>
											</div>
											<input type="hidden" name="totaltienda4" id="totaltienda4" value="">
										</div>
										<!-- este div es para cuando sellecione la tienda para 6 personas -->
										<div id="tienda6">
											<div class="form-group col-md-2" >
													<label>Cantidad:</label>
													<input name="canTi6" id="canTi6" class="form-control col-md-2" type="number" min="0" placeholder="0" require oninput="calcularCamping();">
											</div>
											<div class="form-group col-xs-5">
												<label>Precio Tienda:</label>
												<div class="input-group col-xs-6">
													<span class="input-group-addon">L.</span>
													<input type="text" class="form-control" name="precioT6" id="precioT6" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
													maxlength="4"  requiered disabled="true"
													<?php
													$stmt = "SELECT id_producto, precio_alquiler FROM tbl_producto WHERE id_producto = 3";
													$resultado1 = mysqli_query($conn,$stmt);
													?>
													<?php foreach($resultado1 as $opcion):?>
													value="<?php echo $opcion['precio_alquiler']?>"> 
													<?php endforeach;?>
												</div>
											</div>
											<input type="hidden" name="totaltienda6" id="totaltienda6" value="">
										</div>
										
									</div><!-- row tienda -->
									<div class="row">
										<br>
										<div class="col-md-4">
											<strong><input type="checkbox" id="checks" name="checks"> Sleeping Bag</strong>
										</div>
										<div id="sleeping">
											<div class="form-group col-md-2" >
													<label>Cantidad:</label>
													<input name="canS" id="canS" class="form-control col-md-2" type="number" min="0" placeholder="0" require
													oninput="calcularSleeping();">
											</div>
											<div class="form-group col-xs-5">
												<label>Precio Sleeping:</label>
												<div class="input-group col-xs-6">
													<span class="input-group-addon">L.</span>
													<input type="text" class="form-control" name="precioS" id="precioS" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
													maxlength="4"  requiered disabled="true"
													<?php
													$stmt = "SELECT id_producto, precio_alquiler FROM tbl_producto WHERE id_producto = 4";
													$resultado1 = mysqli_query($conn,$stmt);
													?>
													<?php foreach($resultado1 as $opcion):?>
													value="<?php echo $opcion['precio_alquiler']?>"> 
													<?php endforeach;?>
												</div>
											</div>
										</div>
										<input type="hidden" name="totalSleep" id="totalSleep" value="">
									</div><!-- row sleeping --> <br>
									
									<button id="btnAgregarAC" class="btn btn-success  glyphicon glyphicon-plus-sign"> Agregar</button>
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
											<th>Descripción</th>
											<th>Adultos</th>
											<th>P.Adulto</th>
											<th>Niños</th>
											<th>P.Niños</th>
											<th>Articulos</th>
											
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
									<button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
									<!-- <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a> -->
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
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar reservaión</h3>
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
<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>