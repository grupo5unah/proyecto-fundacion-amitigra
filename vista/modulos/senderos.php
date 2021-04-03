<?php include("./modelo/conexionbd.php");

$id_objeto = 7;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){

?>
<div class="content-wrapper">
	
	<section class="content-header">
      <h1>Senderos</h1> <?php echo $rol_id;?> <br> <?php echo $_SESSION["rol"];?>
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
                    <label for="">Nueva Venta de Boleto(s):</label><br>
                      <select class="form-control" name="opciones" onchange="url(this.value);">
                        <option value="" disabled selected>Selecione Tipo de Nacionalidad</option>
                        <option value="senderosN">NACIONAL</option>
                        <option value="senderosE">EXTRANJERO</option>                        
                      </select>
                      <script language="javascript">
                        function url(uri) {
                        location.href = uri;  }
                      </script>
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
                            <th>Acciones</th>
                      </tr>
									</thead>
									<tbody>
                  
										<?php //Mando a llamar los datos que se ocupan para llenar la tabla obteniendo los datos de la  base de datos
										try{
                          $sql = "SELECT id_boletos_detalle, cantidad_boletos, sub_total, tbl_usuarios.nombre_usuario, tbl_tipo_boletos.nombre_tipo_boleto, tbl_tipo_boletos.descripcion, tbl_boletos.id_boletos_vendidos, tbl_boletos.fecha_creacion, tbl_localidad.nombre_localidad 
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

                              <button class="btn btn-danger btnEliminarBoleto glyphicon glyphicon-remove" data-idboletovendido="<?= $mostrar['id_boletos_vendidos'] ?>"></button>
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
			<!-- MODAL EDITAR VENTA BOLETO -->
			<div class="modal fade" id="modalEditarBoleto" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
				                	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Editar Cantidad de Boletos</h3>
								</div>
							</div>
							<div class="modal-body">
							<form method="POST" id="formSendero">
                              <div class="ingreso-producto form-group">
                               <div class="campos" type="hidden">
                               <label for=""> </label>
                               <!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
                            </div>

                          <div class="campos">
                          <label for="">Cantidad de boletos</label>
                          <input id="CantBoletos" class="form-control modal-roles secundary" type="date" name="CantBoletos" required />
                          </div>
						  <div class="campos">
                          <label for="">Sub-Total </label>
                          <input id="SubTotal" class="form-control modal-roles secundary" type="date" name="SubTotal"required />
                          </div>
						  <div class="campos">
                          <label for="">Fecha Modificada  </label>
                          <input id="fmodificada" class="form-control modal-roles secundary" type="date" name="fmodificada"required />
                          </div>
                                
                          <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          </div>
						  </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
								<button id=""type="submit" class="btn btn-primary btnEditarBD">Actualizar Boletos</button>
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