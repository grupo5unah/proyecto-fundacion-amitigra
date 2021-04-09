<?php include("./modelo/conexionbd.php");

$id_objeto = 13;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "asistente") {
	if ($columna["permiso_consulta"] == 1) {

?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					PRODUCTOS
				</h1>
				<ol class="breadcrumb ">
					<li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
					<li class="btn btn-success uppercase fw-bold"><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
					<li class="btn btn-success uppercase fw-bold"><a href="existencia"><i class="fas fa-inventory"></i> Inventario General</a></li>
					<li class="btn btn-success active uppercase fw-bold "><a href="#"></a><i class="fa fa-users"></i> Producto</a></li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Existencia</h3>

					</div>
					<div class="box-body">
						<!--LLamar al formulario aqui-->
						<div class="row">
							<div class="col-md-12">

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Movimientos</div>
									</div>
									<div class="panel-body">
										<div class="remove-messages"></div>
										<div class="div-action pull pull-right" style="padding-bottom:20px;">

											<?php if ($columna["permiso_insercion"] == 0) :

											else : ?>
												<button class="btn btn-success button1 text-uppercase" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar producto </button>
												<button class="btn btn-success button1 text-uppercase" id=""> <i class="glyphicon glyphicon-plus-sign"></i> movimientos </button>

											<?php
											endif;
											?>

										</div>

										<table data-page-length='10' class=" display data-results table table-striped table-hover table-bordered ui celled table" style="width:100%;" id="managerInventario">
											<thead>
												<tr>
													<th style="background-color:#f0ff33" COLSPAN=3>INVENTARIO GENERAL</th>
													<th style="background-color:#33ffc1" COLSPAN=2>ENTRADA</th>
													<th style="background-color:#ffb533" COLSPAN=3>SALIDA</th>
												</tr>
												<tr>
													<th>Nombre del producto</th>
													<th>Incial</th>
													<th>Stock</th>
													<th>FECHA ENTRADA</th>
													<th>CANTIDAD</th>
													<th>FECHA SALIDA</th>
													<th>CANTIDAD</th>
													<th>Estado</th>
												</tr>

											</thead>
											<tbody>
												<?php
												try {

													$sql = "SELECT  tbl_inventario.id_inventario, tbl_producto.nombre_producto, tbl_inventario.existencias from tbl_inventario INNER JOIN tbl_producto on tbl_inventario.producto_id= tbl_producto.id_producto  WHERE estado_eliminar=1";
													$resultado = $conn->query($sql);
												} catch (\Exception $e) {
													echo $e->getMessage();
												}

												$vertbl = array();
												while ($eventos = $resultado->fetch_assoc()) {

													$traer = $eventos['existencias'];
													$evento = array(
														'nombre_arti' => $eventos['nombre_producto'],
														'existencia' => $eventos['existencias'],
														'id_inventario' => $eventos['id_inventario'],

													);
													$vertbl[$traer][] =  $evento;
												}
												foreach ($vertbl as $dia => $lista_articulo) { ?>


													<?php foreach ($lista_articulo as $evento) { ?>
														<tr>
															<td> <?php echo $evento['nombre_arti']; ?></td>
															<td class="exis"><?php echo $evento['existencia']; ?></td>
															<td> <?php echo $evento['nombre_arti']; ?></td>
															<td> <?php echo $evento['nombre_arti']; ?></td>
															<td><?php echo $evento['existencia']; ?></td>
															<td> <?php echo $evento['nombre_arti']; ?></td>
															<td> <?php echo $evento['nombre_arti']; ?></td>

															<td> <button class="btn btn-success btnSumarI glyphicon glyphicon-plus" data-idinve="<?php echo $evento['id_inventario']; ?>" data-nombre="<?= $evento['nombre_arti'] ?>" data-stock="<?= $evento['existencia'] ?>"></button> </td>

														<?php  } ?>
														</tr>
													<?php  } ?>

											</tbody>
										</table>


									</div>
								</div>
							</div>
							<!-- <?php //$conn->close(); 
									?> -->
						</div> <!-- /row -->




					</div>


				</div>
				<!-- /.box -->
				<!-- //modal para agregar stock -->
				<div class="modal fade" id="agregarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Actualizar</h3>
								</div>
							</div>
							<div class="modal-body">
								<form name="" id="">
									<div id="pro"> </div>
									<div class=" form-group">

										<div class="campos form-group">
											<input type="text" id="nuevo">

										</div>


										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
									</div>


							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="" type="button" name="idStock" class="idStock btn btn-success ">Actualizar</button>
							</div>
							</form>
						</div>
					</div>
				</div>

				<!-- modal para ingresar un producto nuevo -->



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
									<button type="button" class="btn btn-Danger" id="cerrar" >Close</button>
									<button type="button" id="registrarInventario" class=" btn btn-primary">Registrar </button>
								</div>
							</div>

						</div>
					</div>
				</div>


		</div>



		<!-- /.box-footer-->

		</section>
		<!-- /.content -->
		</div>
<?php

	} else {
		echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";
	}
} ?>