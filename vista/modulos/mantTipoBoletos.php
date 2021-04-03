<?php include("./modelo/conexionbd.php");

$id_objeto = 35;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] === 1){
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Mantenimiento de Tipos de Boletos y Descripcion</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a class=" btn btn-default btnNuevoTipoBoleto glyphicon glyphicon-plus-sign"> Nuevo Tipo de Boleto </i></a>
								</div> <!-- /div-action -->
                				<!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
								porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="manttipoBoletos">
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
											$sql = "SELECT id_tipo_boleto, nombre_tipo_boleto, precio_venta, descripcion, fecha_creacion, modificado_por, fecha_modificacion  
											 FROM tbl_tipo_boletos 											 
											 WHERE estado_eliminado = 1
											 ORDER BY id_tipo_boleto";
											$resultado = $conn->query($sql);
										}catch (Exception $e){
											echo  $e->getMessage();
										}
										//esta variable es para realizar un arreglo que permita mostrar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['nombre_tipo_boleto'];
											$mostrar = array(
												'nombre_boleto'=>$mostrar['nombre_tipo_boleto'],
												'precio_V'=>$mostrar['precio_venta'],
												'descripcion'=>$mostrar['descripcion'],
												'fecha_creacion'=>$mostrar['fecha_creacion'],
												'modificado_por'=>$mostrar['modificado_por'],
												'fecha_modificacion'=>$mostrar['fecha_modificacion'],
												'id_tipo'=>$mostrar['id_tipo_boleto']												
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td><?php echo $mostrar['nombre_boleto'];?></td>
													<td><?php echo $mostrar['precio_V'];?></td>
													<td><?php echo $mostrar['descripcion'];?></td>
													<td><?php echo $mostrar['fecha_creacion'];?></td>
													<td><?php echo $mostrar['modificado_por'];?></td>
													<td><?php echo $mostrar['fecha_modificacion'];?></td>
													
													<td>
								
													<button class="btn btn-warning btnEditarTB glyphicon glyphicon-pencil"  data-idtipoboleto="<?= $mostrar['id_tipo'] ?>" 
													data-nombreBoleto="<?= $mostrar['nombre_boleto'] ?>" data-descripcion="<?= $mostrar['descripcion'] ?>" data-precioV="<?= $mostrar['precio_V'] ?>" 
													data-modificacionP="<?= $mostrar['modificado_por'] ?>" data-fmodificacion="<?= $mostrar['fecha_modificacion'] ?>"></button>

													<button class="btn btn-danger btnEliminarTipoBoleto glyphicon glyphicon-remove" data-idtipoboleto="<?= $mostrar['id_tipo'] ?>"></button>
													
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
			<!-- MODAL EDITAR TIPO DE BOLETO -->
			<div class="modal fade" id="modalEditarTB" data-backdrop="static" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Editar Tipo de Boleto</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formEditarTipoBoleto">
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
													<label for="">Nombre de Boleto:</label>
														<input id="NombreBoleto" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="NombreBoleto" autocomplete="off" required />
													</div>
													<div class="campos">
													<label for="">Descripcion del Tipo de Boleto:</label>
														<input id="Descripcion" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="Descripcion" autocomplete="off" required />
													</div>
													<div class="campos">
													<label for="">Precio del Boleto:</label>
														<input id="PrecioV" class="form-control modal-roles secundary" type="number" min="1" name="PrecioV" autocomplete="off" required />
													</div>
													<div class="campos">
														<label for="">Fecha Modificada Tipo Boleto:</label>
														<input id="Fmodificacion" class="form-control modal-roles secundary" type="datetime" name="Fmodificacion" <?php
																														date_default_timezone_set("America/Tegucigalpa");
																														$fec=date('Y-m-d H:i:s',time());
																														?> value="<?php echo $fec;?>" disabled="true" />
													</div>
													<div class="campos">
														<label for="">Modificado Por:  </label>			
														<input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>"> 											
														<input id="ModificacionPuser" style="text-transform: uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="usuario_actual" value="<?= $usuario ?>" disabled="true"/>
													</div>
														
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
													<button id=""type="submit" class="btn btn-primary btnEditarBD">Editar Tipo Boleto</button>
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

			<!-- MODAL CREAR TIPO DE BOLETO -->
			<div class="modal fade" id="modalCrearTipoBoleto" data-backdrop="static" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Creacion de un Tipo de Boleto</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formCrearTipoBoleto" onpaste= "return false">
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
													<label for="">Nombre del Tipo de Boleto:</label>
														<input id="NombreBoletoN" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="NombreBoletoN" autocomplete="off" required />
													</div>
													<div class="campos">
													<label for="">Descripcion del Tipo de Boleto:</label>
														<input id="DescripcionN" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="DescripcionN" autocomplete="off" required />
													</div>
													<div class="campos">
													<label for="">Precio del Boleto:</label>
														<input id="PrecioVN" class="form-control modal-roles secundary" type="number" min="1" name="PrecioVN" autocomplete="off" required />
													</div>													
													<div class="campos">
														<label for="">Creado Por:  </label>			
														<input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>"> 											
														<input id="CreadoPor" style="text-transform: uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control modal-roles secundary" type="text" name="usuario_actual" value="<?= $usuario ?>" disabled="true"/>
													</div>
														
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
												</div> <!-- /.modal form-group -->
												<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
													<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button> -->
													<button id=""type="submit" class="btn btn-primary btnEditarBD">Crear Tipo de Boleto</button>
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