<?php include("./modelo/conexionbd.php");

$id_objeto = 13;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_insercion, permiso_actualizacion, permiso_eliminacion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "administrador" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "asistente"){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">
	<section class="content-header">
  	<h1>
	PRODUCTOS
  	</h1>      
 	<ol class="breadcrumb ">
        <li class="btn btn-success uppercase fw-bold"><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="btn btn-success uppercase fw-bold" ><a href="panel"><i class="  fa fa-user-plus"></i> Panel de control</a></li>
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

								<?php if($columna["permiso_insercion"] == 0):
									
								else:?>
									<a href="producto" class="btn btn-default button1" id="addProductModalBtn"> <i class="glyphicon glyphicon-plus-sign"></i> Agregar producto </a>
								<?php
								endif;
								?>

								</div> 

							<table data-page-length='10' class=" display data-results table table-striped table-hover table-bordered ui celled table" style="width:100%;"  id="managerInventario">
								<thead>
									<tr>
										<th style="background-color:#f0ff33" COLSPAN=2>INVENTARIO GENERAL</th>
										<th style="background-color:#33ffc1" COLSPAN=2>ENTRADA</th>
										<th style="background-color:#ffb533" COLSPAN=3>SALIDA</th>
									</tr>
									<tr>
										<th>Nombre del producto</th>
										<th>Existencias</th>
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

											$sql = "SELECT tbl_inventario.id_inventario, tbl_producto.nombre_producto, tbl_inventario.existencias, tbl_inventario.fecha_entrada from tbl_inventario INNER JOIN tbl_producto on tbl_inventario.producto_id= tbl_producto.id_producto  WHERE estado_eliminar=1";
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
												'fecha_art' => $eventos['fecha_entrada'],
												'id_inventario' => $eventos['id_inventario'],

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<tr>
													<td> <?php echo $evento['nombre_arti'];?></td>
													<td><?php echo $evento['existencia'];?></td>
													<td> <?php echo $evento['fecha_art']; ?></td>
													<td> <?php echo $evento['nombre_arti'];?></td>
													<td><?php echo $evento['existencia'];?></td>
													<td> <?php echo $evento['fecha_art']; ?></td>
													<td> <?php echo $evento['fecha_art']; ?></td>
												<?php  } ?>
												</tr> 
										<?php  } ?>
												
									</tbody> 
								</table>
								

							</div> 
						</div> 
					</div>
					<?php $conn->close(); ?>
				</div> <!-- /row -->


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