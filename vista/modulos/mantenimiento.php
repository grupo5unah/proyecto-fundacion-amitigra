<script>
	//Solo permite introducir numeros.
	function soloNumeros(e) {
		var key = window.event ? e.which : e.keyCode;
		if (key < 48 || key > 57) {
			e.preventDefault();
		}
	}


	function soloLetras(e) {
		var key = e.keyCode || e.which,
			tecla = String.fromCharCode(key).toLowerCase(),
			letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
			especiales = [8, 37, 39, 46],
			tecla_especial = false;
		for (var i in especiales) {
			if (key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}
		if (letras.indexOf(tecla) == -1 && !tecla_especial) {
			return false;
		}
	}
	SinEspacio = function(input) {
		input.value = input.value.replace(' ', '');
	}

	//Permitir solo un ESPACIO
	espacio_Letras = function(input) {
		input.value = input.value.replace('  ', ' ');
	}


	function validaemail(valor) {
		re = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
		if (!re.exec(valor)) {
			$res['msj'] = "Email no valido";
		}

	}


	function mostrarPassword() {
		var cambio = document.getElementById("Contraseña");
		if (cambio.type == "password") {
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		} else {
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

	function mostrarPassword2() {
		var cambio = document.getElementById("ConfirmarContraseña");
		if (cambio.type == "password") {
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		} else {
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

	function mostrarPasswordreset() {
		var cambio = document.getElementById("Contraseña_reset");
		if (cambio.type == "password") {
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		} else {
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}

	function mostrarPassword2reset() {
		var cambio = document.getElementById("ConfirmarContraseña_reset");
		if (cambio.type == "password") {
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		} else {
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	}
</script>

<?php include("./modelo/conexionbd.php"); 

$id_objeto = 20;
$rol_usuario = $_SESSION["rol"];
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador"){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">

	<section class="content-header">
      <h1>Mantenimiento<small> usuarios</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="panel"><i class="fa fa-cogs"></i> panel de control</a></li>
		<li><a><i class="fa fa-users"></i> mantenimiento usuario</a></li>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de usuarios</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<!-- <button  class="btn btn-default button1 btnCrearRol" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar rol
									</button> -->
									<a href="reporteGUsuarios.php" target="_blank" rel="noopener noreferrer" class="btn btn-default"><i class="fa fa-download"></i>Generar Reporte PDF</a>
									<button class="btn btn-default btnCrearUsuario glyphicon glyphicon-plus-sign">Agregar Usuario</button>
								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="tablaMantenimientoUsuarios">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Usuario</th>
											<th>Genero</th>
											<th>Telefono</th>
											<th>Correo</th>
											<th>Rol</th>
											<th>Estado</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try {
											$stmt = "SELECT id_usuario, nombre_completo, nombre_usuario, genero,telefono,correo,
                                            contrasena,r.id_rol,r.rol,est.nombre_estado,est.id_estado
               								FROM tbl_usuarios u inner JOIN tbl_roles r
											ON u.rol_id=r.id_rol INNER JOIN tbl_estado est
											ON u.estado_id=est.id_estado
											ORDER BY id_usuario";
											$resultado = $conn->query($stmt);
										} catch (Exception $e) {
											$error = $e->getMessage();
										}
										$vertbl = array();
										while ($evento = $resultado->fetch_assoc()) {
											$traer = $evento['nombre_usuario'];
											$evento = array(
												'nombre_completo' => $evento['nombre_completo'],
												'nombre_usuario' => $evento['nombre_usuario'],
												'genero' => $evento['genero'],
												'telefono' => $evento['telefono'],
												'correo' => $evento['correo'],
												'contrasena' => $evento['contrasena'],
												'rol' => $evento['rol'],
												'id_rol' => $evento['id_rol'],
												'nombre_estado' => $evento['nombre_estado'],
												'id_usuario' => $evento['id_usuario'],
												'id_estado' => $evento['id_estado']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_usuarios) { ?>
											<?php foreach ($lista_usuarios as $evento) { ?>

												<tr>

													<td><?php echo $evento['nombre_completo']; ?></td>
													<td><?php echo $evento['nombre_usuario']; ?></td>
													<td><?php echo $evento['genero']; ?></td>
													<td><?php echo $evento['telefono']; ?></td>
													<td><?php echo $evento['correo']; ?></td>
													<td><?php echo $evento['rol']; ?></td>
													<td><?php echo $evento['nombre_estado']; ?></td>
													<td>




														<button class="btn btn-warning btnEditarUsuario glyphicon glyphicon-pencil" data-idusuario="<?= $evento['id_usuario'] ?>" data-nombrecompleto="<?= $evento['nombre_completo'] ?>" data-nombreusuario="<?= $evento['nombre_usuario'] ?>" data-genero="<?= $evento['genero'] ?>" data-telefono="<?= $evento['telefono'] ?>" data-correo="<?= $evento['correo'] ?>" data-contrasena="<?= $evento['contrasena'] ?>" data-rol="<?= $evento['rol'] ?>" data-id_rol="<?= $evento['id_rol'] ?>" data-nombre_estado="<?= $evento['nombre_estado'] ?>" data-id_estado="<?= $evento['id_estado'] ?>"></button>

														<button class="btn btn-danger btnEliminarUsuario glyphicon glyphicon-remove" data-idusuario="<?php echo $evento['id_usuario'] ?>"></button>

														<button class="btn btn-resetear btnResetearClaves fa fa-key" style="width:40px" style="height:50px;" data-idusuario="<?= $evento['id_usuario'] ?>" data-contrasena="<?= $evento['contrasena'] ?>"></button>
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

			<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Actualizar Usuario</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="formEditarProducto">
								<div class="ingreso-producto form-group">
									<div class="campos" type="hidden">
										<label for=""> </label>
										<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
									</div>


									<div class="campos form-group">
										<input id="nombrecompct" class="form-control modal-roles secundary" type="text" name="nombrecompct" placeholder="Nombre Completo" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacio_Letras(this); verificar(this.value)" required />
									</div>

									<div class="campos form-group">
										<input id="nombreusuarioact" class="form-control modal-roles secundary" type="text" name="nombreusuarioact" placeholder="Nombre de usuario" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); SinEspacio(this);" required />

									</div>
									<div class="campos form-group">
										<input id="telefonoact" maxlength="8" minlength="8" class="form-control modal-roles secundary" type="text" name="telefonooact" placeholder="Telefono" onkeypress="return soloNumeros(event)" required />
									</div>

									<div class="campos form-group">
										<input id="correoact" class="form-control modal-roles secundary" type="text" name="correoact" placeholder="Correo" required />
									</div>



									<?php
									include('./modelo/conexionbd.php');
									$consult_rol = mysqli_query($conn, "SELECT id_rol,rol FROM `tbl_roles` WHERE estado_eliminado=1");
									$result = mysqli_num_rows($consult_rol);
									?>

									<select class="form-control" name="rolact" id="rolact" style="width: 350px" required>
										<option value="Seleccione un Rol">Seleccione un Rol</option>
										<?php
										if ($result > 0) {
											while ($rol = mysqli_fetch_array($consult_rol)) {
										?>
												<option value="<?php echo $rol["id_rol"]; ?>"><?php echo $rol["rol"] ?></option>
										<?php
											}
										}
										?>

									</select><br>

									<?php
									include('./modelo/conexionbd.php');
									$consult_estado = mysqli_query($conn, "SELECT id_estado,nombre_estado
									FROM tbl_estado
									WHERE nombre_estado IN ('ACTIVO','BLOQUEADO','NUEVO') && estado_eliminado=1
									   ");
									$result = mysqli_num_rows($consult_estado);
									?>
									<select class="form-control" name="estadoact" id="estadoact" style="width: 350px" required>
										<option value="Seleccione un Estado">Seleccione un Estado</option>
										<?php
										if ($result > 0) {
											while ($rol = mysqli_fetch_array($consult_estado)) {
										?>
												<option value="<?php echo $rol["id_estado"]; ?>"><?php echo $rol["nombre_estado"] ?></option>
										<?php
											}
										}
										?>
									</select>


									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary" onclick="validaemail(correoact.value);">Actualizar Usuario</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal para Resetear la contraseña -->

			<div class="modal fade" id="modalResetearClave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Resetear Contraseña</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="formResetearcontra">
								<div class="ingreso-producto form-group">
									<div class="campos" type="hidden">
										<label for=""> </label>
										<input autocomplete="off" class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
									</div>

									<div class="campos form-group">
										<label for="">Nueva Contraseña</label>
										<input id="Contraseña_reset" style="width:320px" class="" type="password" placeholder="Contraseña" required /></center>
										<button id="show_pasword" style="width:40px" class="" type="button" onclick="mostrarPasswordreset()">
											<span class="fa fa-eye-slash icon"></span></button>
									</div>
									<div class="campos form-group">
										<label for="">Repetir Nueva Contraseña</label>
										<center></center><input id="ConfirmarContraseña_reset" style="width:320px" type="password" placeholder="Confirmar Contraseña" required /> </center>
										<button id="show_pasword" style="width:40px" class="" type="button" onclick="mostrarPassword2reset()">
											<span class="fa fa-eye-slash icon"></span></button>
									</div>

									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button id="btnResetClave" type="button" class="btnResetClave btn btn-primary">Resetear Contraseña</button>
						</div>
					</div>
				</div>
			</div>

			<!-- modal registrar usuario -->
			<div class="modal fade" id="modalCrearUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar Usuario</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="" id="formGusuarios" onpaste="return false">
								<div class=" form-group">
									<div class="campos form-group" type="hidden">
										<label for=""> </label>
										<input class="form-control modal-roles secundary" type="hidden" name="idInventario" value="0" disabled>
									</div>

									<div class="campos form-group">
										<input id="nombreCompleto" maxlength="40" minlength="40" style="width:335px" class="form-control modal-roles secundary" type="text" name="nombreCompleto" placeholder="Nombre Completo" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
										espacio_Letras(this); verificar(this.value)" required />
									</div>

									<div class="campos form-group">
										<input id="nombreusuario" maxlength="30" minlength="30" style="width:335px" class="form-control modal-roles secundary" type="text" name="nombreusuario" placeholder="Nombre de usuario" onblur="limpianombre()" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); 
										
										SinEspacio(this)" required />
									</div>

									<div class="campos form-group">
										<input id="telefono" autocomplete="off" style="width:335px" maxlength="8" minlength="8" class="form-control modal-roles 
										secundary" type="tel" onpaste="return false" placeholder="Telefono" onkeypress="return soloNumeros(event)" onblur="limpia()" required /></center>
									</div>
									<div class="campos form-group">

										<input id="correo" style="width:335px" class="form-control modal-roles secundary" type="email" name="cantidad" placeholder="Correo" onkeyup="validarEmail(this)" required />
									</div>

									<div class="campos form-group">
										<input id="Contraseña" class="" style="width:295px" type="password" placeholder="Contraseña" required />
										<button id="show_pasword" class="" style="width:37px" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span></button>
									</div>

									<div class="campos form-group">
										<input id="ConfirmarContraseña" style="width:295px" type="password" placeholder="Confirmar Contraseña" required />
										<button id="show_pasword" class="" style="width:37px" type="button" onclick="mostrarPassword2()"> <span class="fa fa-eye-slash icon"></span></button>
									</div>

									<div class="campos form-group">
										<select class="form-control" id="genero" name="genero" style="width:335px" required>
											<option value="">Seleccione un Genero</option>
											<option value="masculino">Masculino</option>
											<option value="femenino">Femenino</option>

										</select>
									</div>
									<?php
									include('./modelo/conexionbd.php');
									$consulta_rol = mysqli_query($conn, "SELECT id_rol,rol FROM `tbl_roles` where estado_eliminado=1");
									$resultados = mysqli_num_rows($consulta_rol);
									?>
									<div class="campos form-group">
										<select class="form-control" name="rol" id="rol" style="width:335px" required>
											<option value="">Seleccione un Rol</option>
											<?php
											if ($resultados > 0) {
												while ($rol = mysqli_fetch_array($consulta_rol)) {
											?>
													<option value="<?php echo $rol["id_rol"]; ?>"><?php echo $rol["rol"] ?></option>
											<?php
												}
											}
											?>
									</div>

									</select>
									<div class="campos form-group">
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>


										<button id="" type="submit" name="ingresarProducto" class="btn btn-primary" onclick="validaemail(correo.value);">Registrar Usuario</button>
									</div>

							</form>
						</div>
					</div>
				</div>

				<!-- /.box-footer-->
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