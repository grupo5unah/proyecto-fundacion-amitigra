
<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-bed"> HOTEL</h3>
        </div>
        <div class="box-body"> 
            <!-- <div class="col-xs-3">

              <button type="submit" id="buscar" class="btn btn-default btnbuscarCliente glyphicon glyphicon-search"> Buscar Cliente</button><br><br>
              <button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
            </div><br> -->
          <form  id="hotel" method="post">
              <div class="box-header with-border">
                <h3 class="box-title">Datos Cliente</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Identidad:</label>
                      <input type="text" class="form-control" name="identidad" id="identidad" placeholder="Identidad" onkeydown="return soloNumeros(event)" required>
                    </div>
                    <div class="form-group">
                      <label for="">Nacionalidad: </label>
                      <select class="form-control" name="nacionalidad" id="nacionalidad">
                        <option value="" disabled selected>Selecione...</option>
                        <?php 
                        include ('./modelo/conexionbd.php');

                        $stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
                        $resultado = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
                        <?php endforeach;?>
                      </select>
										</div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Cliente:</label>
                      <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="campos form-group">
                      <label for="">Telefeno: </label>
                      <input id="telefono" maxlength="15"  name="telefono" class="form-control" type="tex"  placeholder="Telefono" onkeydown="return soloNumeros(event)"  required />
                    </div>
                  </div>
                </div><!-- row -->
              </div><!-- box-body -->

              <div class="box-header with-border">
                <h3 class="box-title">Datos reservación</h3>
              </div>
              <div class="box-body">
                <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">localidad</label><br>
                      <select class="form-control" name="localidad" id="localidad">
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                        //include_once ('./modelo/conexionbd.php');

                        $stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
                        $resultado = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>   
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Fecha Reservación:</label>
                      <div class="input-group ">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="reservacion" name="reservacion" requiered>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Fecha Entrada:</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="entrada" name="entrada" requiered>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Fecha Salida:</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="salida" name="salida" requiered>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Habitación:</label><br>
                      <select class="form-control" name="habitacion" id="habitacion">
                        <option value="" disabled selected>Selecione...</option>
                        <?php 
                          //include_once ('./modelo/conexionbd.php');

                          $stmt = "SELECT id_habitacion_servicio, habitacion_area,estado_id FROM tbl_habitacion_servicio
                                    WHERE habitacion_area LIKE '%h%'";
                          $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado as $opciones):?>
                          <option value="<?php echo $opciones['id_habitacion_servicio']?> <?php echo $opciones['estado_id']?>"><?php echo $opciones['habitacion_area']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">

                      <label for="cant_habi">Cantidad de Habitaciones:</label><br>
                      <input type="text" class="form-control" name="cant_habitacion" id="cant_habitacion" placeholder="cantidad habitaciones"
                      onkeydown="return soloNumeros(event)" value="<?php if(isset($_POST['cant_habitacion'])){echo $_POST['cant_habitacion'];} ?>" requiered >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Cantidad Adultos:</label><br>
                      <input type="number" min="0"  class="form-control" name="personas" id="personas" placeholder="Cantidad de Adultos" oninput="calcular()"
                      onkeydown="return soloNumeros(event)" value="<?php if(isset($_POST['personas'])){echo $_POST['personas'];} ?>"  requiered>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">

                      <label>Precio Adulto:</label>
                      <input type="text" class="form-control" name="precioAdulto" id="precioAdulto" placeholder="Precio habitacion" oninput="calcular()" onkeydown="return soloNumeros(event)"
                      maxlength="4"  requiered >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Cantidad Niños:</label><br>
                      <input type="number" min="0"  class="form-control" name="niños" id="niños" placeholder="Cantidad de Niños" oninput="calcular()"
                      onkeydown="return soloNumeros(event)"  requiered>
                    </div>
                  </div>
                   
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>Precio Niños:</label>
                      <input type="text" class="form-control" name="precioNiños" id="precioNiños" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Precio habitacion"
                      maxlength="4" requiered >
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="pago" class="col-sm-2 control-label" >Total:</label>
                <div class="col-sm-10">
                  <input type="Text" class="form-control" id="pago" name="pago" placeholder="Total" disabled>
                </div>
              </div>
            </div>
            <br><br><br>
            <div class="text-center"">
              <div class="col-md-6">

                <button type="button" name="" id="cancelar" class="text-center btn btn-danger btn-lg">Cancelar</button>

              </div>
              <div class="col-md-4">
              
              <!-- <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>"> -->
                <button type="submit"  class=" text-center btn btn-success btn-lg ">Registrar</button>
              </div>
            </div><br><br><br><br>
            <?php $conn->close(); ?>
          </form>
          
        </div>
        <?php 
            if(isset($_GET['msg'])){
            $mensaje = $_GET['msg'];
            print_r($mensaje);
            //echo "<script>alert(".$mensaje.");</script>";  
            }

        ?>
          <!-- MODAL CREAR CLIENTE -->
        <div class="modal fade" id="modalCrearCliente" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Registrar Nuevo Cliente</h3>
									</div>
								</div>
								<div class="modal-body">
									<form id="formCliente">
										<div class="form-group">
											
											<div class="campos">
												<label for="">Identidad Cliente: </label>

												<input id="ideCliente" maxlength="13" minlength="13" class="form-control modal-roles secundary" type="text" name="idecliente" placeholder="Identidad Cliente" onkeypress="return soloNumeros(event)" required />

											</div>
											<div class="campos form-group">
												<label for="">Nombre Cliente: </label>

												<input id="nCliente" name="nCliente" class="form-control  modal-roles secundary" type="tex"  placeholder="Nombre Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);" required />


											</div>
											<div class="campos form-group">
												<label for="">Nacionalidad: </label>
                        <select class="form-control modal-roles secundary " name="nacionalidad" id="nacionalidad">
                          <option value="" disabled selected>Selecione...</option>
                          <?php 
                          include ('./modelo/conexionbd.php');

                          $stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
                          $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado as $opciones):?>
                          <option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
                          <?php endforeach;?>
                        </select>
											</div>
                      <div class="campos form-group">
												<label for="">Telefeno: </label>

												<input id="tel" maxlength="15" minlength="8"name="tel" class="form-control  modal-roles secundary" type="tex"  placeholder="Telefono" onkeypress="return soloNumeros(event)"  required />


											</div>
                      <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Cerrar</button>
										<button id=""type="submit" class=" btn btn-primary">Registrar  Cliente</button>
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
				</div>

        <!-- MODAL PARA BUSCAR CLIENTE 
        <div class="modal fade" id="modalBuscarCliente" tabindex="-1"
					role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<div class="d-flex justify-content-between">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i aria-hidden="true">&times;</i>
										</button>
										<h3 class="modal-title" id="exampleModalLabel">Buscar Cliente</h3>
									</div>
								</div>
								<div class="modal-body">
									<form id="formBuscarCliente">
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Identidad Cliente: </label>

												<input id="identidadC" class="form-control modal-roles secundary" type="text" name="identidadC" placeholder="Ingrese el numero de identidad" onkeypress="return soloNumeros(event)" required />

											</div>
											<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
										</div>
										<div class="modal-footer">
										<button type="button" class="btn btn-secondary"     data-dismiss="modal">Cerrar</button>
										<button id=""type="submit" class=" btn btn-primary">Buscar  Cliente</button>
										</div>
									</form> 
								</div>
								
							</div>
						</div>
					</div>
				</div>-->
        
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>