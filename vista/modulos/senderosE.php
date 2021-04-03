<?php include("./modelo/conexionbd.php");

$id_objeto = 8;

$rol_id = $_SESSION['idRol'];

$stmt = $conn->query("SELECT permiso_consulta FROM tbl_permisos
WHERE rol_id = '$rol_id' AND objeto_id = '$id_objeto';");
$columna = $stmt->fetch_assoc();


if($_SESSION["rol"] === "asistente" || $_SESSION["rol"] === "colaborador" || $_SESSION["rol"] === "administrador" ){
  if($columna["permiso_consulta"] === 1){

?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title fa fa-tree"> SENDEROS</h3>
        </div>
        <div class="box-body">             
          <form  id="senderoE" method="post" onpaste="return false">         
            <h4 class="alineo-texto">VISITAS EXTRANJERAS</h4>      

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
                  </div><br>
                  <div class="box-header with-border">
                    <h1 class="box-title">ADULTO(S)</h1>
                  </div>                
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="boletosE">Cantidad de Adultos:</label><br>
                      <input type="number" min="1" class="form-control" name="boletosE" id="boletosE" oninput="sumarBoletosE()" placeholder="Cantidad Personas Adultas" onclick="quitar(this.id)"
                     value="<?php if(isset($_POST['boletosE'])){echo $_POST['boletosE'];} ?>" >
                    </div>
                  </div>
                  
                   <div class="col-md-6">
                      <div class="form-group">
                        <label for="precioE">Precio Adulto Dolares:</label>
                        <div class="input-group col-xs-8">
                          <span class="input-group-addon">$</span>
                          <input type="number" class="form-control" name="precioE" id="precioE" placeholder="Precio Adulto" disabled="true"
                          <?php
                          $stmt = "SELECT id_tipo_boleto, precio_venta FROM tbl_tipo_boletos WHERE id_tipo_boleto=3";
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
                      <label for="boletosNE">Cantidad de Niños:</label><br>
                      <input type="number" min="1" class="form-control" name="boletosNE" id="boletosNE" oninput="sumarBoletosE()" placeholder="Cantidad Personas Infantiles" onclick="quitar(this.id)"
                      value="<?php if(isset($_POST['boletosNE'])){echo $_POST['boletosNE'];} ?>" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="precioNE">Precio Niños Dolares:</label>
                      <div class="input-group col-xs-8">
                      <span class="input-group-addon">$</span>
                      <input type="number" class="form-control" name="precioNE" id="precioNE" placeholder="Precio Niños" disabled="true"
                        <?php
                        $stmt = "SELECT id_tipo_boleto, precio_venta FROM tbl_tipo_boletos WHERE id_tipo_boleto=4";
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
                <label for="TpagarE" class="col-sm-2 control-label" >Total a Pagar en Dolares:</label>
                <div class="col-sm-10">
                  <div class="input-group col-xs-8">
                      <span class="input-group-addon">$</span>
                      <input type="Text" class="form-control" id="TpagarE" name="TpagarE" placeholder="Total a Pagar" disabled="true">
                  </div>   
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="TboletosE" class="col-sm-2 control-label" >Total Boletos Vendidos:</label>
                <div class="input-group col-xs-8">
                  <input type="Text" class="form-control" id="TboletosE" name="TboletosE" placeholder="Total Boletos Vendidos" disabled="true">
                </div>
              </div>
            </div>
            <br><br><br>
            <div class="text-center">
              <div class="col-md-6">
                <button type="button" name="" id="cancelar" onclick="location='senderos'" class="text-center btn btn-danger btn-lg">Cancelar</button>
              </div>              
              <div class="col-md-4">
                <input type="hidden"  name="usuario_actual" id="usuario_actual" value="<?= $usuario ?>">   
                <input type="hidden"  name="id_usuario" id="id_usuario" value="<?= $_SESSION['id'] ?>">         
                <button type="submit" name="registrarsendero" id="registrar" class=" text-center btn btn-success btn-lg ">Generar Boleto(s)</button>
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
              function sumarBoletosE()
              {
                try {
                  var a=parseFloat(document.getElementById("boletosE").value)|| 0, 
                      b=parseFloat(document.getElementById("boletosNE").value)|| 0,
                      c=parseFloat(document.getElementById("precioE").value)|| 0,
                      d=parseFloat(document.getElementById("precioNE").value)|| 0;
                      document.getElementById("TboletosE").value= a+b;                 
                      //console.log(document.getElementById("TboletosE").value);
                      document.getElementById("TpagarE").value= a*c+b*d;
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
  }
?>