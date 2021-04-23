<?php include("./modelo/conexionbd.php");

$id_objeto = 19;
$rol = $_SESSION["rol"];
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador"){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">
	
	<section class="content-header">
      <h1>Mantenimiento<small> clientes</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="panel"><i class="fa fa-cogs"></i> panel de control</a></li>
		<li><a><i class="fa fa-users"></i> mantenimiento clientes</a></li>
      </ol>
      <br>
    </section>

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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Clientes</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<?php
								if($columna["permiso_insercion"] == 0):
								
								else:?>
								<button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
								<?php
								endif;
								?>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantClienteTable">
									<thead>
										<tr style="background-color: #222d32; color: white;">

											<th class="text-center">Nombre completo</th>
											<th class="text-center">Identidad</th>
											<th class="text-center">Telefono</th>
											<th class="text-center">Tipo nacionalidad</th>
											<th class="text-center">Modificado por</th>
											<th class="text-center">Fecha Modificación</th>
											<th class="text-center">Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_cliente,nombre_completo,identidad,telefono,tbl_clientes.tipo_nacionalidad,tbl_tipo_nacionalidad.nacionalidad, 
													tbl_clientes.modificado_por,tbl_clientes.fecha_modificacion
													FROM tbl_clientes
                                                    INNER JOIN tbl_tipo_nacionalidad
                                                    ON tbl_clientes.tipo_nacionalidad = tbl_tipo_nacionalidad.id_tipo_nacionalidad
                                                    WHERE tbl_clientes.estado_eliminado = 1";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['nombre_completo'];
											$evento = array(
												'nombre_completo' => $eventos['nombre_completo'],
												'identidad' => $eventos['identidad'],
												'telefono' => $eventos['telefono'],
												'nacionalidad' => $eventos['nacionalidad'],
												'tipo_nacionalidad' => $eventos['tipo_nacionalidad'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
                                                'id_cliente' => $eventos['id_cliente']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td class="text-center"> <?php echo $evento['nombre_completo']; ?></td>
													<td class="text-center"> <?php echo $evento['identidad']; ?></td>
													<td class="text-center"> <?php echo $evento['telefono']; ?></td>
													<td class="text-center"> <?php echo $evento['nacionalidad']; ?></td>
													<td class="text-center"> <?php echo $evento['modificado_por']; ?></td>
													<td class="text-center"> <?php echo $evento['fecha_modificacion']; ?></td>
													<td class="text-center">
													<?php
													if($columna["permiso_actualizacion"] == 1):?>
														<button class="btn btn-warning btnEditarCliente glyphicon glyphicon-pencil"  data-idcliente="<?= $evento['id_cliente'] ?>" data-nombrecliente="<?= $evento['nombre_completo'] ?>" 
														data-identidad="<?= $evento['identidad'] ?>" data-telefono="<?= $evento['telefono'] ?>" data-tipo_nacionalidad="<?= $evento['tipo_nacionalidad'] ?>"data-nacionalidad="<?= $evento['nacionalidad'] ?>"></button>
													<?php
													else:
													endif;
													
													if($columna["permiso_eliminacion"] == 1):
													?>
														<button class="btn btn-danger btnEliminarCliente glyphicon glyphicon-remove" data-idclient="<?php echo $evento['id_cliente'] ?>"></button>
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

							</div>
						</div>
					</div>
					<?php $conn->close(); ?>
				</div>


			</div>
	
			<div class="modal fade" id="modalEditarCliente" tabindex="-1"
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
							<form name="formEditarCliente" onpaste="return false">
								<div class="ingreso-producto form-group">
									
									<div class="campos">
										<label for="">Nombre Cliente: </label>
										<input id="nombre_cliente" class="form-control  modal-roles secundary text-uppercase" type="text" name="cliente" placeholde="Escriba el nombre del cliente" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

									</div>
									<div class="campos form-group">
										<label for="">Identidad: </label>
										<input id="identidad" class="form-control  modal-roles secundary text-uppercase" type="text" name="identidad"placeholde="Escriba la identidad"  onkeydown="return soloNumeros(event)" required/>

									</div>
									<div class="campos form-group">
										<label for="">Telefono: </label>
										<input id="telefono" class="form-control  modal-roles secundary text-uppercase" type="tel" name="telefono" placeholde="Escriba el telefono" onkeydown="return soloNumeros(event)" required/>

									</div>
									<div class="campos form-group">
										<label for="">Nacionalidad: </label>
										<select class="form-control" name="nacionalidad" id="nacionalidad">
											<option value="" disabled selected>Selecione...</option>
											<?php 
											require ('./modelo/conexionbd.php');

											$stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
											$resultado = mysqli_query($conn,$stmt);
											?>
											<?php foreach($resultado as $opciones):?>
											<option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
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
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Cliente</h3>
									</div>
								</div>
								<div class="modal-body">
									<form name="" id="formCliente" onpaste="return false">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Nombre Cliente: </label>
												<input id="nombreCliente" class="form-control modal-roles secundary text-uppercase" type="text" name="nombrecliente" placeholder="Nombre cliente" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()"/>

											</div>
											<div class="campos form-group">
												<label for="">Identidad: </label>
												<input id="ident" name="ident"  class="form-control  modal-roles secundary text-uppercase" type="tex"  placeholder="Identidad" onkeydown="return soloNumeros(event)" required/>

											</div>
											<div class="campos form-group">
												<label for="">Telefono: </label>
												<input id="tel" name="tel" class="form-control  modal-roles secundary text-uppercase" type="text"  placeholder="Telefono" onkeydown="return soloNumeros(event)" required/>

											</div>
                                            <div class="campos form-group">
                                                <label for="">Nacionalidad: </label>
                                                <select class="form-control" name="nacion" id="nacion">
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
										<button id=""type="submit" class=" btn btn-primary">Registrar  Cliente</button>
										</div>
										
									</form>
								</div>
								
							</div>
						</div>
					</div>

				
				</div>

	</section>
</div>

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>