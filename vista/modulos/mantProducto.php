<?php require './modelo/conexionbd.php';

$id_objeto = 32;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>

<div class="content-wrapper" oncopy="return false" onpaste="return false">



	<section class="content-header">
		<h1>Mantenimiento de Producto</h1>
		<ol class="breadcrumb ">
			<li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
			<li class="btn btn-success uppercase fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
			<li class="btn btn-success uppercase fw-bold"><a href="existencias"><i class="fas fa-inventory"></i> Inventario General</a></li>
			<li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fab fa-product-hunt"></i> Mantenimento Producto</a></li>
		</ol>
	</section>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Producto</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
								<button class="btn btn-success button1 text-uppercase" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar producto </button>

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantenimientoProducto">
									<thead style=" background-color: #222d32; color: white;">
										<tr>
											<th>Nombre Producto</th>
											<th>Precio de compra</th>
											<th>Cantidad</th>
											<th>Descripcion</th>
											<th>Tipo Producto</th>
											<th>Precio de Alquiler</th>
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

											$sql = "SELECT tbl_producto.id_producto, tbl_producto.nombre_producto, tbl_producto.precio_compra , tbl_producto.cantidad_producto, tbl_producto.descripcion, tbl_producto.precio_alquiler, tbl_tipo_producto.nombre_tipo_producto, tbl_producto.creado_por, tbl_producto.fecha_creacion, tbl_producto.modificado_por, tbl_producto.fecha_modificacion FROM tbl_producto RIGHT JOIN tbl_tipo_producto ON tbl_producto.tipo_producto_id = tbl_tipo_producto.id_tipo_producto where tbl_producto.estado_eliminado=1 and tbl_tipo_producto.estado_eliminado = 1 ";

											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos['nombre_producto'];
											$evento = array(
												'nombreP' => $eventos['nombre_producto'],
												'precioP' => $eventos['precio_compra'],
												'cantidadP' => $eventos['cantidad_producto'],
												'descripcion' => $eventos['descripcion'],
												'tipo_producto' => $eventos['nombre_tipo_producto'],
												'precioAl' => $eventos['precio_alquiler'],
												'creado_por' => $eventos['creado_por'],
												'fecha_creacion' => $eventos['fecha_creacion'],
												'modificado_por' => $eventos['modificado_por'],
												'fecha_modificacion' => $eventos['fecha_modificacion'],
												'id_P' => $eventos['id_producto']
											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['nombreP']; ?></td>
													<td> <?php echo $evento['precioP']; ?></td>
													<td> <?php echo $evento['cantidadP']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
													<td> <?php echo $evento['tipo_producto']; ?></td>
													<td> <?php echo $evento['precioAl']; ?></td>
													<td> <?php echo $evento['creado_por']; ?></td>
													<td> <?php echo $evento['fecha_creacion']; ?></td>
													<td> <?php echo $evento['modificado_por']; ?></td>
													<td> <?php echo $evento['fecha_modificacion']; ?></td>
													<td>
														
														<?php if($columna["permiso_actualizacion"] == 1):?>
														<button class="btn btn-warning btnEditarProducto glyphicon glyphicon-pencil" data-idProduct="<?= $evento['id_P'] ?>" data-nomProducto="<?= $evento['nombreP'] ?>" data-precioP="<?= $evento['precioP'] ?>" data-cantProducto="<?= $evento['cantidadP'] ?>" data-desc="<?= $evento['descripcion'] ?>" data-TP="<?= $evento['tipo_producto'] ?>" data-precioAl="<?= $evento['precioAl'] ?>"></button>
														<?php
														else:
														endif;

														if($columna["permiso_eliminacion"] == 1):
														?>
														<button class="btn btn-danger btnDeleteP glyphicon glyphicon-remove" data-idP="<?php echo $evento['id_P'] ?>"></button>
														<?php
														else:
														endif;
														?>
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

				</div> <!-- /row -->


			</div>
			<!-- /.box-body -->

			<div class="modal fade" id="modalEditarProductos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" data-target=".bd-example-modal-lg">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Actualizar Producto</h3>
							</div>
						</div>
						<div class="modal-body">
							<form name="">
								<div class="ingreso-producto form-group">

									<div class="campos">
										<label for="">Nombre Producto </label>
										<input id="product" class="form-control modal-roles secundary text-uppercase" type="text" required onkeypress="return soloLetra(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />

									</div>
									<div class="campos">
										<label for="">Precio de Compra</label>
										<input id="price" class="form-control modal-roles secundary text-uppercase" type="text" required onkeypress="return soloNumero(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />

									</div>
									<div class="campos">
										<label for="">Cantidad</label>
										<input id="count" class="form-control modal-roles secundary text-uppercase" type="text" required onkeypress="return soloNumero(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
									</div>
									<div class="campos">
										<label for="">Descripcion </label>
										<input id="des" class="form-control modal-roles secundary text-uppercase" type="text" required onkeypress="return soloLetra(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />

									</div>
									
									<div class=" form-group " style="width: 400px;">
										<label for=""> Tipo de Producto</label>
										<select name="tipo_producto" id="typeP" style="width: 243px;" class="js-example-basic-multiple js-states typep" >
											<option value="0" id="opcion"></option>
											<?php

											$sql = "SELECT id_tipo_producto, nombre_tipo_producto FROM tbl_tipo_producto";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while ($row = $result->fetch_assoc()) {
													echo "<option value=" . $row['id_tipo_producto'] . ">" . $row['nombre_tipo_producto'] . "</option>";
												}
											} else {
												echo "0 results";
											}
											$conn->close();
											?>
										 </select>
									</div>
									<div class="campos">
											<label for="">Precio Alquiler </label>
											<input id="Rprice" class="form-control modal-roles secundary text-uppercase" type="text" required onkeypress="return soloNumero(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" disabled/>

									</div>

										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
								</div>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button id="btnEditarBD" type="button" class="btnEditarBD btn btn-primary text-uppercase">Actualizar Producto</button>
						</div>
					</div>
				</div>
			</div>

			<!-- modal para crear un producto -->
			<div class="modal fade" id="modalCrearProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content" style="width: 900px;">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar Producto</h3>
								</div>
							</div>
							<div class="modal-body">
								<form method="POST" id="formProducto" role="form" class="validarFORM" style="text-align:center;">
									<div class="row d-flex  justify-content-around">

										<div class="col-sm-3 form-group " id="groupP">
											<label for=""> PRODUCTO </label>
											<input id="nombreP" class="form-control   secundary text-uppercase" type="text" name="nombreP" min="0" maxlength="10" minlength="3" placeholder="Escriba el producto" required onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
										</div>

										<div class="col-sm-3 m-auto form-group ">
											<label for="">PRECIO </label>
											<div class="input-group">
												<span class="input-group-addon">$</span>
												<input id="precioProducto" class="form-control  secundary " type="number" name="precioProducto" placeholder="Lps:1.00" onkeypress="return soloNumero(event)" autocomplete="off" min="1" required />

											</div>
										</div>
										<div class="col-sm-2 form-group ">
											<label>DESCRIPCION </label>
											<input id="descripcion" class="form-control   secundary text-uppercase" type="text" name="descripcion" placeholder="Escriba la descripcion(lbs,uds)" required onkeypress="return soloLetra(event)" onkeyup="javascript:this.value=this.value.toUpperCase()" autocomplete="off" />
										</div>
										<div class="col-sm-2 form-group justify-content-between">
											<label for=""> TIPO PRODUCTO</label>
											<select name="tipoProducto" id="tipoProducto" class=" input-group">
												<option value="0">Seleciona una Opción</option>
												<?php

												$sql = "SELECT id_tipo_producto, nombre_tipo_producto FROM tbl_tipo_producto";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													while ($row = $result->fetch_assoc()) {
														echo "<option value=" . $row['id_tipo_producto'] . ">" . $row['nombre_tipo_producto'] . "</option>";
													}
												} else {
													echo "0 results";
												}
												//$conn->close();
												?>
											</select>

										</div>

									</div>
									<div>
										<div class="col-sm-3 m-auto form-group ">
											<label for="">CANTIDAD INICIAL </label>
											<div class="input-group">

												<input id="inicial" class="form-control  secundary " type="number" name="precioProducto" placeholder="Lps:1.00" onkeypress="return soloNumero(event)" autocomplete="off" min="1" minlength="1" required />

											</div>
										</div>
										<div class="col-sm-3 m-auto form-group ">
											<label for="">MINIMO</label>
											<div class="input-group">
												<input id="minimo" class="form-control  secundary " type="number" name="precioProducto" placeholder="1" minlength="1" onkeypress="return soloNumero(event)" autocomplete="off" min="1" required />

											</div>
										</div>
										<div class="col-sm-3 m-auto form-group ">
											<label for="">MAXIMO </label>
											<div class="input-group">

												<input id="maximo" class="form-control  secundary " type="number" name="precioProducto" placeholder="1" minlength="1" onkeypress="return soloNumero(event)" autocomplete="off" min="1" required />

											</div>
										</div>

										<input id="btnAddList" style=" width:25px; height:22px; margin-left:15px;  padding:0;" type="button" class=" input-group btn btn-success agregar-table aling-item glyphicon glyphicon-plus-sign" value="+">
										<input type="hidden" id="btnProductUpdate" class=" glyphicon glyphicon-saved btn btn-primary agregar-table">
									</div>
									<!-- select id_tipo_movimiento FROM tbl_tipo_movimiento where movimiento = "ENTRADA"; -->
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									<?php

									$sql = "SELECT id_tipo_movimiento FROM tbl_tipo_movimiento where movimiento = 'ENTRADA'";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										// output data of each row
										while ($row = $result->fetch_assoc()) {
											$id = ($row['id_tipo_movimiento']); ?>
											<input type="hidden" name="" id="entrada" value="<?php echo ($id); ?>">
									<?php	}
									} else {
										echo "0 results";
									}
								

									$sql = "SELECT id_localidad FROM tbl_localidad where nombre_localidad = 'TEGUCIGALPA'";
									$result = $conn->query($sql);

									if ($result->num_rows > 0) {
										// output data of each row
										while ($row = $result->fetch_assoc()) {
											$id = ($row['id_localidad']); ?>
											<input type="hidden" name="" id="id_local" value="<?php echo ($id); ?>">
									<?php	}
									} else {
										echo "0 results";
									}
									$conn->close();
									?>
									<!-- <input type="hidden" name="" id="tipo_movimiento" value="<?= $usuario ?>"> -->
								</form>
								<div id="producto">
									<table id="productTable" data-page-length='10' class=" table table-hover table-condensed table-bordered">
										<thead>
											<tr>
												<td>#</td>
												<td>Nombre Producto</td>
												<td>Precio</td>
												<td>Descripcion</td>
												<td>Tipo Producto</td>
												<td>Cantidad Inicial</td>
												<td>Minimo</td>
												<td>Maximo</td>

												<?php if ($columna["permiso_actualizacion"] == 0 && $columna["permiso_eliminacion"] == 0) :

												else : ?>
													<td>Acciones</td>
												<?php
												endif;
												?>
											</tr>
										</thead>
										<tbody id="row1" class="tbody">
										</tbody>
									</table>


								</div>

								<?php
								if (isset($_GET['msg'])) {
									$mensaje = $_GET['msg'];
									print_r($mensaje);
									//echo "<script>alert(".$mensaje.");</script>";  
								}

								?>

								<div class="modal-footer">
									<button type="button" class="btn btn-Danger" id="cerrar" data-dismiss="modal">Close</button>
									<button type="button" id="registrarInventario" class=" btn btn-primary">Registrar </button>
								</div>
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