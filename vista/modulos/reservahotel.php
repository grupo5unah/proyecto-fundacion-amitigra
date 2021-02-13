
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-bed"> HOTEL</h3>
        </div>
        <div class="box-body"> 
            <div class="col-xs-3">
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" id="identi" name="identi" onkeypress="return soloNumeros(event)" placeholder="Identidad">
                    <span class="input-group-btn">
                      <button type="submit" id="submitBuscar"class="btn btn-default btnbuscarCliente">Buscar Cliente</button>
                    </span>
              </div><br>
              <button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
            </div><br>
          <form  id="hotel" method="post">
            
            <!--<<input type="text">!-->
            <!-- <div class="box box-default"> -->
              <!-- <div class="box-header with-border"> 
                <h3 class="box-title">Datos Reservación</h3>-->
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Cliente:</label>
                      <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente">
                    </div>
                    <div class="form-group">
                      <label>Nombre Cliente:</label>
                      <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre Cliente" value="<?php
                      if(isset($_POST['nombre'])){echo $_POST['nombre'];} ?>">
                    </div>
                    <div class="form-group">
                      <label>Nacionalidad:</label>
                      <select class="form-control" name="nacionalidad" id="nacionalidad">
                        <option value="" disabled selected>Selecione...</option>
                        <?php 
                        include_once ('./modelo/conexionbd.php');

                        $stmt = "SELECT id_tipo_nacionalidad, nacionalidad FROM tbl_tipo_nacionalidad";
                        $resultado = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_tipo_nacionalidad']?>"><?php echo $opciones['nacionalidad']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Identidad:</label>
                      <input type="text" class="form-control" name="identidad" id="identidad" placeholder="Identidad" value="<?php if(isset($_POST['identidad']))
                      {echo $_POST['identidad'];} ?>">
                    </div>
                    <div class="form-group">
                      <label>Telefono:</label>
                      <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono"
                            value="<?php if(isset($_POST['telefono'])){echo $_POST['telefono'];} ?>">
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <div class="box box-default">
              <div class="box-header with-border">
                <h3 class="box-title">Datos Reservación</h3>
              </div>
              <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">localidad</label><br>
                    <select class="form-control" name="localidad" id="localidad">
                      <option value="" disabled selected>Selecione...</option>
                      <?php 
                      include_once ('./modelo/conexion.php');

                      $stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
                      $resultado = mysqli_query($conn,$stmt);
                      ?>
                      <?php foreach($resultado as $opciones):?>
                      <option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
                      <?php endforeach;?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Cantidad de Adultos:</label><br>
                      <input type="text" class="form-control" name="personas" id="personas"  placeholder="cantidad personas"
                     value="<?php if(isset($_POST['personas'])){echo $_POST['personas'];} ?>" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Cantidad de Niños:</label><br>
                      <input type="text" class="form-control" name="niños" id="niños"  placeholder="cantidad personas"
                     value="<?php if(isset($_POST['personas'])){echo $_POST['personas'];} ?>" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cant_habi">Cantidad de Habitaciones:</label><br>
                      <input type="text" class="form-control" name="cant_habitacion" id="cant_habitacion" placeholder="cantidad habitaciones"
                      value="<?php if(isset($_POST['cant_habitacion'])){echo $_POST['cant_habitacion'];} ?>" >
                    </div>
                  </div>
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>Precio Adulto:</label>
                      <input type="text" class="form-control" name="precioAdulto" id="precioAdulto" oninput="calcular()" placeholder="Precio habitacion"
                      value="<?php if(isset($_POST['precioAdulto'])){echo $_POST[' precioAdulto'];} ?>" >
                    </div>
                    <input type="date" class="form-control pull-right" id="entrada" name="entrada">
                  </div>
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>Precio Niños:</label>
                      <input type="text" class="form-control" name="precioNiños" id="precioNiños" oninput="calcular()"  placeholder="Precio habitacion"
                      value="<?php if(isset($_POST['precioNiños'])){echo $_POST['precioNiños'];} ?>" >
                    </div>
                    <input type="date" class="form-control pull-right" id="salida" name="salida">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="pago" class="col-sm-2 control-label" >Total:</label>
                <div class="col-sm-10">
                  <input type="Text" class="form-control" id="pago" name="pago" disabled="true" placeholder="Total">
                </div>
              </div>
            </div><br>
            <div class="form-group">
              <label for="pago" class="col-xs-3 control-label">Total a Pagar:</label>
              <div class="col-xs-4">
                <input type="Text" class="form-control" id="pago" name="pago" placeholder="Total">
              </div>
            </div><br><br>
            <div class="text-center"">
              <div class="col-md-6">
                <button type="button" name="" id="cancelar" class="text-center btn btn-danger btn-lg" onclick="location='hotel'">Cancelar</button>
              </div>
              <input type="hidden"  name="agregar-hotel" value="1">
              <button type="submit" name="submit" id="registrar" class=" text-center btn btn-success btn-lg ">Registrar</button>
            </div><br><br>
           <!-- <?php 
              /*include_once('./controlador/ctr.hotel.php');
              $hotel = new ControladorHotel();
              $hotel->ctrHotel();*/
            ?>!-->
          </form>
        </div>
        <?php 
            if(isset($_GET['msg'])){
            $mensaje = $_GET['msg'];
            print_r($mensaje);
            //echo "<script>alert(".$mensaje.");</script>";  
            }

          ?>}
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
										<div class="ingreso-producto form-group">
											
											<div class="campos">
												<label for="">Identidad Cliente: </label>
												<input id="ideCliente" class="form-control modal-roles secundary" type="text" name="idecliente" onkeypress="return soloNumeros(event)"  placeholder="Identidad Cliente" required />

											</div>
											<div class="campos form-group">
												<label for="">Nombre Cliente: </label>
												<input id="nCliente" name="nCliente" class="form-control  modal-roles secundary" type="tex" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);"  placeholder="Nombre Cliente" required />

											</div>
											<div class="campos form-group">
												<label for="">Nacionalidad: </label>
                        <select class="form-control modal-roles secundary " name="nacionalidad" id="nacionalidad">
                          <option value="" disabled selected>Selecione...</option>
                          <?php 
                          include_once ('./modelo/conexionbd.php');

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
												<input id="tel" name="tel" class="form-control  modal-roles secundary" type="tex" onkeypress="return soloNumeros(event)"  placeholder="Telefono" required />

											</div>
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
        
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

