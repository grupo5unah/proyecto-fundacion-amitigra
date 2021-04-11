<?php include("./modelo/conexionbd.php");

$id_objeto = 16;
$rol = $_SESSION["rol"];
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta, permiso_eliminacion FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">

    <section class="content-header">
      <h1>Bitácora <small> Acciones realizadas</small></h1>      
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a href="panel"><i class="fa fa-cogs"></i> Panel de control</a></li>
        <li class="active"><i class="fa fa-user"></i> Bitácora</li>
      </ol>
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Lista de acciones realizadas</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">

								</div> <!-- /div-action -->

								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="managerBitacora">
									<thead>
										<tr>

											<th>Acción</th>
											<th>Descripción</th>
                      						<th>Fecha acción</th>
                      						<th>Usuario</th>
											<th>Objeto</th>
											<th>Acciones</th>

										</tr>
									</thead>
									<tbody>
										<?php
										try {


											$sql = "SELECT id_bitacora, accion, descripcion_bitacora, fecha_accion, tbl_usuarios.nombre_usuario AS usuario, tbl_objeto.objeto AS objeto
													FROM tbl_bitacora
													INNER JOIN tbl_usuarios 
													ON tbl_bitacora.usuario_id = tbl_usuarios.id_usuario
													INNER JOIN tbl_objeto
													ON tbl_bitacora.objeto_id = tbl_objeto.id_objeto;";
											$resultado = $conn->query($sql);
										} catch (\Exception $e) {
											echo $e->getMessage();
										}

										$vertbl = array();
										while ($eventos = $resultado->fetch_assoc()) {

											$traer = $eventos["id_bitacora"];
											$evento = array(
												'accion' => $eventos['accion'],
												'descripcion' => $eventos['descripcion_bitacora'],
												'fecha_accion' => $eventos['fecha_accion'],
												'usuario' => $eventos['usuario'],
                        						'objeto' => $eventos['objeto'],
                        						// 'id_bitacora' => $eventos['id_bitacora']

											);
											$vertbl[$traer][] =  $evento;
										}
										foreach ($vertbl as $dia => $lista_articulo) { ?>


											<?php foreach ($lista_articulo as $evento) { ?>
												<?php	//echo $evento['nombre_arti']
												?>
												<tr>
													<td> <?php echo $evento['accion']; ?></td>
													<td> <?php echo $evento['descripcion']; ?></td>
                          							<td> <?php echo $evento['fecha_accion']; ?></td>
                        							<td> <?php echo $evento['usuario']; ?></td>
													<td> <?php echo $evento['objeto']; ?></td>
													<td>

														<?php if($columna['permiso_eliminacion'] == 1):?>
														<button class="btn btn-danger btnEliminarObjeto glyphicon glyphicon-remove" data-idobjeto="<?php //echo $evento['id_bitacora'];?>"></button>
														<?php
														else:
														endif;?>
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
	</section>
	<!-- /.content -->
</div>
<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>