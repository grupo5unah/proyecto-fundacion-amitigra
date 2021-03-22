
<?php include("./modelo/conexionbd.php"); ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title glyphicon glyphicon-tent"> CAMPING</h3>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
              <h3 class="box-title">Datos Cliente</h3>
            </div> 
            <div class="col-xs-3">

              <!-- <button type="submit" id="buscar" class="btn btn-default btnbuscarCliente glyphicon glyphicon-search"> Buscar Cliente</button><br><br>-->
              <button class="btn btn-default btnCrearCliente glyphicon glyphicon-plus-sign" >Agregar Nuevo Cliente</button>
            </div><br> 
          <form  id="regitroClientes" method="post" class="datos" onpaste="return false" autocomplete="off">
              <input type="hidden" name="action" value="agregarCliente">
              <input type="hidden" id="idCliente" name="idCliente" value="" required>
              <div class="box-header with-border">
                <!-- <h3 class="box-title">Datos Cliente</h3> -->
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Identidad:</label>
                      <input type="text" class="form-control" name="identidad" id="identidad" placeholder="Identidad" onkeydown="return soloNumeros(event)" required
                      maxlength = "13"> 
                    </div>
                    <div class="form-group">
                      <label for="">Nacionalidad: </label>
                      <select class="form-control" name="nacionalidad" id="nacionalidad" disabled required>
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
                      <input type="text" class="form-control" name="cliente" id="cliente" placeholder="Cliente" onkeypress="return soloLetras(event)" onkeyup="javascript:this.value=this.value.toUpperCase(); espacioLetras(this);"
                      disabled required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="campos form-group">
                      <label for="">Telefeno: </label>
                      <input id="telefono" maxlength="15"  name="telefono" class="form-control" type="tex"  placeholder="Telefono" onkeydown="return soloNumeros(event)" disabled required>
                    </div>
                  </div>
                  <div class="col-md-6">
                  <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
									<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                  <div id="guardarCliente">
                    <button type="submit" class="btnGuardarCliente" ><i class="glyphicon glyphicon-floppy-save"></i> Guardar Cliente</button>
                  </div>
                  </div>
                </div><!-- row -->
              </div><!-- box-body -->
            
          </form>
        </div>
        <div class="box-body">
            <div class="box-header with-border">
              <h2 class="box-title">Datos de Reservación</h2>
            </div> 
            <div class="col-md-6">
              <div class="form-group">
                <label for="">localidad</label><br>
                <select class="form-control selectLocalidad" name="localidad" id="localidad">
                  <option value="" disabled selected>Selecione...</option>
                  <?php
                  require ('./modelo/conexionbd.php');

                  $stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad
                  WHERE nombre_localidad LIKE '%JU%'";
                  $resultado = mysqli_query($conn,$stmt);
                  ?>
                  <?php foreach($resultado as $opciones):?>
                  <option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
                  <?php endforeach;?>
                </select>
              </div>
            </div>
        </div>
        <!-- MODAL REGISTRAR RESERVACION PARA JUTIAPA -->
        <div class="modal fade" id="modalRegistrarCamping" tabindex="-1"
          role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                <form method="POST" id="formCamping" onpaste="return false">
                  <input type="hidden" id="idCli" name="idCli value="" required>
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li><a></a></li>               
                      <li><a></a></li>
                      <li><a></a></li>
                    </u>
                    <div class="tab-content">
                      <div class="active tab-pane" id="activity2">
                        <div class="post"><br>
                          
                          <div class="ingreso-producto form-group">
                            <div class="campos" type="hidden">
                              <label for=""> </label>
                              <!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
                            </div>
                            
                            <div class="campos">
                            <label for="">Fecha de reservación </label>
                              <input id="reservacion" class="form-control modal-roles secundary" type="datetime" name="reservacion" required
                              <?php
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha=date('Y-m-d H:i:s',time());
                              ?> value="<?php echo $fecha;?>" disabled="true">
                            </div>
                            <div class="campos">
                              <label for="">Fecha de entrada  </label>
                              <input id="entrada" class="form-control modal-roles secundary" type="text" name="entrada"required />
                            </div>
                            <div class="campos">
                              <label for="">Fecha de salida  </label>
                              <input id="salida" class="form-control modal-roles secundary" type="text" name="salida"required />
                            </div>
                            <div class="campos">
                              <label for="area">Habitación:</label><br>
                              <select class="form-control modal-roles secundary" name="area" id="area">
                                <option value="" disabled selected>Selecione...</option>
                                <?php 
                                  //include_once ('./modelo/conexionbd.php');

                                  $stmt = "SELECT id_habitacion_servicio, habitacion_area, estado_id FROM tbl_habitacion_servicio
                                            WHERE habitacion_area LIKE '%ar%' AND localidad_id = 1 AND estado_id = 4";
                                  $resultado = mysqli_query($conn,$stmt);
                                  ?>
                                  <?php foreach($resultado as $opciones):?>
                                  <option value="<?php echo $opciones['id_habitacion_servicio']?>"><?php echo $opciones['habitacion_area']?></option>
                                <?php endforeach;?>
                              </select>
                            </div>
                              
                          </div> <!-- /.modal form-group -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar </button>
                            <button class="btn btn-primary" href="#timeline" data-toggle="tab">Siguiente</button>
                          </div>
                          
                          
                        </div> <!-- /.post -->	
                      </div> <!-- /.tab-pane -->
                      <div class="tab-pane" id="timeline">
                        <div class="post"> <br>
                          <div class="ingreso-producto form-group">
                            <div class="form-group">
                              <div class=" col-sm-8">
                                <div class="checkbox">
                                  <label>
                                    <input type="checkbox" id="checke" name="checke">Registrar extranjeros
                                  </label>
                                </div>
                              </div>
                            </div><br>
                            <div class="campos form-group">
                              <div class=" col-md-10">
                                <div class="input-group">
                                  <label for="">Cantidad Areas:  
                                  <div class="input-group col-xs-10">
                                    <input id="cantA" class="form-control modal-roles secundary"  type="number" min="0" name="cantA" onkeypress="return soloNumeros(event)" placeholder="N° habitaciones" />
                                  </div>
                                </div>
                              </div>
                            </div><br><br>
                            <div class="campos" type="hidden">
                              <label for=""> </label>
                              <!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
                            </div>
                              <!-- <input type="hide"> -->
                              <div class="col-md-7">
                                <div class="campos form-group">
                                    <label>Precio Adulto (N):</label>
                                  <div class="input-group col-xs-8">
                                    <span class="input-group-addon">L.</span>
                                    <input type="text" class="form-control" name="precioAdultoN" id="precioAdultoN" placeholder="Precio habitacion"  onkeydown="return soloNumeros(event)"
                                    maxlength="4"  requiered disabled="true"
                                    <?php
                                      $stmt = "SELECT id_habitacion_servicio, precio_adulto_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
                                      $resultado1 = mysqli_query($conn,$stmt);
                                      ?>
                                      <?php foreach($resultado1 as $opcion):?>
                                      value="<?php echo $opcion['precio_adulto_nacional']?>"> 
                                      <?php endforeach;?>
                                  </div>
                                </div>
                                <div class="campos form-group">
                                  <label>Precio Niño (N):</label>
                                  <div class= "input-group col-xs-8">
                                    <span class="input-group-addon">L.</span>
                                    <input type="text" class="form-control" name="precioNinoN" id="precioNinoN" onkeydown="return soloNumeros(event)"  placeholder="Precio habitacion"
                                    maxlength="4" requiered disabled="true"
                                    <?php
                                      $stmt = "SELECT id_habitacion_servicio, precio_nino_nacional FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
                                      $resultado1 = mysqli_query($conn,$stmt);
                                      ?>
                                      <?php foreach($resultado1 as $opcion):?>
                                      value="<?php echo $opcion['precio_nino_nacional']?>"> 
                                      <?php endforeach;?>
                                  </div>
                                </div>
                              </div>
                              <div class="campos form-group">
                                <label for="">Cantidad Adultos: </label>
                                <div class=" input-group col-xs-4">
                                  <input id="cAdultosN" class="form-control" min="0"  type="number" name="cAdultosN" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Adultos" />
                                </div>
                              </div>
                              <div class="campos form-group">
                                <label for="">Cantidad Niños:  </label>
                                <div class="input-group col-xs-4">
                                  <input id="cNinosN" class="form-control modal-roles secundary" min="0"  type="number" name="cNinosN" onkeypress="return soloNumeros(event)" oninput="calcular()" placeholder="Niños"/>
                                </div>
                              </div>
                            <div class="campos total">
                              <label for="">Total  </label>
                              <input id="total1" class="form-control modal-roles secundary" type="text" name="total1" onkeydown="return soloNumeros(event)" placeholder="Total a pagar"required disabled />
                            </div>
                            
                              
                            <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          </div> <!-- /.modal form-group -->
                          <div class="modal-footer">
                            <button class="btn btn-default" href="#activity2" id="prevtab" data-toggle="tab">Anterior</button>
                            <button id=""type="submit" class="btn btn-primary btnregistrar">Registrar reservación</button>
                            <button class="btn btn-primary btnSiguiente" href="#timeline2" id="prevtab" data-toggle="tab">Siguiente</button>
                          </div>
                          
                        </div> <!-- /.post -->	
                      </div> <!-- /.tab-pane -->
                      <div class="tab-pane" id="timeline2">
                        <div class="post"> <br>
                          <div class="ingreso-producto form-group">
                            <div class="campos" type="hidden">
                              <label for=""> </label>
                              <!-- <input autocomplete="off" class="form-control secundary" type="hidden" name="idProducto" value="0" disabled> -->
                            </div>
                              <!-- <input type="hide"> -->
                              <div class="col-md-7">
                                <div class="campos form-group">
                                      <label>Precio Adulto (E):</label>
                                    <div class="input-group col-xs-8">
                                      <span class="input-group-addon">$.</span>
                                      <input type="text" class="form-control" name="precioAdultoE" id="precioAdultoE" placeholder="Precio habitacion" onkeydown="return soloNumeros(event)"
                                      maxlength="4"  requiered disabled="true"
                                      <?php
                                        $stmt = "SELECT id_habitacion_servicio, precio_adulto_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
                                        $resultado1 = mysqli_query($conn,$stmt);
                                        ?>
                                        <?php foreach($resultado1 as $opcion):?>
                                        value="<?php echo $opcion['precio_adulto_extranjero']?>"> 
                                        <?php endforeach;?>
                                    </div>
                                  </div>
                                  <div class="campos form-group">
                                <label>Precio Niño (E):</label>
                                  <div class= "input-group col-xs-8">
                                    <span class="input-group-addon">$.</span>
                                    <input type="text" class="form-control" name="precioNinoE" id="precioNinoE" onkeydown="return soloNumeros(event)"  placeholder="Precio habitacion"
                                    maxlength="4" disabled="true"
                                    <?php
                                      $stmt = "SELECT id_habitacion_servicio, precio_nino_extranjero FROM tbl_habitacion_servicio WHERE id_habitacion_servicio=14";
                                      $resultado1 = mysqli_query($conn,$stmt);
                                      ?>
                                      <?php foreach($resultado1 as $opcion):?>
                                      value="<?php echo $opcion['precio_nino_extranjero']?>"> 
                                      <?php endforeach;?>
                                  </div>
                                </div>
                              </div>
                              <div class="campos form-group">
                                <label for="">Cantidad Adultos: </label>
                                <div class=" input-group col-xs-4">
                                  <input id="cantAdultosE" class="form-control" min="0" type="number" name="cantAdultosE" onkeydown="return soloNumeros(event)" oninput="calcular()" placeholder="Adultos" />
                                </div>
                              </div>
                              <div class="campos form-group">
                                <label for="">Cantidad Niños:  </label>
                                <div class="input-group col-xs-4">
                                  <input id="cantNinosE" class="form-control modal-roles secundary" min="0" type="number" name="cantNinosE" onkeypress="return soloNumeros(event)" oninput="calcular()"  placeholder="Niños" />
                                </div>
                              </div>
                            <div class="campos">
                              <label for="">Total  </label>
                              <input id="total2" class="form-control modal-roles secundary" type="number" name="total2" onkeydown="return soloNumeros(event)" placeholder="Total a pagar" disabled />
                            </div>
                            
                              
                            <input type="hidden" name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">
                          </div> <!-- /.modal form-group -->
                          <div class="modal-footer">
                            <button class="btn btn-default" href="#timeline" id="prevtab" data-toggle="tab">Anterior</button>
                            <button id=""type="submit" class="btn btn-primary btnEditarBD">Registrar reservación</button>
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
        
      </div>
      <?php $conn->close(); ?>
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>