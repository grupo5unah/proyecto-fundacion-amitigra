<?php require "./modelo/conexionbd.php";

$id_objeto = 31;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>

<div class="content-wrapper">

<section class="content-header">
		<h1>MANTENIMIENTO PREGUNTAS</h1>
		<ol class="breadcrumb ">
			<li class="btn btn-success  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
			<li class="btn btn-success  fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
			<li class="btn btn-success  active fw-bold "><a href="#"><i class="fas fa-cogs"></i> Mantenimiento Preguntas</a></li>
			
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<!-- Default box -->
		<div class="box"  oncopy="return false" onpaste="return false">
			<div class="box-header with-border">

			</div>
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de preguntas</div>
								<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">

									<?php if($columna["permiso_insercion"] == 1):?>
									<button class="btn btn-success btnCrearPregunta glyphicon glyphicon-plus-sign text-uppercase" >Agregar Nueva Pregunta</button>
									<?php
									else:
									endif;
									?>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="managerPreguntas">
									<thead style=" background-color: #222d32; color: white;">
										<tr>
											<th>Pregunta</th>
											<th>creado por</th>
                                            <th>Fecha creacion</th>
                                            <th>Modificado por</th>
											<th>Fecha modificacion</th>
											<?php if($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0):
											
											else:?>
											<th>Acciones</th>
											<?php endif;
											?>
										</tr>
									</thead>
									<tbody>
										<?php
										try {
											$sql = "SELECT id_pregunta,pregunta,creado_por,fecha_creacion,modificado_por,fecha_modificacion
                                                            FROM tbl_preguntas where estado_eliminado = 1;";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['pregunta'];
											$evento = array(
												'pregunta1' => $eventos['pregunta'],
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
													<td> <?php echo $evento['pregunta1']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
                                                    <td> <?php echo $evento['fecha_creacion']; ?></td>
                                                    <td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>

														<?php if($columna["permiso_actualizacion"] == 1):?>
														<button class="btn btn-warning btnEditarPreg glyphicon glyphicon-pencil" data-idpregunta="<?= $evento['id_pregunta'] ?>" data-nomPregunta="<?= $evento['pregunta1'] ?>"></button>
														<?php
														else:
														endif;

														if($columna["permiso_eliminacion"] == 1):
														?>
														<button class="btn btn-danger btnEliminarPregunta glyphicon glyphicon-remove" data-idpregunta="<?php echo $evento['id_pregunta']; ?>"></button>
														<?php
														else:
														endif;
														?>
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
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
											<input id="pregunta1" class="form-control secundary text-uppercase" type="text" name="" placeholder="Escriba la pregunta" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

										</div>
					
										
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
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                          <input id="pregunta" class="form-control modal-roles secundary text-uppercase" type="text" name="nombreProducto" placeholder="Escriba la pregunta" required onkeypress="return soloLetrasNumeros(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off"/>

                          </div>
                                
                         
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

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>