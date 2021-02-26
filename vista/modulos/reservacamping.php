
<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-tree"> CAMPING</h3>
        </div>
        <div class="box-body">
            <!-- <div class="col-xs-3">
              <button type="submit" id="buscar" class="btn btn-default btnbuscarCliente glyphicon glyphicon-search"> Buscar Cliente</button><br><br>  
              <button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
            </div><br> -->
          <form  id="camping" method="post">
              <div class="box-header with-border">
                <h3 class="box-title">Datos Cliente</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Identidad:</label>
                      <input type="text" class="form-control" name="identidad" id="identidad" maxlength="13" placeholder="Identidad" onkeydown="return soloNumeros(event)" required>
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

                        $stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad
                        WHERE nombre_localidad LIKE '%ju%'";
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
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="date" class="form-control pull-right" id="reservacion" name="reservacion">
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
                        <input type="date" class="form-control pull-right" id="entrada" name="entrada">
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
                        <input type="date" class="form-control pull-right" id="salida" name="salida">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Area Camping:</label><br>
                      <select class="form-control" name="area" id="area">
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                          //include_once ('./modelo/conexionbd.php');

                          $stmt = "SELECT id_habitacion_servicio, habitacion_area FROM tbl_habitacion_servicio
                          WHERE habitacion_area LIKE '%ar%'";
                          $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado as $opciones):?>
                          <option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Cantidad de Adultos:</label><br>
                      <input type="number" min="0"  class="form-control" name="personas" id="personas" placeholder="cantidad personas"
                      oninput="calcular_camping()">
                    </div>
                  </div>
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>Precio Adulto:</label>
                      <input type="text" class="form-control" name="precioAdulto" id="precioAdulto" placeholder="Precio Adulto"
                      maxlength="4" minlength="2" onkeydown="return soloNumeros(event)" oninput="calcular_camping()" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area">Cantidad de Niños:</label><br>
                      <input type="number" min="0"  class="form-control" name="ninos" id="ninos" placeholder="cantidad personas"
                      oninput="calcular_camping()" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Precio Niños:</label>
                      <input type="text" class="form-control" name="precioNiños" id="precioNiños" placeholder="Precio Niño"
                      maxlength="4"  onkeydown="return soloNumeros(event)" oninput="calcular_camping()" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-header with-border">
                <h3 class="box-title">Accesorios para acampar</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Tipo de Tiendas:</label><br>
                      <select class="form-control" name="tipoT" id="tipoT">
                        <option value="" disabled selected>Selecione...</option>
                        <?php
                          //include_once ('./modelo/conexionbd.php');

                          $stmt = "SELECT id_inventario, nombre_articulo FROM tbl_inventario
                          WHERE nombre_articulo LIKE '%Ti%'";
                          $resultado = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado as $opciones):?>
                          <option value="<?php echo $opciones['id_inventario']?>"><?php echo $opciones['nombre_articulo']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Cantidad de Tiendas:</label><br>
                        <input type="number" min="0"  class="form-control" name="cant_tienda" id="cant_tienda" placeholder="Cantidad Tiendas"
                        oninput="calcular_camping()" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Precio de Tienda:</label>
                        <input type="text" class="form-control" name="precioTienda" id="precioTienda" placeholder="Precio tienda"
                        maxlength="4" onkeydown="return soloNumeros(event)" oninput="calcular_camping()" >
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="">Sleeping Bag:</label><br>
                      <select class="form-control" name="sleeping" id="sleeping">
                      <option value="" disabled selected>Selecione...</option>
                      <?php
                        //include_once ('./modelo/conexionbd.php');

                        $stmt = "SELECT id_inventario, nombre_articulo FROM tbl_inventario
                        WHERE nombre_articulo LIKE '%Sl%'";
                        $resultado = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_inventario']?>"><?php echo $opciones['nombre_articulo']?></option>
                      <?php endforeach;?>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                        <label for="cant_habi">Cantidad de Sleeping Bag:</label><br>
                        <input type="number" min="0"  class="form-control" name="cant_sleeping" id="cant_sleeping" placeholder="Cantidad Sleeping Bag"
                        oninput="calcular_camping()">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Precio de Sleeping Bag:</label>
                      <input type="numeric" class="form-control" name="precioSleeping" id="precioSleeping" placeholder="Precio Sleeping Bag"
                      maxlength="4" onkeydown="return soloNumeros(event)" oninput="calcular_camping()" >
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
              <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
                <button type="submit" name="registrarhotel" id="registrar" class=" text-center btn btn-success btn-lg ">Registrar</button>
              </div>
            </div><br><br><br><br>
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
            // //echo "<script>alert(".$mensaje.");</script>";
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
										<div class="ingreso-producto form-group">

											<div class="campos">
												<label for="">Identidad Cliente: </label>
												<input id="ideCliente"  maxlength="13"  class="form-control modal-roles secundary" type="text" name="idecliente" placeholder="Identidad Cliente" onkeypress="return soloNumeros(event)" required />

											</div>
											<div class="campos form-group">
												<label for="">Nombre Cliente: </label>
												<input id="nCliente"  maxlength="50" name="nCliente" class="form-control  modal-roles secundary" type="tex"  placeholder="Nombre Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);" required />

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
												<input id="tel" name="tel" maxlength="15" minlength="8" class="form-control  modal-roles secundary" type="tex"  placeholder="Telefono" onkeydown="return soloNumeros(event)"required />

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

