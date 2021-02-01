
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-bed"> HOTEL</h3>
        </div>
        <div class="box-body"> 
        <!-- el action solo lo puse para hacer unas pruebas -->
          <form action="controlador/ctr.hotel.php" id="hotel" name="hotel" method="post">
                <div class="box box-default">
                  <div class="box-header with-border">
                    <h3 class="box-title">Datos del Cliente</h3>
                  </div>
                  <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Fecha Reservación:</label>
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
                  <label>Fecha Entrada:</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control pull-right" id="entrada" name="entrada">
                  </div>
                </div>
                <div class="form-group">
                  <label for="area">Cantidad de Peronas:</label><br>
                  <input type="text" class="form-control" name="personas" id="personas" placeholder="cantidad personas"
                        value="<?php if(isset($_POST['cant_personas'])){echo $_POST['personas'];} ?>" >
                </div>
                <div class="form-group">
                  <label for="cant_habi">Cantidad de Habitaciones:</label><br>
                  <input type="text" class="form-control" name="cant_habi" id="cant_habi" placeholder="cantidad habitaciones"
                        value="<?php if(isset($_POST['cant_habitacion'])){echo $_POST['cant_habi'];} ?>" >
                </div>
                <!-- /.col -->
                
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
                <div class="form-group">
                  <label for="area">Habitación:</label><br>
                  <select class="form-control" name="habitacion" id="habitacion">
                    <option value="" disabled selected>Selecione...</option>
                    <?php 
                      include_once ('./modelo/conexion.php');

                      $stmt = "SELECT id_hab_ser, hab_area FROM tbl_habitacion_servicio";
                      $resultado = mysqli_query($conn,$stmt);
                      ?>
                      <?php foreach($resultado as $opciones):?>
                      <option value="<?php echo $opciones['id_hab_ser']?>"><?php echo $opciones['hab_area']?></option>
                    <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Precio Habitacion:</label>
                  <input type="text" class="form-control" name="precio" id="precio" placeholder="Precio habitacion"
                        value="<?php if(isset($_POST['precio'])){echo $_POST['precio'];} ?>" >
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
                <button type="button" name="submit_cancelar" id="cancelar" class="text-center btn btn-danger btn-lg">Cancelar</button>
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
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

