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
								<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Listado de Reservaciones Hotel</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="div-action pull pull-right" style="padding-bottom:20px;">
									<a href="reservahotel" class=" btn btn-default glyphicon glyphicon-plus-sign"> Nueva Reservación </i></a>
								</div> <!-- /div-action -->
                <!-- esto es para que el usuario pueda elegir cuantos registros desea ver, se dejo ese id porque se tomaria como global
                 porque tambien se aplica a todos los mantenimientos -->
								<table data-page-length='10' class=" display table table-hover table-condensed table-bordered" id="tablas">
									<thead>
										<tr>
                    <th>Cliente</th>
                    <th>Fecha reservacion</th>
                    <th>Fecha entrada</th>
                    <th>Fecha salida</th>
                    <th>accion</th>
										</tr>
									</thead>
									<tbody>
										<?php
										try{
                      $sql = "SELECT id_reservacion, fecha_reservacion, fecha_entrada,fecha_salida,tbl_clientes.nombre_completo ";  
                      $sql .= " FROM tbl_reservaciones ";
                      $sql .= " INNER JOIN tbl_clientes ";
                      $sql .= " ON tbl_reservaciones.cliente_id=tbl_clientes.id_cliente ";
                      $sql .= " ORDER BY id_reservacion ";
                      $resultado = $conn->query($sql);
                    }catch (Exeption $e){
                      $error = $e->getMessage();
                      echo $error;
                    }

										while($mostrar = $resultado->fetch_assoc()){ ?>
                      <tr>
                        <td><?php echo $mostrar['nombre_completo'];?></td>
                        <td><?php echo $mostrar['fecha_reservacion'];?></td>
                        <td><?php echo $mostrar['fecha_entrada'];?></td>
                        <td><?php echo $mostrar['fecha_salida'];?></td>
                        <td>
                          
						<button class="btn btn-warning btnEditarHotel glyphicon glyphicon-pencil"  data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
								 data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>"></button>

						<button class="btn btn-danger btnEliminarHotel glyphicon glyphicon-remove" data-idreservacion="<?= $mostrar['id_reservacion'] ?>" data-reservacion="<?= $mostrar['fecha_reservacion'] ?>"
								data-nombre="<?= $mostrar['nombre_completo'] ?>" data-entrada="<?= $mostrar['fecha_entrada'] ?>" data-salida="<?= $mostrar['fecha_salida'] ?>"></button>
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
			<!-- MODAL EDITAR RESERVACION HOTEL -->
			<div class="modal fade" id="modalEditarHotel" tabindex="-1"
				 role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<div class="d-flex justify-content-between">
				                	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
									</button>
									<h3 class="modal-title" id="exampleModalLabel">Registrar reservaión</h3>
								</div>
							</div>
							<div class="modal-body">
							<form method="POST" id="formHotel">
                              <div class="ingreso-producto form-group">
                               <div class="campos" type="hidden">
                               <label for=""> </label>
                               <!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
                            </div>

                          <div class="campos">
                          <label for="">Fecha de reservación </label>
                          <input id="fReservacion" class="form-control modal-roles secundary" type="date" name="fReservacion" required />
                          </div>
						  <div class="campos">
                          <label for="">Fecha de entrada  </label>
                          <input id="fEntrada" class="form-control modal-roles secundary" type="date" name="fEntrada"required />
                          </div>
						  <div class="campos">
                          <label for="">Fecha de salida  </label>
                          <input id="fSalida" class="form-control modal-roles secundary" type="date" name="fSalida"required />
                          </div>
                                
                          <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          </div>
						  </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
								<button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button>
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