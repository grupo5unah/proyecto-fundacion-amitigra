<?php include("./modelo/conexionbd.php"); ?>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Habitaciones y Áreas</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-default btnCrearHabServ glyphicon glyphicon-plus-sign" >Agregar Habitación/Área</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantHabServTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>

											<th class="text-center">Descripcion</th>
											<th class="text-center">Habitacion Área</th>
											<th class="text-center">Localidad</th>
											<th class="text-center">Estado</th>
                                            <th class="text-center">Precio Adulto(N)</th>
                                            <th class="text-center">Precio Niño(N)</th>
                                            <th class="text-center">Precio Adulto(E)</th>
                                            <th class="text-center">Precio Niño(E)</th>
											<th class="text-center">Modificacdo por</th>
											<th class="text-center">Fecha modificación</th>
											<th class="text-center">Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_habitacion_servicio,tbl_habitacion_servicio.descripcion,habitacion_area,tbl_localidad.nombre_localidad,tbl_estado.nombre_estado,precio_adulto_nacional 
													,precio_nino_nacional,precio_adulto_extranjero,precio_nino_extranjero,tbl_habitacion_servicio.modificado_por,tbl_habitacion_servicio.fecha_modificacion  
													FROM tbl_habitacion_servicio
													inner join tbl_localidad
													ON tbl_habitacion_servicio.localidad_id = tbl_localidad.id_localidad
													inner join tbl_estado
													ON tbl_habitacion_servicio.estado_id = tbl_estado.id_estado
													WHERE tbl_habitacion_servicio.estado_eliminado = 1
                                                    ORDER BY id_habitacion_servicio ASC";
											$resultado = $conn->query($sql);
										} catch (Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['descripcion'];
											$evento = array(
												'descripcion' => $eventos['descripcion'],
												'habitacion_area' => $eventos['habitacion_area'],
												'localidad' => $eventos['nombre_localidad'],
												'estado' => $eventos['nombre_estado'],
                                                'precio_adulto_nacional' => $eventos['precio_adulto_nacional'],
                                                'precio_nino_nacional' => $eventos['precio_nino_nacional'],
                                                'precio_adulto_extranjero' => $eventos['precio_adulto_extranjero'],
                                                'precio_nino_extranjero' => $eventos['precio_nino_extranjero'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_habitacion_servicio' => $eventos['id_habitacion_servicio']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td class="text-center"> <?php echo $evento['descripcion']; ?></td>
													<td class="text-center"> <?php echo $evento['habitacion_area']; ?></td>
													<td class="text-center"> <?php echo $evento['localidad']; ?></td>
													<td class="text-center"> <?php echo $evento['estado']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['precio_adulto_nacional']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['precio_nino_nacional']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['precio_adulto_extranjero']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['precio_nino_extranjero']; ?></td>
													<td class="text-center"> <?php echo $evento['modificado_por']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_modificacion']; ?></td>
													<td class="text-center">
														<button class="btn btn-warning btnEditarHabServ glyphicon glyphicon-pencil"  data-idhs="<?= $evento['id_habitacion_servicio'] ?>" data-nombreha="<?= $evento['habitacion_area'] ?>" 
														data-descripcion="<?= $evento['descripcion'] ?>" data-localidad="<?= $evento['localidad'] ?>" data-pan="<?= $evento['precio_adulto_nacional'] ?>"
														data-pnn="<?= $evento['precio_nino_nacional'] ?>" data-pae="<?= $evento['precio_adulto_extranjero'] ?>" data-prne="<?= $evento['precio_nino_extranjero'] ?>"
														data-estado="<?= $evento['estado'] ?>"></button>

														<button class="btn btn-danger btnEliminarHabServ glyphicon glyphicon-remove" data-idha="<?php echo $evento['id_habitacion_servicio'] ?>"></button>
													</td>
												<?php }?>
											<?php }?>
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
	
			<!-- MODAL EDITAR HABITACION SERVICIO -->
			<div class="modal fade" id="modalEditarHabServ" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<div class="d-flex justify-content-between">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true">&times;</i>
						</button>
						<h3 class="modal-title" id="exampleModalLabel">Editar Habitacion-Área </h3>
						</div>
					</div>
					<div class="modal-body">
						<form method="POST" id="formHabServ" onpaste="return false">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
							<li><a></a></li>               
							<li><a></a></li>
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
										<label for="">Habitación-Área: </label>
										<input id="ha" class="form-control modal-roles secundary" type="text" name="ha" required>
									</div>
									<div class="campos">
										<label for="">localidad</label><br>
										<select class="form-control modal-roles secundary " name="localidad" id="localidad">
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
									<div class="campos">
										<label for="">Estado:</label><br>
										<select class="form-control modal-roles secundary" name="estado" id="estado">
											<option value="" disabled selected>Selecione...</option>
											<?php
											require ('./modelo/conexionbd.php');

											$stmt = "SELECT id_estado, nombre_estado FROM tbl_estado
											WHERE nombre_estado = 'DISPONIBLE' OR nombre_estado = 'RESERVADO'";
											$resultado = mysqli_query($conn,$stmt);
											?>
											<?php foreach($resultado as $opciones):?>
											<option value="<?php echo $opciones['id_estado']?>"><?php echo $opciones['nombre_estado']?></option>
											<?php endforeach;?>
										</select>
									</div>
									<div class="campos">
										<label for="area">Descripción:</label><br>
										<textarea name="descripcion" id="descripcion" cols="55" rows="3"></textarea>
									</div>
									
								</div> <!-- /.modal form-group -->
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
									<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
									<button class="btn btn-primary" href="#timeline" data-toggle="tab">Siguiente</button>
								</div>
								
								
								</div> <!-- /.post -->	
							</div> <!-- /.tab-pane -->
							<div class="tab-pane" id="timeline">
								<div class="post"> <br>
								
								<div class="ingreso-producto form-group">
									<div class="campos" type="hidden">
									<label for=""> </label>
									<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
									</div>
									<!-- <input type="hide"> -->
									<div class="col-md-7">
										<div class="campos form-group">
											<label>Precio Adulto (N):</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control" name="preAdultN" id="preAdultN" placeholder="Ingrese el precio" onkeydown="return soloNumeros(event)"
												maxlength="4">
											</div>
										</div>
										<div class="campos form-group">
											<label>Precio Niño (N):</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control " name="precioNinoNiN" id="precioNiN" onkeydown="return soloNumeros(event)" placeholder="Ingrese el precio"
												maxlength="4" requiered>
											</div>
										</div>
									</div>
									<div class="campos form-group">
										<label>Precio Adulto (E):</label>
										<div class="input-group col-xs-3">
											<span class="input-group-addon">$.</span>
											<input type="text" class="form-control" name="preAdultE" id="preAdultE" placeholder="Ingrese el precio" onkeydown="return soloNumeros(event)"
											maxlength="3">
										</div>
									</div>
									<div class="campos form-group ">
										<label>Precio Niño (E):</label>
										<div class="input-group col-xs-3">
											<span class="input-group-addon">$.</span>
											<input type="text" class="form-control" name="precioNiE" id="precioNiE" onkeydown="return soloNumeros(event)" placeholder="Ingrese el precio"
											maxlength="3" requiered>
										</div>
									</div>
									
									
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div> <!-- /.modal form-group -->
								<div class="modal-footer">
									<button class="btn btn-default" href="#activity2" id="prevtab" data-toggle="tab">Anterior</button>
									<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
									<button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar</button>
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

			<!-- /.box-footer-->
			<!-- CREAR NUEVA HABITACION AREA -->
			<div class="modal fade" id="modalCrearHabServ" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<div class="d-flex justify-content-between">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true">&times;</i>
						</button>
						<h3 class="modal-title" id="exampleModalLabel">Editar Habitacion-Área </h3>
						</div>
					</div>
					<div class="modal-body">
						<form method="POST" id="formHabServi" onpaste="return false">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
							<li><a></a></li>               
							<li><a></a></li>
							</u>
							<div class="tab-content">
							<div class="active tab-pane" id="activity3">
								<div class="post"><br>
								
								<div class="ingreso-producto form-group">
									<div class="campos" type="hidden">
									<label for=""> </label>
									<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
									</div>
									
									<div class="campos">
										<label for="">Habitación-Área: </label>
										<input id="ha" class="form-control modal-roles secundary" type="text" name="ha" placeholder="Ingrese una habitación o Área" required>
									</div>
									<div class="campos">
										<label for="">localidad</label><br>
										<select class="form-control modal-roles secundary " name="localidad" id="localidad">
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
									<div class="campos">
										<label for="">Estado:</label><br>
										<select class="form-control modal-roles secundary" name="estado" id="estado">
											<option value="" disabled selected>Selecione...</option>
											<?php
											require ('./modelo/conexionbd.php');

											$stmt = "SELECT id_estado, nombre_estado FROM tbl_estado
											WHERE nombre_estado = 'DISPONIBLE' OR nombre_estado = 'RESERVADO'";
											$resultado = mysqli_query($conn,$stmt);
											?>
											<?php foreach($resultado as $opciones):?>
											<option value="<?php echo $opciones['id_estado']?>"><?php echo $opciones['nombre_estado']?></option>
											<?php endforeach;?>
										</select>
									</div>
									<div class="campos">
										<label for="descrip">Descripción:</label><br>
										<textarea name="descrip" id="descrip" cols="55" rows="3" placeholder="Ingrese una descripción"></textarea>
									</div>
									
									</div> <!-- /.modal form-group -->
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
										<!-- <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button> -->
										<button class="btn btn-primary" href="#timeline1" data-toggle="tab">Siguiente</button>
									</div>
								
								
								</div> <!-- /.post -->	
							</div> <!-- /.tab-pane -->
							<div class="tab-pane" id="timeline1">
								<div class="post"> <br>
								
								<div class="ingreso-producto form-group">
									<div class="campos" type="hidden">
									<label for=""> </label>
									<!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
									</div>
									<!-- <input type="hide"> -->
									<div class="col-md-7">
										<div class="campos form-group">
											<label>Precio Adulto (N):</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control" name="preAdultN" id="preAdultN" placeholder="" onkeydown="return soloNumeros(event)"
												maxlength="4">
											</div>
										</div>
										<div class="campos form-group">
											<label>Precio Niño (N):</label>
											<div class="input-group col-xs-6">
												<span class="input-group-addon">L.</span>
												<input type="text" class="form-control " name="precioNiN" id="precioNiN" onkeydown="return soloNumeros(event)" placeholder=""
												maxlength="4" requiered>
											</div>
										</div>
									</div>
									<div class="campos form-group">
										<label>Precio Adulto (E):</label>
										<div class="input-group col-xs-3">
											<span class="input-group-addon">$.</span>
											<input type="text" class="form-control" name="preAdultE" id="preAdultE" placeholder="" onkeydown="return soloNumeros(event)"
											maxlength="3">
										</div>
									</div>
									<div class="campos form-group">
										<label>Precio Niño (E):</label>
										<div class="input-group col-xs-3">
											<span class="input-group-addon">$.</span>
											<input type="text" class="form-control" name="precioNiE" id="precioNiE" onkeydown="return soloNumeros(event)" placeholder=""
											maxlength="3" requiered>
										</div>
									</div>
									
									
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div> <!-- /.modal form-group -->
								<div class="modal-footer">
									<button class="btn btn-default" href="#activity3" id="prevtab" data-toggle="tab">Anterior</button>
									<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
									<button id=""type="submit" class="btn btn-primary">Registrar Habitacion-Área</button>
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

		</div><!-- /.box -->

	</section>
</div><!-- /.content -->