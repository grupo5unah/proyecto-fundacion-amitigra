<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          

        </div>
        <div class="box-body">
          <!--LLamar al formulario aqui-->
          <form action="" method="post">
          <?php
              include_once('./controlador/ctr.senderosN.php');
              $sendero= new ControladorSenderosN();
              $sendero->ctrSenderosN();
            ?>
            <h1 class="tamano">SENDEROS</h1>
            <br> <h3 class="alineo-texto">VISITAS NACIONALES</h3>
            <fieldset>
              <legend class="contenido-sendero">ADULTO(S)</legend>
              
              <div class="contenido-sendero">
                <br><label for="boletosN">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosN" name="boletosN" oninput="sumarBoletosN()" value="0" onclick="quitar(this.id)">                             
              </div>
              <div class="contenido-sendero">
                <br><label for="precioN">Precio Lempiras:</label>
                <input class="alinear_input" type="number" id="precioN" name="precioN" value="50" disabled="true"required >               
              </div>
                <br>
            </fieldset>                       
            <fieldset>
            <legend class="contenido-sendero">NIÑO(S)</legend>
                        
              <div class="contenido-sendero">
                <br><label for="boletosNN">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosNN" name="boletosNN" oninput="sumarBoletosN()" value="0" onclick="quitar(this.id)">                
              </div>
              <div class="contenido-sendero">
                <br><label for="precioNN">Precio Lempiras:</label>
                <input class="alinear_input alinear-text-input" type="number" id="precioNN" name="precioNN" value="30" disabled="true" required>              
              </div>          
              <br>
              <br>    
            </fieldset>
            <fieldset class="alineo-texto contenido-sendero">                            
              <label for="TboletosN">Total de Boletos Nacionales:</label>
              <input class="alinear_input" type="text" id="TboletosN" name="TboletosN" disabled="true">                              
            </fieldset> 
            <fieldset class="alineo-texto contenido-sendero">                            
              <label for="Tpagar">   Total a Pagar en Lempiras:</label>
              <input class="alinear_input" type="text" id="Tpagar" name="Tpagar" disabled="true">        
            </fieldset>
            <div class="contenido-sendero">            
            <br><button type="submit" id="generarB" name="tipo_generar" value="generarB" class="formulario__btn boton">Generar Boleto(s)</button><br>
            <br><button type="button" id="cancelar" name="cancelar" value="cancelar" onclick="location='senderos'" class="formulario__btn boton">Cancelar</button><br>
            </div>
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
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>