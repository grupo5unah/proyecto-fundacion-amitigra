<?php require './modelo/conexionbd.php';

$id_objeto = 34;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>

<div class="content-wrapper">

	<section class="content-header">
		<h1>Mantenimiento <small>roles</small></h1>
		<ol class="breadcrumb ">
			<li class="btn btn-success  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
			<li class="btn btn-success  active fw-bold "><a href="#"><i class="fas fa-cogs"></i> Mantenimiento Roles</a></li>
			
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box" oncopy="return false" onpaste="return false">
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">
					<input type="hidden" name="" id="id_usuario" value="<?= $_SESSION['id'] ?>">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de roles</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									
									<button class="btn btn-success text-uppercase btnCrearRol"> <i class="fa fa-plus-circle"> </i> Agregar rol</button>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered tablass" id="managerRoles">
									<thead style=" background-color: #222d32; color: white;">
										<tr>
											<th>Rol</th>
											<th>Descripción</th>
											<th>creado por</th>
                      						<th>Fecha creación</th>
                      						<th>Modificado por</th>
											<th>Fecha modificación</th>
											<?php if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
											else:?>
											<th>Acciones</th>
											<?php
											endif;
											?>
										</tr>
									</thead>
									<tbody>
										<?php
										try {

											$sql = "SELECT id_rol,rol,descripcion,creado_por,fecha_creacion,modificado_por,fecha_modificacion
                                            FROM tbl_roles where estado_eliminado=1";

											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['rol'];
											$evento = array(
												'nombre_rol' => $eventos['rol'],
												'descripcion' => $eventos['descripcion'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
												'id_rol' => $eventos['id_rol']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_rol']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
													<td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>

														<?php if($columna['permiso_actualizacion'] == 1):?>
														<button class="btn btn-warning btnEditarRol glyphicon glyphicon-pencil"  data-idrol="<?= $evento['id_rol'] ?>" data-nombrerol="<?= $evento['nombre_rol'] ?>" data-descripcion="<?= $evento['descripcion'] ?>"></button>
														<?php
														else:
														endif;

														if($columna['permiso_eliminacion'] == 1):
														?>
														<button class="btn btn-danger btnEliminarRol glyphicon glyphicon-remove" data-idrol="<?php echo $evento['id_rol'] ?>"></button>
														<?php
														else:
														endif;
														?>
														<button class="btn btn-success btnPermisos glyphicon glyphicon-ok-sign" data-idrol="<?php echo $evento['id_rol'] ?>"></button>
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

				<!-- INICIO MODAL PARA EDITAR ROL -->
				<div class="modal fade" id="modalEditarRol" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Rol</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="campos">
											<label for="">Nombre rol </label>
											<input id="nombreRol" disabled class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholde="Escriba el producto" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

										</div>
										<div class="campos form-group">
											<label for="">Descripción </label>
											<textarea autocomplete="off" id="descripcionRol" class="form-control modal-roles secundary text-uppercase" rows="3" placeholder="Descripción del rol" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"></textarea>
										</div>										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" id="cerrarModalActualizar" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-success">Actualizar</button>
							</div>
						</div>
					</div>
				</div>
				<!-- FIN MODAL EDITAR ROL -->

				<!-- INICIO MODAL REGISTRO ROL -->
				<div class="modal fade" id="modalRegistrarRol" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Rol</h3>
								</div>
							</div>
							<div class="modal-body">
								<form role="form" name="" id="formRol">
									<div class=" form-group">
										

										<div class="campos">
											<label for="">Nombre rol </label>
											<input autocomplete="off" id="nombre" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholder="Escriba el rol" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>

										<div class="campos form-group">
											<label for="">Descripción </label>
											<textarea autocomplete="off" id="descripcion" class="form-control modal-roles secundary text-uppercase" rows="3" placeholder="Descripción del rol"  required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"></textarea>
											<!-- <input id="descripcion" class="form-control modal-roles secundary text-uppercase" type="tel" name="cantidad" placeholder="Escriba el producto" required onkeypress="return soloLetra(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/> -->
											<!-- <input id="descripcion" class="form-control modal-roles secundary text-uppercase" type="tel" name="cantidad" placeholde="Escriba el producto" autocomplete="off"/> -->

										</div>

										<!-- <div class="campos form-group">
											<div class="input-group col-sm-12">
												<label class="" for="">Estado: </label>
												<select class="form-control" name="" id="">
													<option selected disabled>Seleccione un estado</option>

													<?php
													/*include "./modelo/conexionbd.php";

													$stmts = "SELECT id_estado, nombre_estado FROM tbl_estado WHERE id_estado IN(1,2,3);";
													$result = mysqli_query($conn,$stmts);

													while($opcion = mysqli_fetch_assoc($result)){*/
													?>
													<option value="1">ACTIVO</option>
													<option value="0">INACTIVO</option>
													<?php //}?>
												</select>
											</div>
										</div> -->

										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								
							</div>
							<div class="modal-footer">
								<button type="button" id="cerrarModalCrear" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
								<button id="" type="submit"  name="ingresarProducto" class=" btn btn-success">Registrar 
								</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				<!-- FIN MODAL REGISTRO ROL -->

				<!-- INICIO MODAL ASIGNAR PERMISOS -->
				<div class="modal fade" id="modalPermisos" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Asignar permisos</h3>
								</div>
							</div>
							<div class="modal-body">
								<form role="form" name="formEditarProducto">
									<div class="ingreso-producto form-group">
										<div class="campos" type="hidden">
											<label for=""> </label>
											<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
										</div>

										<div class="form-group campos">
											<div class="input-group col-sm-12">
												<label for="">Elegir objeto:</label>
											<select class="form-control" name="" id="objeto">
												<option selected disabled>Seleccionar un obejto</option>
											<?php

											include "./modelo/conexionbd.php";

											$objetos = "SELECT id_objeto, objeto FROM tbl_objeto WHERE estado_eliminado = 1;";
											$objetos = mysqli_query($conn, $objetos);

											while($objeto = mysqli_fetch_assoc($objetos)):
											?>
											<option value="<?php echo $objeto['id_objeto']?>"><?php echo $objeto["objeto"]?></option>
											<?php endwhile;?>
											</select>
											</div>
										</div>


										<div class="campos form-group">
											<label for="">Permisos:</label>
										</div>

										<div class="row">
											<div class="col-lg-6">
												<div class="input-group">
													<div class="checkbox">
													<!-- <input type="text" name="" id="insertar" value=""> -->
														<input type="hidden" name="checkboxInsertar" value="0">
														<label>
															<input id="insertar" value="1" name="checkboxInsertar" type="checkbox"> Insertar
														</label>
													</div>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="input-group">
													<div class="checkbox">
													<!-- <input type="text" name="" id="eliminar" value=""> -->
														<input type="hidden" name="checkboxEliminar" value="0">
														<label>
															<input id="eliminar" value="1" name="checkboxEliminar" type="checkbox"> Eliminar
														</label>
													</div>
												</div>
											</div>
											
											<div class="col-lg-6">
												<div class="input-group">
													<div class="checkbox">
													<!-- <input type="text" name="" id="actualizar" value=""> -->
														<input type="hidden" name="checkboxActualizar" value="0">
														<label>
															<input id="actualizar" value="1" name="checkboxActualizar" type="checkbox"> Actualizar
														</label>
													</div>
												</div>
											</div>

											<div class="col-lg-6">
												<div class="input-group">
													<div class="checkbox">
													<!-- <input type="text" name="" id="consultar" value=""> -->
													<input type="hidden" name="checkboxConsultar" value="0">
														<label>
															<input id="consultar" value="1" name="checkboxConsultar" type="checkbox"> Consultar
														</label>
													</div>
												</div>
											</div>
										</div>

										<input type="hidden" name="usuario_actual" id="usuario" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button id="cerrarModalPermisos" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
								<button id="btnAsignarPermisos" type="button" class="btnEditarBD btn btn-success">Asignar rol</button>
							</div>
						</div>
					</div>
				</div>
				<!-- FINAL MODAL ASIGNAR PERMISOS -->
				
			</div>
	</section>
</div>

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>