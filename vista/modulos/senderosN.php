<?php include("./modelo/conexionbd.php");

$id_objeto = 9;
$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_eliminacion, permiso_actualizacion, permiso_insercion, permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] == 1){
?>
<div class="content-wrapper">
    
    <section class="content-header">
      <h1>Senderos <small>nacionales</small></h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
		    <li><a href="senderos"><i class="fa fa-cogs"></i> Senderos</a></li>
        <li><a><i class="fa fa-cogs"></i> Senderos nacionales</a></li>
      </ol>
      <br>
    </section>
    
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-tree"> SENDEROS</h3>
        </div>
        <div class="box-body">             
          <form  id="senderoN" method="post" onpaste="return false">         
            <h4 class="alineo-texto">VISITAS NACIONALES</h4>            
            
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">localidad</label><br>
                      <select class="form-control" name="localidad" id="localidad">
                        <option value="" disabled selected>Selecione...</option>
                        <?php 
                        
                        $stmt = "SELECT id_localidad, nombre_localidad FROM tbl_localidad";
                        $resultado = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado as $opciones):?>
                        <option value="<?php echo $opciones['id_localidad']?>"><?php echo $opciones['nombre_localidad']?></option>
                        <?php endforeach;?>
                      </select>                      
                    </div>
                  </div>
                </div> <br>
                  <div class="box-header with-border">
                    <h1 class="box-title">ADULTO(S)</h1>
                  </div>  
                  <div class="col-md-6">                  
                    <div class="form-group">
                      <label for="boletosN">Cantidad de Adultos:</label><br>
                      <input type="number" min="1" class="form-control" name="boletosN" id="boletosN" oninput="sumarBoletosN()" placeholder="Cantidad Personas Adultas" onclick="quitar(this.id)"
                     value="<?php if(isset($_POST['boletosN'])){echo $_POST['boletosN'];} ?>">
                    </div>
                  </div>
                  
                   <div class="col-md-6">
                      <div class="form-group">
                        <label for="precioN">Precio Adulto:</label><br>
                        <div class="input-group col-xs-8">
                          <span class="input-group-addon">L.</span>
                          <input type="number" class="form-control" name="precioN" id="precioN" placeholder="Precio Adulto" disabled="true"
                          <?php
                          $stmt = "SELECT id_tipo_boleto, precio_venta FROM tbl_tipo_boletos WHERE id_tipo_boleto=1";
                          $resultado1 = mysqli_query($conn,$stmt);
                          ?>
                          <?php foreach($resultado1 as $opcion):?>
                          value="<?php echo $opcion['precio_venta']?>"> 
                          <?php endforeach;?>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="box-header with-border">
                      <h1 class="box-title">NIÑO(S)</h1>
                    </div>
                  <div class="col-md-6">                                      
                    <div class="form-group">
                      <label for="boletosNN">Cantidad de Niños:</label><br>
                      <input type="number" min="1" class="form-control" name="boletosNN" id="boletosNN" oninput="sumarBoletosN()" placeholder="Cantidad Personas Infantiles" onclick="quitar(this.id)"
                      value="<?php if(isset($_POST['boletosNN'])){echo $_POST['boletosNN'];} ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="precioNN">Precio Niños:</label><br>
                      <div class="input-group col-xs-8">
                      <span class="input-group-addon">L.</span>
                      <input type="number" class="form-control" name="precioNN" id="precioNN" placeholder="Precio Niños" disabled="true"
                        <?php
                        $stmt = "SELECT id_tipo_boleto, precio_venta FROM tbl_tipo_boletos WHERE id_tipo_boleto=2";
                        $resultado1 = mysqli_query($conn,$stmt);
                        ?>
                        <?php foreach($resultado1 as $opcion):?>
                        value="<?php echo $opcion['precio_venta']?>"> 
                        <?php endforeach;?>
                    </div>
                  </div>
                </div>
              </div><br><br>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="Tpagar" class="col-sm-2 control-label" >Total a Pagar en Lempiras:</label>
                <div class="col-sm-10">
                  <div class="input-group col-xs-8">
                      <span class="input-group-addon">L.</span>
                      <input type="Text" class="form-control" id="Tpagar" name="Tpagar" placeholder="Total a Pagar" disabled="true">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="TboletosN" class="col-sm-2 control-label" >Total Boletos Vendidos:</label>
                <div class=" input-group col-xs-8">
                  <input type="Text" class="form-control" id="TboletosN" name="TboletosN" placeholder="Total Boletos Vendidos" disabled="true">
                </div>
              </div>
            </div>
            <br><br><br>
            <div class="text-center">
              <div class="col-md-6">
                <button type="button" name="" id="cancelarS"  class="text-center btn btn-danger btn-lg">Cancelar</button>
              </div>              
              <div class="col-md-4">
                <input type="hidden"  name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">   
                <input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">
                <?php if($columna['permiso_insercion'] == 1):?>
                <button type="submit" name="registrarsendero" id="registrar" class=" text-center btn btn-success btn-lg ">Generar Boleto(s)</button>
                <?php
                else:
                endif;
                ?>
              </div>
             
            </div><br><br><br><br>
           
          </form>
          
            <script type="text/javascript">  
              function quitar(id){          
                if (document.getElementById(id).value=="0"){
                  document.getElementById(id).value="";
                }          
              }       
            </script>      
            <script type="text/javascript">        
              function sumarBoletosN()
              {
                try {
                  var a=parseFloat(document.getElementById("boletosN").value)|| 0, 
                      b=parseFloat(document.getElementById("boletosNN").value)|| 0,
                      c=parseFloat(document.getElementById("precioN").value)|| 0,
                      d=parseFloat(document.getElementById("precioNN").value)|| 0;
                      document.getElementById("TboletosN").value= a+b;                 
                      //console.log(document.getElementById("TboletosN").value);
                      document.getElementById("Tpagar").value= a*c+b*d;
                }catch(e){}
              }          
            </script>       
        </div>
        
        <?php 
            if(isset($_GET['msg'])){
            $mensaje = $_GET['msg'];
            print_r($mensaje);
            //echo "<script>alert(".$mensaje.");</script>";  
            }

          ?>    

        
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