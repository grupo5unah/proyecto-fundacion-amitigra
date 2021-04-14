<?php include("./modelo/conexionbd.php");

$id_objeto = 7;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_eliminacion, permiso_actualizacion, permiso_insercion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){

?>
<div class="content-wrapper">
	
	<section class="content-header">
      <h1>Senderos</h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		<li><a><i class="fa fa-cogs"></i> Senderos</a></li>
      </ol>
      <br>
    </section>

	<section class="content">
 
		<!-- Default box -->
		<div class="box">			
			<div class="box-body">
				<!--LLamar al formulario aqui-->
				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Historial de Boletos Vendidos para Senderos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
                <?php if($columna["permiso_insercion"] == 1):?>
                    <!--label for="">Nueva Venta de Boleto(s):</label><br>
                      <select class="form-control" name="opciones" onchange="url(this.value);">
                        <option value="" disabled selected>Selecione Tipo de Nacionalidad</option>
                        <option value="senderosN">NACIONAL</option>
                        <option value="senderosE">EXTRANJERO</option>                        
                      </select>
                      <script language="javascript">
                        function url(uri) {
                        location.href = uri;  }
                      </script-->
					  <button type="button" class=" btn btn-success btnCrearBoleteria text-uppercase"><i class="glyphicon glyphicon-plus-sign"> Nueva Venta de Boletos </i></button>
                      <?php
                      else:
                      endif;
                      ?>
									<!--a href="senderosN" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Venta de Boletos Nacionales </i></a--><br><br>
                  <!--a href="senderosE" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Venta de Boletos Extranjeros </i></a-->
								</div> <!-- /div-action -->
                <!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
                 porque tambien se aplica a todos los mantenimientos --> 
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="mantSenderos">
									<thead>
                    <tr>
                            <th>Numero<br>Factura:</th>
                            <th>Tipo de Boleto:</th> 
                            <th>Cantidad Boletos<br>Vendidos:</th>
                            <th>Subtotal</th>
                            <th>Observacion:</th> 
                            <th>Vendido Por:</th>                                                       
                            <th>Fecha Vendido:</th>
                            <th>Vendido en la<br>Localidad de:</th>
                            <?php if($columna["permiso_eliminacion"] == 0):
											
                            else:?>
                            <th>Acciones</th>
                            <?php
                            endif;
                            ?>
                      </tr>
									</thead>
									<tbody>
                  
										<?php //Mando a llamar los datos que se ocupan para llenar la tabla obteniendo los datos de la  base de datos
										try{
                          $sql = "SELECT id_boletos_detalle, cantidad_boletos, sub_total, tbl_usuarios.nombre_usuario, tbl_tipo_boletos.nombre_tipo_boleto, tbl_tipo_boletos.descripcion, tbl_tipo_boletos.precio_venta, tbl_boletos.id_boletos_vendidos,  tbl_boletos.total_cobrado, tbl_boletos.fecha_creacion, tbl_localidad.nombre_localidad 
                                  FROM tbl_boletos_detalle
                                  INNER JOIN tbl_usuarios
                                  ON tbl_boletos_detalle.usuario_id=tbl_usuarios.id_usuario
                                  INNER JOIN tbl_tipo_boletos
                                  ON tbl_boletos_detalle.tipo_boleto_id=tbl_tipo_boletos.id_tipo_boleto
                                  INNER JOIN tbl_boletos
                                  ON tbl_boletos_detalle.boletos_vendidos_id=tbl_boletos.id_boletos_vendidos
                                  INNER JOIN tbl_localidad
                                  ON tbl_boletos_detalle.localidad_id=tbl_localidad.id_localidad
                                  WHERE tbl_boletos.estado_eliminado = 1                                
                                  ORDER BY tbl_boletos.id_boletos_vendidos";
                      $resultado = $conn->query($sql);
                    }catch (Exception $e){
                      $error = $e->getMessage();
                      echo $error;
                    }
                    //esta variable es para realizar un arreglo que permita mostrar los resultados en la modal
										$ver = array();
										while($mostrar = $resultado->fetch_assoc()){
											$captura = $mostrar['cantidad_boletos'];
											$mostrar = array(
												'nombre_tipo_boleto'=>$mostrar['nombre_tipo_boleto'],
												'cantidad_boletos'=>$mostrar['cantidad_boletos'],
												'sub_total'=>$mostrar['sub_total'],
												'precio_venta'=>$mostrar['precio_venta'],
												'total_cobrado'=>$mostrar['total_cobrado'],
												'descripcion'=>$mostrar['descripcion'],
												'nombre_usuario'=>$mostrar['nombre_usuario'],
												'fecha_creacion' =>$mostrar['fecha_creacion'],
												'nombre_localidad' =>$mostrar['nombre_localidad'],
												'id_boletos_vendidos' =>$mostrar['id_boletos_vendidos'],
												'id_boletos_detalle' =>$mostrar['id_boletos_detalle']
												
											);
											$ver[$captura][] =  $mostrar;
										} 
										foreach ($ver as $reserva => $lista) { ?>
										
											<?php foreach ($lista as $mostrar) { ?>
												<tr>
													<td><?php echo $mostrar['id_boletos_vendidos'];?></td>
													<td><?php echo $mostrar['nombre_tipo_boleto'];?></td>
													<td><?php echo $mostrar['cantidad_boletos'];?></td>
													<td><?php echo $mostrar['sub_total'];?></td>
													<td><?php echo $mostrar['descripcion'];?></td>
													<td><?php echo $mostrar['nombre_usuario'];?></td>                          
													<td><?php echo $mostrar['fecha_creacion'];?></td>
													<td><?php echo $mostrar['nombre_localidad'];?></td>
													
													<td>
								
													 <!--button class="btn btn-warning btnEditarBoleto glyphicon glyphicon-pencil"  data-idboleto="<?= $mostrar['id_boletos_vendidos'] ?>" data-cantidad="<?= $mostrar['cantidad_boletos'] ?>"
                              data-sub_total="<?= $mostrar['sub_total']?>" data-fecha_modificada="<?= $mostrar['fecha_cracion'] ?>"></button-->
                              <?php if($columna['permiso_eliminacion'] == 1):?>
                              <button class="btn btn-danger btnEliminarBoleto glyphicon glyphicon-remove" data-idboletovendido="<?= $mostrar['id_boletos_vendidos'] ?>"></button>
                              <?php
                              else:
                              endif;
                              ?>
							  <button  style="color:white" class="btn btn-success align-item btnVerdDetalle fas fa-eye" data-idbolvendido="<?= $mostrar['id_boletos_vendidos'] ?>" data-usuario="<?= $mostrar['nombre_usuario'] ?>" 
							  data-localidad="<?= $mostrar['nombre_localidad'] ?>" data-fecha="<?= $mostrar['fecha_creacion'] ?>" data-desc="<?= $mostrar['descripcion'] ?>"  data-total="<?= $mostrar['total_cobrado'] ?>"></button>
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
			<!-- /.box-footer-->
			<!-- MODAL DETALLE BOLETO -->
      <div class="modal fade" id="modalDetalleB" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true"  data-backdrop="static">
						<div class="modal-dialog modal-dialog-scrollable" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title" id="exampleModalScrollableTitle">FUNDACION AMITIGRA</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">

									<div class="cont row" id="cont">
									</div>
									<table class="table">
										<thead>
											<tr>												
												<th scope="col">Cantidad</th>
												<th scope="col">Descripcion</th>
												<th scope="col">Precio</th>
												<th scope="col">Subtotal</th>
											</tr>
											
										</thead>
										<tbody id="listaDeBoletosTabla">										

										</tbody>
										
									</table>								
									
								</div>
								<div id="total">
											
									</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
									<button type="button" class="btn btn-default"><i class="fas fa-print"></i>Imprimir</button>
								</div>
							</div>
						</div>
					</div>

		</div>
		<!-- /.box -->

		<!-- MODAL NUEVA BOLETERIA -->
		<div class="modal fade" id="modalNuevaBoleteria" tabindex="-1"  data-backdrop="static" data-keyboard="false"
				role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content modal-reserva">
						<div class="modal-header">
							<div class="d-flex justify-content-between">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true">&times;</i>
								</button>
								<h3 class="modal-title" id="exampleModalLabel">Registrar Boletos</h3>
							</div>
						</div>
						<div class="modal-body">
						 	<form method="POST" id="formBoleteria" onpaste="return false" >
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
										<li><a></a></li>               
										<li><a></a></li>
									</u>
									<div class="tab-content" >
										<div class="active tab-pane" id="activity">
											<div class="post"><br>
												
												<div class="box-body" >
													
													<div class="box-body">
														<div class="row clientes" id="regitroBoletos">
															
																<div class="col-md-6">																	
																	<div class="form-group">
																		<label for="">localidad</label><br>
																		<select class="form-control" name="localidad" id="localidad">
																			<option value="" disabled selected>Seleccione...</option>
																			<?php 
																			require ('./modelo/conexionbd.php');
																			$stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
																			$resultado = mysqli_query($conn,$stmt);
																			?>
																			<?php foreach($resultado as $opciones):?>
																			<option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
																			<?php endforeach;?>
																		</select>      																		      
																	</div>																	
																	<!-- radio -->
																</div>
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Tipo Boleto:</label><br>
																		<select type="text" class="form-control" id="lista1" name="lista1">
																		<option value="" disabled selected>Seleccione...</option>
																		<?php
																			require ('./modelo/conexionbd.php');
																		$stmt = "SELECT id_tipo_boleto, nombre_tipo_boleto FROM tbl_tipo_boletos WHERE estado_eliminado = 1";
																		$resultado = mysqli_query($conn,$stmt);
																		?>
																		<?php foreach($resultado as $opciones):?>
																		<option value="<?php echo $opciones['id_tipo_boleto']?>"><?php echo $opciones['nombre_tipo_boleto']?></option>
																		<?php endforeach;?>
																		</select>																																				
																	</div>
																</div>
																<div class="col-md-6">                  
																	<div class="campos form-group">
																		<label for="CantBoletos">Cantidad de Personas:</label>
																		<input type="number" min="1" class="form-control" name="CantBoleto" id="CantBoleto" oninput="sumarBoletosN();" placeholder="Cantidad Personas Adultas" 
																		value="">
																	</div>
																</div>	
																<div class="col-md-6">																
																	<div class="campos form-group">
																		<label for="precioN">Precio de Boleto:</label>
																		<div class="input-group col-xs-8">																																		
																			<input type="text" class="form-control" id="miprecio" disabled="true" placeholder="Cantidad Personas Adultas" value=""> 
																		</div>
																	</div>
																</div>
																
																<div class="col-md-6">
																<div id="guardarCliente">
																
																</div>
																
															</div>
																
																<input type="hidden" name="totalPB" id="totalPB" value="">
																<div>
																<button id="btnAgregarS" class="btn btn-success btnAgregarS addnacional glyphicon glyphicon-plus-sign">Agregar</button>
																</div><br><br>
														</div><!-- row -->
														<!-- <div id="listaBoletos"></div> -->
															<table id="tableBoletos" data-page-length='10' class=" table table-hover table-condensed table-bordered">
																<thead>
																	<tr>
																		<td class="text-center tableBoletos">Cantidad</td>
																		<td class="text-center tableBoletos">Descripcion</td>
																		<td class="text-center tableBoletos">Precio</td>
																		<td class="text-center tableBoletos">Sub-Total</td>
																		<td class="text-center tableBoletos">Localidad</td>
																		<!-- <td class="text-center tableBoletos">Acciones</td> -->
																	</tr>
																</thead>																
																<tbody>
																</tbody>
																<tfoot>
																	<tr class="total">
																		<th>Total Vendidos:</th>
																		<th></th>
																		<th></th>
																		<th>Total a Pagar:</th>
																	</tr>
																</tfoot>
															</table>
															<input type="text" id="totalPagar" disabled="true"></input>
															<div class="col-md-6">
															<input type="text" id="resultado_total" disabled="true"></input>
															</div>
													</div><!-- box-body -->
												</div><!-- box-body principal -->
												<div class="modal-footer">
												<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id']; ?>">
													<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $_SESSION['usuario']; ?>">
													<button type="button"  id="cerrarboletos"class="btn btn-secondary" data-dismiss="modal">Cerrar </button>	
													<button type="button" id="registroBoletos" class="btn btn-primary" data-toggle="tab">REGISTRAR BOLETOS</button>
												</div>
											</div> <!-- /.post -->	
										</div> <!-- /.tab-pane -->	
									</div> <!-- /.tab-content -->	
								</div> <!-- /.tabs-custom -->	
							</form> <!-- /.cierre de formulario -->
						</div> <!-- /.modal-body -->
						<?php 
						if(isset($_GET['msg'])){
						$mensaje = $_GET['msg'];
						print_r($mensaje);
						//echo "<script>alert(".$mensaje.");</script>";  
						}
						?>
					</div> <!-- /.modal content -->
				</div> <!-- /.modal-dialog -->
			</div> <!-- /.modal fade -->

	</section>
	<!-- /.content -->
</div>

<?php

  }else{
  echo "<script type='text/javascript'>
  window.location.href='index.php';
  </script>";}
  }?>