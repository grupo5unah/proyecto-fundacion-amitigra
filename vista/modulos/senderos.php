<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Senderos</h3>

        </div>
        <div class="box-body">
          <!--LLamar al formulario aqui-->
          <form action="" method="post">
            <?php
              include_once('./controlador/ctr.senderos.php');
              $sendero= new ControladorSenderos();
              $sendero->ctrSenderos();
            ?>
            <h1 class="tamano">SENDEROS</h1>
            <fieldse>
              <legend class="contenido-sendero">ADULTO(S)</legend>
              <div class="contenido-sendero">
                <br><label for="nacionalidadN">NACIONALES:</label><br>
                <label for="nacionalidadE">EXTRANJEROS:</label><br>            
              </div>            
              <div class="contenido-sendero">
                <label for="boletosN">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosN" name="boletosN" oninput="sumarBoletosN()" value="0" onclick="quitar(this.id)">
                
                <label for="boletosE">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosE" name="boletosE"oninput="sumarBoletosN()" value="0" onKeyUp="habilitarInput()" onclick="quitar(this.id)">
              </div>
              <div class="contenido-sendero">
                <label for="precioN">Precio Lempiras:</label>
                <input class="alinear_input" type="number" id="precioN" name="precioN" value="50" disabled="true"required >
                <label for="precioE">Precio Dolares:</label>
                <input class="alinear_input" type="number" id="precioE" name="precioE" value="10" disabled="true"required>
              </div>
                <br>
            </fieldset>                       
            <fieldset>
            <legend class="contenido-sendero">NIÑO(S)</legend>
              <div class="contenido-sendero">
                <br><label for="nacionalidadN">NACIONALES:</label><br>  
                <label for="nacionalidadE">EXTRANJEROS:</label><br>            
              </div>            
              <div class="contenido-sendero">
                <label for="boletosNN">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosNN" name="boletosNN" oninput="sumarBoletosN()" value="0" onclick="quitar(this.id)">
                <label for="boletosNE">Cantidad Boletos:</label>
                <input class="alinear_input" type="number" min="0" id="boletosNE" name="boletosNE" oninput="sumarBoletosN()" value="0" onKeyUp="habilitarInput()" onclick="quitar(this.id)">
              </div>
              <div class="contenido-sendero">
                <label for="precioNN">Precio Lempiras:</label>
                <input class="alinear_input alinear-text-input" type="number" id="precioNN" name="precioNN" value="30" disabled="true" required>
                <label for="precioNE">Precio Dolares:</label>
                <input class="alinear_input alinear-text-input" type="number" id="precioNE" name="precioNE" value="5" disabled="true" required>
              </div>
              <div class="alinear-tasa">
              <label for="Tasacambio">Tasa de Cambio de Dolar:</label>
              <input type="text" id="Tasacambio" name="Tasacambio" disabled="" oninput="sumarBoletosN()"  required>  
              </div> 
            </fieldset>
            <fieldset class="contenido-sendero">                            
              <label for="TboletosN">Total de Boletos Nacionales:</label>
              <input class="alinear_input" type="text" id="TboletosN" name="TboletosN" disabled="true"><br><br>
              <label for="TboletosE">Total de Boletos Extranjeros:</label>
              <input class="alinear_input" type="text" id="TboletosE" name="TboletosE" disabled="true">                         
            </fieldset> 
            <fieldset class="alineo-texto">                            
              <label for="Tpagar">Total a Pagar en Lempiras:</label>
              <input class="alinear_input" type="text" id="Tpagar" name="Tpagar" disabled="true">        
            </fieldset>
            <div class="contenido-sendero">            
            <br><button type="submit" id="generarB" name="tipo_generar" value="generarB" class="formulario__btn boton">Generar Boleto(s)</button><br>
            <br><button type="submit" id="cancelar" name="cancelar" class="formulario__btn boton">Cancelar</button><br>
            </div>
          </form>
        </div>          
        <script type="text/javascript">          
          function habilitarInput(){
            document.getElementById('Tasacambio').disabled=false;
          }
         
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
                  d=parseFloat(document.getElementById("precioNN").value)|| 0,
                  e=parseFloat(document.getElementById("boletosE").value)|| 0, 
                  f=parseFloat(document.getElementById("boletosNE").value)|| 0,
                  g=parseFloat(document.getElementById("precioE").value)|| 0,
                  h=parseFloat(document.getElementById("precioNE").value)|| 0,
                  i=parseFloat(document.getElementById("Tasacambio").value)|| 0;
                  document.getElementById("TboletosE").value= e+f;
                  //console.log(document.getElementById("TboletosE").value);
                  document.getElementById("TboletosN").value= a+b;                 
                  //console.log(document.getElementById("TboletosN").value);
                  document.getElementById("Tpagar").value= a*c+b*d+(e*g*i)+(f*h*i);
            }catch(e){}
          }
         
        </script>       
       
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