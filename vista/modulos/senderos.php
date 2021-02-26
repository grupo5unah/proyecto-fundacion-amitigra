<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Historial de Boletos Vendidos para Senderos</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="senderosN" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Venta de Boletos Nacionales </i></a><br><br>
                  <a href="senderosE" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Venta de Boletos Extranjeros </i></a>
								</div> <!-- /div-action -->
                <!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
                 porque tambien se aplica a todos los mantenimientos --> 
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="tablas">
									<thead>
                    <tr>
                            <th>Id Factura</th>
                            <th>Cantidad Boletos Vendidos</th>
                            <th>Subtotal</th>
                            <th>Tipo de Nacionalidad</th>
                            <th>Tipo de Boleto</th>
                            <th>Fecha Vendido</th>
                            <th>Acciones</th>
                      </tr>
									</thead>
									<tbody>
                  
										<?php //Mando a llamar los datos que se ocupan para llenar la tabla obteniendo los datos de la  base de datos
										try{
                          $sql = "SELECT cantidad_boletos, sub_total, tbl_tipo_nacionalidad.nacionalidad, tbl_tipo_boletos.nombre_tipo_boleto, tbl_boletos.id_boletos_vendidos, tbl_boletos.fecha_creacion";  
                          $sql .= " FROM tbl_boletos_detalle ";
                          $sql .= " INNER JOIN tbl_tipo_nacionalidad ";
                          $sql .= " ON tbl_boletos_detalle.tipo_nacionalidad_id=tbl_tipo_nacionalidad.id_tipo_nacionalidad ";
                          $sql .= " INNER JOIN tbl_tipo_boletos ";
                          $sql .= " ON tbl_boletos_detalle.tipo_boleto_id=tbl_tipo_boletos.id_tipo_boleto ";
                          $sql .= " INNER JOIN tbl_boletos ";
                          $sql .= " ON tbl_boletos_detalle.boletos_vendidos_id=tbl_boletos.id_boletos_vendidos ";
                          $sql .= " ORDER BY tbl_boletos.id_boletos_vendidos";
                      $resultado = $conn->query($sql);
                    }catch (Exeption $e){
                      $error = $e->getMessage();
                      echo $error;
                    }

										while($mostrar = $resultado->fetch_assoc()){ ?>
                      <tr>
                          <td><?php echo $mostrar['id_boletos_vendidos'];?></td>
                          <td><?php echo $mostrar['cantidad_boletos'];?></td>
                          <td><?php echo $mostrar['sub_total'];?></td>
                          <td><?php echo $mostrar['nacionalidad'];?></td>
                          <td><?php echo $mostrar['nombre_tipo_boleto'];?></td>
                          <td><?php echo $mostrar['fecha_creacion'];?></td>

                        <td>                          
                          <!--button class="btn btn-warning btnEditarBoleto glyphicon glyphicon-pencil"  data-idboleto="<?= $mostrar['id_boletos_vendidos'] ?>" data-cantidad="<?= $mostrar['cantidad_boletos'] ?>"
                              data-sub_total="<?= $mostrar['sub_total']?>" data-fecha_modificada="<?= $mostrar['fecha_cracion'] ?>"></button-->

                          <button class="btn btn-danger btnEliminarBoleto glyphicon glyphicon-remove" data-idboletodetalle="<?= $mostrar['id_boletos_detalle'] ?>"data-idboletoVendido="<?= $mostrar['id_boletos_vendidos'] ?>" data-cantidad="<?= $mostrar['cantidad_boletos'] ?>"
                              data-subtotal="<?= $mostrar['sub_total'] ?>" data-nacionalidad="<?= $mostrar['nacionalidad'] ?>" data-nombretipoboleto="<?= $mostrar['nombre_tipo_boleto'] ?>"
                              data-fecha="<?= $mostrar['fecha_cracion'] ?>"></button>
                        </td>                  
                      </tr>
                    <?php } ?>
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