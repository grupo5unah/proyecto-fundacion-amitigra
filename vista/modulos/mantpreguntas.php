<?php require "./modelo/conexionbd.php"; ?>

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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de preguntas</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<!-- <a href="producto" class="btn btn-default button1" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar nueva pregunta </a> -->
									<button class="btn btn-default btnCrearPregunta glyphicon glyphicon-plus-sign" >Agregar Nueva Pregunta</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>
											<th>Pregunta</th>
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
											$sql = "SELECT id_pregunta,pregunta,creado_por,fecha_creacion,modificado_por,fecha_modificacion
                                                            FROM tbl_preguntas;";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['pregunta'];
											$evento = array(
												'pregunta' => $eventos['pregunta'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'modificado_por' => $eventos['modificado_por'],
                                                'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_pregunta' => $eventos['id_pregunta']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['pregunta']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
                                                    <td> <?php echo $evento['fecha_creacion']; ?></td>
                                                    <td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarPreg glyphicon glyphicon-pencil" data-idpregunta="<?php $evento['id_pregunta']; ?>" data-nompregunta="<?php $evento['pregunta']; ?>"></button>
														<button class="btn btn-danger btnEliminarRol glyphicon glyphicon-remove" data-idpregunta="<?php echo $evento['id_pregunta']; ?>"></button>
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
	
				<div class="modal fade" id="modalEditarPregunta" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
               		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar pregunta</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										<div class="campos">
											<label for="">Pregunta: </label>
											<input id="pregunta" class="form-control secundary text-uppercase" type="text" name="" placeholder="Escriba la pregunta" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
					
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar pregunta</button>
							</div>
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
			<!-- modal para agregar Preguntas -->
			<div class="modal fade" id="modalRegistrarPregunta" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
               	             	 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar pregunta</h3>
								</div>
							</div>
							<div class="modal-body">
							<form method="POST" id="formPreguntas">
                              <div class="ingreso-producto form-group">
                               <div class="campos" type="hidden">
                               <label for=""> </label>
                               <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled>
                            </div>

                          <div class="campos">
                          <label for="">Nombre de la Pregunta </label>
                          <input id="pregunta" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba la pregunta" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

                          </div>
                                
                          <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          </div>
						  </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
								<button id=""type="submit" class="btn btn-primary">Registrar Pregunta</button>
							</div>
                        </form>
                        <?php 
                            if(isset($_GET['msg'])){
                            $mensaje = $_GET['msg'];
                            print_r($mensaje);
                           //echo "<script>alert(".$mensaje.");</script>";  
                           }

            ?>
							
						</div>
					</div>
				</div>
			

		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>