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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento parámetros</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								 <!-- /div-action -->
								 <div class="div-action pull pull-right" style="padding-bottom:20px;">
								
								 <button class="btn btn-default btnCrearParam glyphicon glyphicon-plus-sign" >Agregar Parametro</button>
								 </div>

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manageProductTable">
									<thead>
										<tr>

											<th>Parámetro</th>
											<th>Valor</th>
											<th>Fecha creación</th>
											<th>Fecha modificaciÓn</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_parametro,parametro,valor,fecha_creacion,fecha_modificacion
                                                            FROM tbl_parametros  where estado_eliminado=1";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['parametro'];
											$evento = array(
												'nombre_parametro' => $eventos['parametro'],
												'valor' => $eventos['valor'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_parametro' => $eventos['id_parametro']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_parametro']; ?></td>
													<td> <?php echo $evento['valor']; ?></td>
                                                    <td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														<button class="btn btn-warning btnEditarParam glyphicon glyphicon-pencil"  data-idparametro="<?= $evento['id_parametro'] ?>" data-nombreparametro="<?= $evento['nombre_parametro']?>" data-valor="<?= $evento['valor'] ?>"></button>

														<button class="btn btn-danger btnEliminarParam glyphicon glyphicon-remove" data-idparametro="<?php echo $evento['id_parametro'] ?>"></button>
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
	
				<div class="modal fade" id="modalEditarParam" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar parametro</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarParametro">
									<div class="ingreso-producto form-group">
										<div class="campos">
											<label for="">Parametro: </label>
											<input id="Param" class="form-control modal-roles secundary text-uppercase" type="text" name="" placeholde="Escriba el Paramenttro" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" />

										</div>
										<div class="campos form-group">
											<label for="">valor parametro: </label>
											<input id="valor" class="form-control  modal-roles  secundary text-uppercase" type="tel" name="" placeholde="Escriba el producto" required />

										</div>
										<input type="hidden" name="" id="id_usuario" value="<?= $_SESSION['id'] ?>">
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar parametro</button>
							</div>
						</div>
					</div>
				</div>
				<!-- modal para crear un prametro -->
				<div class="modal fade" id="modalRegistrarParam" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Parametros</h3>
								</div>
							</div>
							<div class="modal-body">
							<section class="">
                          <form method="POST" id="formParametros">
                             <div class="ingreso-producto form-group">
                              <div class="campos" type="hidden">
                                <label for=""> </label>
                                  <input autocomplete="off" class="form-control secundary" type="hidden" name="idParametro" value="0" disabled>

                              </div>
   
                              <div class="campos">
                                <label for="">Nombre del Parametro </label>
                                  <input id="nombrePara" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreParametro" placeholde="Escriba el parametro" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" />

                                  </div>
                              <div class="campos ">
                                <label for=""> Valor </label>
                                   <input id="valorParam" class="form-control  modal-roles secundary text-uppercase" type="tel" placeholde="Describa el parametro" required onkeypress="return soloLetras(event)"onkeyup="javascript:this.value=this.value.toUpperCase()" />

                                 </div>
								 <input type="hidden" name="usuario_actual" id="id_usuario" value="<?= $_SESSION['id'] ?>">
                                <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                                </div>
								<!-- <input type="submit" name="ingresarProducto" class="btn" value="Ingresar Parametro" />
								</div> -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
								<button id="btnEditarBD"type="submit" class=" btn btn-primary">Registrar Parametro</button>
							</div>
                           </form>
                       <?php 
                       if(isset($_GET['msg'])){
                         $mensaje = $_GET['msg'];
                        print_r($mensaje);
                 
                     }

                          ?>
                          </section>
							
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>