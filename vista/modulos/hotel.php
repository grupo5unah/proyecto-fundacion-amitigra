<?php include("./modelo/conexionbd.php");

$id_objeto = 10;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
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
									<a href="#" class=" btn btn-success btnCrearReservacion text-uppercase"><i class="glyphicon glyphicon-plus-sign"> Nueva Reservación </i></a>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantDetReservaTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>
											<th class="text-center">Cliente</th>
											<th class="text-center">Reservacion</th>
											<th class="text-center">Entrada</th>
											<th class="text-center">Salida</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">Tipo Reservación</th>
											<th class="text-center">accion</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try{
											$sql = "SELECT id_detalle_reservacion, tbl_reservaciones.fecha_reservacion,tbl_reservaciones.fecha_entrada,
													tbl_reservaciones.fecha_salida,tbl_clientes.nombre_completo, tbl_localidad.nombre_localidad  
													FROM tbl_detalle_reservacion 
													INNER JOIN tbl_reservaciones 
													ON tbl_detalle_reservacion.reservacion_id = tbl_reservaciones.id_reservacion 
													INNER JOIN tbl_clientes 
													ON tbl_reservaciones.cliente_id=tbl_clientes.id_cliente 
													INNER JOIN tbl_habitacion_servicio 
													ON tbl_detalle_reservacion.habitacion_id = tbl_habitacion_servicio.id_habitacion_servicio 
													INNER JOIN tbl_localidad
													ON tbl_habitacion_servicio.localidad_id = tbl_localidad.id_localidad
													WHERE tbl_detalle_reservacion.estado_eliminado = 1 AND tbl_habitacion_servicio.habitacion_area LIKE '%ha%'
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
													<td class="text-center"><?php echo "camping";?></td>
													<td class="text-center">
								
													<button class="btn btn-default btnDetalle glyphicon glyphicon-eye-open" data-toggle="modal" data-target="" data-idreserva="<?= $mostrar['id_reservacion']?>"></button>
													<button class="btn btn-warning btnEditarHotel glyphicon glyphicon-pencil"  data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
													data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>" data-cliente="<?= $mostrar['cliente'] ?>" 
													data-localidad="<?= $mostrar['localidad'] ?>" ></button>
													
													<button class="btn btn-danger btnEliminarHotel glyphicon glyphicon-remove" data-idreser="<?= $mostrar['id_reservacion'] ?>"></button>
													
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
						 	<form method="POST" id="formReserva">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content">
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="box-body">
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
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Identidad:</label>
																	<input type="text" class="form-control" name="identidad" id="identidad" placeholder="Identidad"  required
																	maxlength="13"> 
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
																	<input type="radio" id="hotel" name="r1" class="minimal" value="1"> Hotel
																	</label>
																	<label>
																	<input type="radio" id="camping" name="r1" class="minimal" value="2"> Camping
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
																	<input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);"
																	disabled required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="campos form-group">
																	<label for="">Telefeno: </label>
																	<input id="telefono" maxlength="15"  name="telefono" class="form-control" type="tex"  placeholder="Telefono" onkeydown="return soloNumeros(event)" disabled required>
																</div>
															</div>
															<div class="col-md-6">
																<input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
																<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
															<div id="guardarCliente">
																<button type="submit" class="btnGuardarCliente" ><i class="glyphicon glyphicon-floppy-save"></i> Guardar Cliente</button>
															</div>
															</div>
															
														</div><!-- row -->
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
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
													<button class="btn btn-primary nacionales fa fa-user"> Nacionales</button>
													<button class="btn btn-primary extranjeros fa fa-user"> Extranjeros</button>
													<!-- <input type="checkbox" id="check" name="check">Extranjeros -->
													
													<div class="box-body jutiapa">
														<div class="row nacional">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
															<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row nacionales -->
														<div class="row extranjero">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
															<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row extranjeros-->
														<div>
															<table id="" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<td class="tablaJutiapa">Habitaciones</td>
																		<td class="tablaJutiapa">Adultos</td>
																		<td class="tablaJutiapa">P.Adultos</td>
																		<td class="tablaJutiapa">Niños</td>
																		<td class="tablaJutiapa">P.Niños</td>
																		<td class="tablaJutiapa">Sub Total</td>
																		<td class="tablaJutiapa">Acciones</td>
																	</tr>
																</thead>
																<tbody id="row1" class="tbody">
																</tbody>
															</table>
														</div>
													</div><!-- box-body -->
													
													<div class="box-body rosario">
													<div class="row nacional">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">L.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
															<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row nacionales -->
														<div class="row extranjero">
															<div class="col-md-4">
																<div class="form-group">
																	<label>Habitación:</label>
																	<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4">
																<label>Precio (A):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																	<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
															</div>
															<div class="form-group col-xs-4 precio">
																<label>Precio (N):</label>
																<div class="input-group col-xs-4">
																	<span class="input-group-addon">$.</span>
																	<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
															<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
														</div><!-- row extranjeros-->
														<div>
															<table id="" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<td class="tablaRosario">Habitaciones</td>
																		<td class="tablaRosario">Adultos</td>
																		<td class="tablaRosario">P.Adultos</td>
																		<td class="tablaRosario">Niños</td>
																		<td class="tablaRosario">P.Niños</td>
																		<td class="tablaRosario">Sub Total</td>
																		<td class="tablaRosario">Acciones</td>
																	</tr>
																</thead>
																<tbody id="row1" class="tbody">
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
																		<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																		<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																		<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">L.</span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
															</div><!-- row nacionales -->
															<div class="row extranjero">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Area:</label>
																		<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
																		<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
																</div>
																<div class="form-group col-xs-4">
																	<label>Precio (A):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																		<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
																</div>
																<div class="form-group col-xs-4 precio">
																	<label>Precio (N):</label>
																	<div class="input-group col-xs-4">
																		<span class="input-group-addon">$.</span>
																		<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
																<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
															</div><!-- row extranjeros-->
															<div>
																<table id="" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																	<thead>
																		<tr>
																			<td class="tablaCamping">Descripcion</td>
																			<td class="tablaCamping">Adultos</td>
																			<td class="tablaCamping">P.Adultos</td>
																			<td class="tablaCamping">Niños</td>
																			<td class="tablaCamping">P.Niños</td>
																			<td class="tablaCamping">cantidad Articulo</td>
																			<td class="tablaCamping">P.Articulo</td>
																			<td class="tablaCamping">Sub Total</td>
																			<td class="tablaCamping">Acciones</td>
																		</tr>
																	</thead>
																	<tbody id="row1" class="tbody">
																	</tbody>
																</table>
															</div>
													</div><!-- box-body -->
													
												</div><!-- box-body principal -->
												<div class="modal-footer">
													<button class="btn btn-default" href="#activity" data-toggle="tab">Anterior</button>
													<button class="btn btn-primary" href="#" data-toggle="tab">Siguiente</button>
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
												<select class="form-control col-md-2" name="habitacion" id="habitacion">
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
										<div class="form-group col-md-2" >
												<label>Cantidad:</label>
												<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
										</div>
										<div class="form-group col-xs-5">
											<label>Precio Tienda:</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
									</div><!-- row tienda -->
									<div class="row">
										<div class="col-md-4">
											<div class="form-group sleeping">
												<label>SLEEPING BAG:</label>
											</div>
											
										</div>
										<div class="form-group col-md-2" >
												<label>Cantidad:</label>
												<input name="cantidadPOr[]" id="cantidadPOr" class="form-control col-md-2" type="number" min="0" placeholder="0" require>
										</div>
										<div class="form-group col-xs-5">
											<label>Precio Sleeping:</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
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
									</div><!-- row sleeping -->
									<button class="btn btn-success btnAgregar glyphicon glyphicon-plus-sign"> Agregar</button>
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
								<h3 class="modal-title" id="exampleModalLabel">DETALLE DE RESERVACIÓN</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formDetalle">
							 	<div class="box-body">
								 	<h4>Fundación AMITIGRA</h4> 
									<span>Fecha: 
									</span><br>
									<span>Usuario: 
									</span><br>
									<span>DNI: 000-0000-00000       
									</span>
									<span>CLIENTE: xxxxxx
									</span>
									<span>TELEFONO: xxxxxx     
									</span>
									<span>NACIONALIDAD: xxxxxxx
									</span>
									<table class="table table-striped">
										<thead>
										<tr>
											<th>Habitacion/Area</th>
											<th>Articulo</th>
											<th>Adultos</th>
											<th>Niños</th>
											<th>Subtotal</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>xxx</td>
												<td>2</td>
												<td>1</td>
												<td>L.64.50</td>
											</tr>
										
										</tbody>
									</table>
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