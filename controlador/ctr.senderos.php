<?php
class ControladorSenderos{

    public function ctrSenderos(){
       
        if(isset($_POST['tipo_generar']) == 'generarB'){
            $boletosN =$_POST['boletosN'];
            $boletosE =$_POST['boletosE'];
            $boletosNN=$_POST['boletosNN'];
            $boletosNE=$_POST['boletosNE'];  
            $usuario=$_SESSION['usuario'];          

            if(($boletosN=="" && $boletosNN=="") || ($boletosN=="0" && $boletosNN=="0")){
            
               echo "<div class='alert alert-danger' role='alert'>
                        Tiene que vender un boleto NACIONAL
                        </div>";                        
            }else{                               
                  
                try{
                    require_once("./modelo/conexion.php");
                    $captura=$conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario=?;");
                    $captura->bind_Param("s", $usuario); 
                    $captura->execute();
                    $captura->bind_result($id);

                    while ($captura->fetch()) {
                        $idusuario = $id;
                    }                  
                        include "./modelo/conexion.php";  
                        $cantidadN=$boletosN+$boletosNN;  
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha=date('Y-m-d H:i:s', time());                   
                        $nacionalidad=1;                       
                        $sql=$conn->prepare("INSERT INTO tbl_boleteria (cant_boletos, nacionalidad_id, id_usuario, creado_por, fecha_creacion,
                                            modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                        $sql->bind_param('iiissss',$cantidadN, $nacionalidad, $idusuario, $usuario, $fecha, $usuario, $fecha);
                        $sql->execute();

                        if($sql->error){
                            echo "Se produjo un error, no se registro en la base de datos";
                        }else{
                            echo "Se registro en la base de datos";
                        }
                        $sql->close();
                        $sql=null;

                        //echo '<script type="text/javascript"> location.href="/saat-proyecto-amitigra/senderos"; </script>';
                                              
                    
                }catch(Exception $e) {
                    die("se produjo un error". $e->getMessage());
                }
            }

            if(($boletosE=="" && $boletosNE=="") || ($boletosE=="0" && $boletosNE=="0")){
            
                echo "<div class='alert alert-danger' role='alert'>
                        O Tiene que vender un boleto EXTRANJERO
                        </div>";                        
             }else{                               
                   
                 try{
                     require_once("./modelo/conexion.php");
                     $captura=$conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario=?;");
                     $captura->bind_Param("s", $usuario); 
                     $captura->execute();
                     $captura->bind_result($id);
 
                     while ($captura->fetch()) {
                         $idusuario = $id;
                     }                  
                         include "./modelo/conexion.php";  
                         $cantidadE=$boletosE+$boletosNE;  
                         date_default_timezone_set("America/Tegucigalpa"); 
                         $fecha=date('Y-m-d H:i:s', time());                   
                         $nacionalidad=2;                         
                         $sql=$conn->prepare("INSERT INTO tbl_boleteria (cant_boletos, nacionalidad_id, id_usuario, creado_por, fecha_creacion,
                                             modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                         $sql->bind_param('iiissss',$cantidadE, $nacionalidad, $idusuario, $usuario, $fecha, $usuario, $fecha);
                         $sql->execute();
 
                         if($sql->error){
                             echo "Se produjo un error, no se registro en la base de datos";
                         }else{
                             echo "<div class='alert alert-success' role='alert'>
                             Se registro en la base de datos
                             </div>";
                         }
                         $sql->close();
                         $sql=null;
 
                         //echo '<script type="text/javascript"> location.href="/saat-proyecto-amitigra/senderos"; </script>';
                                               
                     
                 }catch(Exception $e) {
                     die("se produjo un error". $e->getMessage());
                 }
             }

        }
    }  
}



?>