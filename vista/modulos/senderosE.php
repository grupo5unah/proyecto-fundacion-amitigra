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
              include_once('./controlador/ctr.senderosE.php');
              $sendero= new ControladorSenderosE();
              $sendero->ctrSenderosE();
            ?>
            <h1 class="tamano">SENDEROS</h1>
            <br> <h3 class="alineo-texto">VISITAS EXTRANJEROS</h3>
            <fieldse>
              <legend class="contenido-sendero">ADULTO(S)</legend>
                        
              <div class="contenido-sendero">               
                <br><label for="boletosE">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosE" name="boletosE"oninput="sumarBoletosB()" value="0" onclick="quitar(this.id)">
              </div>
              <div class="contenido-sendero">               
                <br><label for="precioE">Precio Dolares:</label>
                <input class="alinear_input" type="number" id="precioE" name="precioE" value="10" disabled="true"required>
              </div>
                <br>
            </fieldset>                       
            <fieldset>
            <legend class="contenido-sendero">NIÑO(S)</legend>                     
              <div class="contenido-sendero">                
                <br><label for="boletosNE">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosNE" name="boletosNE" oninput="sumarBoletosB()" value="0" onclick="quitar(this.id)">
              </div>
              <div class="contenido-sendero">               
                <br><label for="precioNE">Precio Dolares:</label>
                <input class="alinear_input alinear-text-input" type="number" id="precioNE" name="precioNE" value="5" disabled="true" required>
              </div><br>
              <div class="alinear-tasa">
              <label for="Tasacambio">Tasa de Cambio de Dolar:</label>
              <input type="text" id="Tasacambio" name="Tasacambio" oninput="sumarBoletosB()"  required>  
              </div> 
              <br>
            </fieldset>
            <fieldset class="alineo-texto contenido-sendero">   
              <label for="TboletosE">Total de Boletos Extranjeros:</label>
              <input class="alinear_input" type="text" id="TboletosE" name="TboletosE" disabled="true">                         
            </fieldset> 
            <br>
            <fieldset class="alineo-texto contenido-sendero">                            
              <label for="Tpagar">Total a Pagar en Lempiras:</label>
              <input class="alinear_input" type="text" id="Tpagar" name="Tpagar" disabled="true">        
            </fieldset>
            <div class="contenido-sendero">            
            <br><button type="submit" id="generarB" name="tipo_generar" value="generarB" class="formulario__btn boton">Generar Boleto(s)</button><br>
            <br><button type="submit" id="cancelar" name="cancelar" value="cancelar" onclick="location='senderos'" class="formulario__btn boton">Cancelar</button><br>
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
          function sumarBoletosB()
          {
            try {
              var e=parseFloat(document.getElementById("boletosE").value)|| 0, 
                  f=parseFloat(document.getElementById("boletosNE").value)|| 0,
                  g=parseFloat(document.getElementById("precioE").value)|| 0,
                  h=parseFloat(document.getElementById("precioNE").value)|| 0,
                  i=parseFloat(document.getElementById("Tasacambio").value)|| 0;
                  document.getElementById("TboletosE").value= e+f;
                  //console.log(document.getElementById("TboletosE").value);                 
                  document.getElementById("Tpagar").value= (e*g*i)+(f*h*i);
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