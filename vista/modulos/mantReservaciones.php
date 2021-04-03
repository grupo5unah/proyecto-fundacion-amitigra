<?php

include("./modelo/conexionbd.php");

$id_objeto = 33;
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
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Estados</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-default btnCrearEstado glyphicon glyphicon-plus-sign" >Agregar Nuevo Estado</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantEstadoTable">
									<thead style="background-color: #222d32; color: white;">
										<tr>

											<th class="text-center">Fecha Reservación</th>
											<th class="text-center">Fecha Entrada</th>
											<th class="text-center">Fecha Salida</th>
											<th class="text-center">Cliente</th>
											<th class="text-center">Usuario</th>
                                            <th class="text-center">Creado por</th>
											<th class="text-center">Fecha Creacion</th>
											<th class="text-center">Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_reservacion,fecha_reservacion,fecha_entrada, fecha_salida,
                                                    tbl_clientes.nombre_completo, tbl_usuarios.nombre_usuario,
                                                    tbl_reservaciones.creado_por,tbl_reservaciones.fecha_creacion
													FROM tbl_reservaciones
                                                    INNER JOIN tbl_clientes
                                                    ON tbl_reservaciones.cliente_id = tbl_clientes.id_cliente
                                                    INNER JOIN tbl_usuarios 
                                                    ON tbl_reservaciones.usuario_id = tbl_usuarios.id_usuario
                                                    WHERE tbl_reservaciones.estado_eliminado = 1";
											$resultado = $conn->query($sql);
										} catch (Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['fecha_reservacion'];
											$evento = array(
												'fecha_reservacion' => $eventos['fecha_reservacion'],
												'fecha_entrada' => $eventos['fecha_entrada'],
												'fecha_salida' => $eventos['fecha_salida'],
												'cliente' => $eventos['nombre_completo'],
												'usuario' => $eventos['nombre_usuario'],
                                                'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'id_reservacion' => $eventos['id_reservacion']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td class="text-center"> <?php echo $evento['fecha_reservacion']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_entrada']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['fecha_salida']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['cliente']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['usuario']; ?></td>
                                                    <td class="text-center"> <?php echo $evento['creado_por']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_creacion']; ?></td>
													
													<td>
														<button class="btn btn-warning btnEditarEstado glyphicon glyphicon-pencil"  data-idestado="<?= $evento['id_estado'] ?>" data-nombre="<?= $evento['nombre_estado'] ?>" 
														data-descripcion="<?= $evento['descripcion'] ?>"></button>

														<button class="btn btn-danger btnEliminarEstado glyphicon glyphicon-remove" data-idestad="<?php echo $evento['id_estado'] ?>"></button>
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
	
			<div class="modal fade" id="modalEditarEstado" tabindex="-1"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Actualizar Estado</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="formEditarEstado" onpaste="return false">
								<div class="ingreso-producto form-group">
									
									<div class="campos">
										<label for="">Nombre Estado: </label>
										<input id="nombreEstado" class="form-control  modal-roles secundary text-uppercase" type="text" name="nombreEstado" placeholde="Escriba el nombre del estado" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

									</div>
									<div class="campos form-group">
										<label for="">Descripción: </label>
										<input id="descripcion" class="form-control  modal-roles secundary text-uppercase" type="text" name="descripcion"placeholde="Escriba la descripcion"  onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" required/>

									</div>
									
									<input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div>
								
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Estado</button>
						</div>
					</div>
				</div>
			</div>

			<!-- /.box-footer-->
			<!-- CREAR NUEVO ESTADO -->
				<div class="modal fade" id="modalCrearEstado" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Estado</h3>
									</div>
								</div>
								<div class="modal-body">
									<form name="" id="formEstado" onpaste="return false">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre Estado: </label>
												<input id="nombreE" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreE" placeholder="Nombre Estado" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Descripción: </label>
												<input id="descrip" name="descrip" class="form-control  modal-roles secundary text-uppercase" type="tex"  placeholder="Descripcion" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" required/>

											</div>
											
											
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Close</button>
										<button id=""type="submit" class=" btn btn-primary">Registrar Estado</button>
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

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>