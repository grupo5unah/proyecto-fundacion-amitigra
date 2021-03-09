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
									<thead>
										<tr>

											<th>descripcion</th>
											<th>habitacion/area</th>
											<th>Id Localidad</th>
											<th>Id Estado</th>
                                            <th>P.Adulto Nacional</th>
                                            <th>P.Niño Nacional</th>
                                            <th>P.Adulto Extranjero</th>
                                            <th>P.Niño Extranjero</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_habitacion_servicio,descripcion,habitacion_area,localidad_id,estado_id,precio_adulto_nacional 
                                                    ,precio_nino_nacional,precio_adulto_extranjero,precio_nino_extranjero FROM tbl_habitacion_servicio
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
												'localidad_id' => $eventos['localidad_id'],
												'estado_id' => $eventos['estado_id'],
                                                'precio_adulto_nacional' => $eventos['precio_adulto_nacional'],
                                                'precio_nino_nacional' => $eventos['precio_nino_nacional'],
                                                'precio_adulto_extranjero' => $eventos['precio_adulto_extranjero'],
                                                'precio_nino_extranjero' => $eventos['precio_nino_extranjero'],
                                                'id_habitacion_servicio' => $eventos['id_habitacion_servicio']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['habitacion_area']; ?></td>
													<td> <?php echo $evento['localidad_id']; ?></td>
													<td> <?php echo $evento['estado_id']; ?></td>
                                                    <td> <?php echo $evento['precio_adulto_nacional']; ?></td>
                                                    <td> <?php echo $evento['precio_nino_nacional']; ?></td>
                                                    <td> <?php echo $evento['precio_adulto_extranjero']; ?></td>
                                                    <td> <?php echo $evento['precio_nino_extranjero']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarHabServ glyphicon glyphicon-pencil"  data-idhs="<?= $evento['id_habitacion_servicio'] ?>" data-nombreha="<?= $evento['habitacion_area'] ?>" 
														data-descripcion="<?= $evento['descripcion'] ?>" data-localidad="<?= $evento['localidad_id'] ?>" data-pna="<?= $evento['precio_adulto_nacional'] ?>"
														data-pnn="<?= $evento['precio_nino_nacional'] ?>" data-pae="<?= $evento['precio_adulto_extranjero'] ?>" data-pne="<?= $evento['precio_nino_extranjero'] ?>"
														data-estado="<?= $evento['estado_id'] ?>"></button>

														<button class="btn btn-danger btnEliminarHabServ glyphicon glyphicon-remove" data-idcliente="<?php echo $evento['id_cliente'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarHabServ" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
 									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Cliente</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarHabServ">
									<div class="ingreso-producto form-group">
										
										<div class="campos">
											<label for="">Descripción: </label>
											<input id="descripcion" class="form-control  modal-roles secundary text-uppercase" type="text" name="descripcion" placeholde="Escriba la descripcion" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										<div class="campos form-group">
											<label for="">Habitacion / Área: </label>
											<input id="ha" class="form-control  modal-roles secundary text-uppercase" type="text" name="ha"placeholde="Escriba la habitacion/área" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" required/>

										</div>
										<div class="campos form-group">
											<label for="">Estado: </label>
											<input id="estado" class="form-control  modal-roles secundary text-uppercase" type="text" name="estado" placeholde="Ingrese el estado" required/>

										</div>
                                        <div class="campos form-group">
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
										
										<input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Cliente</button>
							</div>
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
			<!-- crear nuevo Cliente -->
				<div class="modal fade" id="modalCrearCliente" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Objeto</h3>
									</div>
								</div>
								<div class="modal-body">
									<form name="" id="formCliente">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre Cliente: </label>
												<input id="nombreCliente" class="form-control modal-roles secundary text-uppercase" type="text" name="cliente" placeholder="Nombre cliente" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Identidad: </label>
												<input id="ident" class="form-control  modal-roles secundary text-uppercase" type="tex"  placeholder="Identidad" required/>

											</div>
											<div class="campos form-group">
												<label for="">Telefono: </label>
												<input id="tel" class="form-control  modal-roles secundary text-uppercase" type="text"  placeholder="Telefono" required/>

											</div>
                                            <div class="campos form-group">
                                                <label for="">Nacionalidad: </label>
                                                <select class="form-control" name="nacionalidad" id="nacionalidad">
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
											
											
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Close</button>
										<button id=""type="submit" class=" btn btn-primary">Registrar  Objeto</button>
										</div>
										
									</form>
								</div>
								
							</div>
						</div>
					</div>

				
				</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>