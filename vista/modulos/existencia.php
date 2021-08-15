<?php include("./modelo/conexionbd.php");

$id_objeto = 13;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if ($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "asistente") {
	if ($columna["permiso_consulta"] == 1) {

?>
		<input type="hidden" name="" id="id_usuario" value="<?= $_SESSION['id'] ?>">
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Inventario General
				</h1>
				<ol class="breadcrumb ">
					<li class="  fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
					
					<li class="  fw-bold"><a href="existencia"><i class="fas fa-inventory"></i> Inventario General</a></li>

				</ol>
			</section>
			<!-- Main content -->
			<section class="content">

				<!-- Default box -->
				<div class="box">
					<div class="box-header with-border">
						<h3 class=" glyphicon glyphicon-edit">Listado de productos</h3>

					</div>
					<div class="box-body">
						<div class="div-action pull pull-right" style="padding-bottom:20px;">

							<?php if ($columna["permiso_insercion"] == 0) :

							else : ?>
								
								<a href="movimientos " class="btn btn-success button1 text-uppercase" id=""> <i class="glyphicon glyphicon-plus-sign"></i> movimientos </a>

								<!-- <button id="reporte" class="btn btn-default button1 reporte"> REPORTE <i class="glyphicon glyphicon-plus-sign"></i></button> -->

							<?php
							endif;
							?>

						</div>
						<!--LLamar al formulario aqui-->
						<div class="row">
							<div class="col-md-12">

								<div class="panel panel-default">
									
									<div class="panel-body">
										
										<div class="row d-flex  justify-content-around" style="margin-left:50px;">
											<div  class="col-sm-3 m-3px" style=" width:30%; margin-left:25px;">
												<table data-page-length='10' class=" display data-results table table-striped table-hover table-bordered ui celled table" style="width:100%;" id="managerInventarios">
													<thead>
														<tr style="background-color:#222d32; color:white">
															<th colspan="3" style=" text-align:center;">Inventario General
															</th>
														</tr>

														<tr style="background-color:#222d32; color:white">
															<th>Producto</th>
															<th>Stock</th>
															<th>Localidad</th>
														</tr>

													</thead>
													<tbody>
														<?php
														try {

															$sql = "SELECT p.id_producto, p.nombre_producto, i.stock, p.minimo,p.maximo, l.nombre_localidad from tbl_inventario i INNER JOIN tbl_producto p on p.id_producto = i.producto_id INNER JOIN tbl_localidad l on l.id_localidad = i.localidad_id group BY p.nombre_producto;";
														} catch (\Exception $e) {
															echo $e->getMessage();
														}
														$conn->multi_query($sql);

														global $inventario;
														$inventario = array();
														do {
															$resultado = $conn->store_result();
															$row = $resultado->fetch_all(MYSQLI_ASSOC);

															//print_r($row);
															foreach ($row as $valor ) {
																echo '<tr>
													  	     	<td>' . $valor['nombre_producto'] . '</td>
														     	<td  data-maximo="'. $valor['maximo'] . '"data-minimo="'. $valor['minimo'] . '">' . $valor['stock'] . '</td>
																 <td>' . $valor['nombre_localidad'] . '</td>
													            </tr>';
															}
														} while ($conn->more_results() && $conn->next_result());


														?>

													</tbody>
												</table>
											</div>
											<div style="width:30%;" class="col-sm-3 m-3px">
												<table data-page-length='10' class=" display data-results table table-striped table-hover table-bordered ui celled table" style="width:100%;" id="managerEntrada">
													<thead>
														<tr style="background-color:#222d32; color:white">
															<th colspan="3" style=" text-align:center;">Entradas
															</th>
														</tr>

														<tr style="background-color:#222d32; color:white">
															<th>Producto</th>
															<th>Entrada</th>
															<th>Fecha_Entrada</th>

														</tr>

													</thead>
													<tbody>
														<?php
														try {
															
															$sql = "SELECT p.nombre_producto, sum(cantidad) as entrada, fecha_movimiento as fecha_entrada FROM tbl_movimientos m INNER JOIN tbl_producto p on p.id_producto=m.producto_id INNER JOIN tbl_tipo_movimiento t on t.id_tipo_movimiento=m.tipo_movimiento_id where t.movimiento='entrada' GROUP by p.nombre_producto;";
														
														} catch (\Exception $e) {
															echo $e->getMessage();
														}
														$conn->multi_query($sql);

														global $inventario;
														$inventario = array();
														do {
															$resultado = $conn->store_result();
															$row = $resultado->fetch_all(MYSQLI_ASSOC);

															//print_r($row);
															foreach ($row as $valor) {
																echo '<tr>
															    <td>' . $valor['nombre_producto'] . '</td>
													  		    <td>' . $valor['entrada'] . '</td>
														     	<td>' . $valor['fecha_entrada'] . '</td>
													          </tr>';
															}
														} while ($conn->more_results() && $conn->next_result());

														//$inventario_final=array();
														

														?>

													</tbody>
												</table>
											</div>
											<div style="width:30%;" class="col-sm-3 m-3px">
												<table data-page-length='10' class=" display data-results table table-striped table-hover table-bordered ui celled table" style="width:100%;" id="managerSalida">
													<thead>
													    <tr style="background-color:#222d32; color:white; text-align:center;" >
															<th colspan="3"style=" text-align:center;">Salidas
															</th>
														</tr>

														<tr style="background-color:#222d32; color:white">
														    <th>Producto</th>
														    <th>Salida</th>
															<th>Fecha_Salida</th>

														</tr>

													</thead>
													<tbody>
														<?php
														try {

															$sql = "SELECT p.nombre_producto, sum(cantidad) as salida, fecha_movimiento as fecha_salida FROM tbl_movimientos m INNER JOIN tbl_producto p on p.id_producto=m.producto_id INNER JOIN tbl_tipo_movimiento t on t.id_tipo_movimiento=m.tipo_movimiento_id where t.movimiento='salida' GROUP by p.nombre_producto, p.id_producto;";
														} catch (\Exception $e) {
															echo $e->getMessage();
														}
														$conn->multi_query($sql);

														global $inventario;
														$inventario = array();
														do {
															$resultado = $conn->store_result();
															$row = $resultado->fetch_all(MYSQLI_ASSOC);

															//print_r($row);
															foreach ($row as $valor ) {
																echo '<tr>
															    <td>' . $valor['nombre_producto'] . '</td>
													  		    <td>' . $valor['salida'] . '</td>
															    <td>' . $valor['fecha_salida'] . '</td>
													            </tr>';
															}
														} while ($conn->more_results() && $conn->next_result());

														//$inventario_final=array();

														?>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>




					</div>


				</div>
				<!-- /.box -->
				<!-- //modal para Reportes -->
				<div class="modal fade" id="modalReporteInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
							<i aria-hidden="true">&times;</i>
						</button>
						<div class="d-flex justify-content-between">
							<h3 class="modal-title" id="exampleModalLabel">REPORTES</h3>

						</div>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" action="" method="post" id="getOrderReportForm">
							<div class="form-group">

								<div class="col-sm-10">

									<select name="localidads" id="">
										<option value="0">Seleciona una Opción</option>
										<?php

										$sql = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
										$result = $conn->query($sql);

										if ($result->num_rows > 0) {
											// output data of each row
											while ($row = $result->fetch_assoc()) {
												echo "<option value=" . $row['id_localidad'] . ">" . $row['nombre_localidad'] . "</option>";
											}
										} else {
											echo "0 results";
										}
										$conn->close();
										?>
									</select>
								</div>

							</div>
							<div class="form-group">
								<!-- <label for="startDate" class="col-sm-2 control-label">Fecha inicial</label> -->
								<div class="input-group date" data-provide="datepicker">
									<input name="fechaInicial" type="text" class="form-control" placeholder="Fecha Inicial">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<!-- <label for="endDate" class="col-sm-2 control-label">Fecha final</label> -->
								<div class="input-group date" id=" fechaFin" data-provide="datepicker">
									<input name="fechaFinal" id="fecha_final" type="text" class="form-control" placeholder="Fecha final"  >
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
								</div>
							</div>
							<div class="row d-flex align-items-end">
								<div class=" col-sm-2 " style="margin-right: 50px;">
									<button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> PDF</button>
								</div>
								<div class="col-sm-2" style="margin-right: 50px;">
									<button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> EXCEL</button>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>

				<!-- modal para ingresar un producto nuevo -->



				






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
}; ?>