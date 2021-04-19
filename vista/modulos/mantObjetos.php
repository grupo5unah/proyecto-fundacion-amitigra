<?php

include("./modelo/conexionbd.php");

$id_objeto = 28;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>
<?php
//$_SESSION['rol'] = 'administrador';
// echo '<pre>';
// //var_dump($_SESSION['rol']);
// echo '</pre>';
?>
<div class="content-wrapper">
<section class="content-header">
		<h1>MANTENIMIENTO OBJETOS</h1>
		<ol class="breadcrumb ">
			<li class="btn btn-success  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
			<li class="btn btn-success  fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
			<li class="btn btn-success  active fw-bold"><a href="#"><i class="fas fa-cogs"></i> Mantenimiento Objetos</a></li>
			
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

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de objetos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-success btnCrearObjeto glyphicon glyphicon-plus-sign" >Agregar Nuevo Objeto</button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="managerObjetos">
									<thead style=" background-color: #222d32; color: white;">
										<tr>

											<th>Objeto</th>
											<th>Tipo Objeto</th>
											<th>descripcion</th>
											<th>creado por</th>
                                            <th>Fecha creacion</th>
                                            <th>Modificado por</th>
											<th>Fecha modificacion</th>
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


											$sql = "SELECT id_objeto, objeto, tipo_objeto, descripcion, creado_por,fecha_creacion, modificado_por, fecha_modificacion
                                         FROM tbl_objeto where estado_eliminado =1";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['objeto'];
											$evento = array(
												'nombre_objeto' => $eventos['objeto'],
												'tipo_objeto' => $eventos['tipo_objeto'],
												'descripcion' => $eventos['descripcion'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
                                                'modificado_por' => $eventos['modificado_por'],
                                                'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_objeto' => $eventos['id_objeto']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombre_objeto']; ?></td>
													<td> <?php echo $evento['tipo_objeto']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
                          							<td> <?php echo $evento['fecha_creacion']; ?></td>
                        							<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>

														<?php if($columna["permiso_actualizacion"] == 1):?>
														<button class="btn btn-warning btnEditarObjeto glyphicon glyphicon-pencil"  data-idobjeto="<?= $evento['id_objeto'] ?>" data-nombreobjeto="<?= $evento['nombre_objeto'] ?>" 
														data-tipo_objeto="<?= $evento['tipo_objeto'] ?>" data-descripcion="<?= $evento['descripcion'] ?>"></button>
														<?php
														else:
														endif;

														if($columna["permiso_eliminacion"] == 1):
														?>
														<button class="btn btn-danger btnEliminarObjeto glyphicon glyphicon-remove" data-idobjeto="<?php echo $evento['id_objeto'] ?>"></button>
														<?php
														else:
														endif;
														?>
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
	
				<div class="modal fade" id="modalEditarObjeto" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
 									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar Objeto</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="formEditarProducto">
									<div class="ingreso-producto form-group">
										
										<div class="campos">
											<label for="">Nombre objeto: </label>
											<input id="nombre_Objeto" class="form-control  modal-roles secundary text-uppercase" type="text" name="objeto" placeholde="Escriba el producto" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

										</div>
										<div class="campos form-group">
											<label for="">Tipo objeto: </label>
											<input id="tipo_Objeto" class="form-control  modal-roles secundary text-uppercase" type="text" name="tipo_objeto" autocomplete="off" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										<div class="campos form-group">
											<label for="">Descripcion objeto: </label>
											<input autocomplete="off" id="descripcionObjeto" class="form-control  modal-roles secundary text-uppercase" type="tel" name="descripcion" placeholde="Escriba el producto" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

										</div>
										
										
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>
									
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="btnEditarBD"type="button" class="btnEditarBD btn btn-primary">Actualizar Objeto</button>
							</div>
						</div>
					</div>
				</div>

			<!-- /.box-footer-->
			<!-- crear nuevos Objetos -->
				<div class="modal fade" id="modalCrearObjeto" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
									<form name="" id="formObjeto">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre objeto: </label>
												<input autocomplete="off" id="nombreObjeto" class="form-control modal-roles secundary text-uppercase" type="text" name="Objeto" placeholder="Escriba el objeto" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Tipo objeto: </label>
												<input id="tObjeto" class="form-control  modal-roles secundary text-uppercase" type="tex"  placeholder="tipo del objeto" required  autocomplete="off" onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Descripcion objeto: </label>
												<input id="descripcion" class="form-control  modal-roles secundary text-uppercase" type="text"  placeholder="Describa el objeto" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

											</div>
											
											
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
								       <button type="button" class="btn btn-danger" id="close" data-dismiss="modal">Cerrar</button>
								       <button id="" type="submit"  name="ingresarProducto" class=" btn btn-success">Registrar Objeto</button>
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