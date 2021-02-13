<?php
class ControladorSenderosE{

    public function ctrSenderosE(){

        if(isset($_POST['tipo_generar']) == 'generarB'){
            $boletosE =$_POST['boletosE'];           
            $boletosNE=$_POST['boletosNE'];
            $tasaCambio=$_POST['Tasacambio'];
            $usuario=$_SESSION['usuario'];    

            if(($boletosE=="" && $boletosNE=="") || ($boletosE=="0" && $boletosNE=="0")){
                
                echo "<div class='alert alert-danger' role='alert'>
                        Tiene que vender un boleto EXTRANJERO
                        </div>";                        
            }else{     
                
                try{
                    include "./modelo/conexionbd.php";  
                    $cantidadE=$boletosE+$boletosNE;
                    $totalE=$boletosE*(10*$tasaCambio);
                    $totalNE=$boletosNE*(5*$tasaCambio);
                    $totalizadoE=$totalE+$totalNE;
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha1=date('Y-m-d H:i:s', time()); 
                    $sql1=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, creado_por, fecha_creacion, modificado_por, 
                                        fecha_modificacion) VALUES(?,?,?,?,?,?)");
                    $sql1->bind_param('iissss',$cantidadE, $totalizadoE, $usuario, $fecha1, $usuario, $fecha1);
                    $sql1->execute();

                    
                        
                        if($boletosE>0){                            
                            
                                require_once("./modelo/conexionbd.php");
                                $captura=$conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario=?;");
                                $captura->bind_Param("s", $usuario); 
                                $captura->execute();
                                $captura->bind_result($id);

                                while ($captura->fetch()) {
                                    $idusuario = $id;
                                }            

                                require_once("./modelo/conexionbd.php");
                                $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                                $captura1->bind_Param("i", $totalizadoE);                   
                                $captura1->execute();
                                $captura1->bind_result($idbv);

                                if($captura1->affected_rows)
                                $id_cobradoE= $captura1->fetch();


                            while ($captura1->fetch()) {
                                    $idbolevenE = $idbv;
                                }

                                if($id_cobradoE){
                                
                                    include "./modelo/conexionbd.php";                           
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha=date('Y-m-d H:i:s', time());                   
                                    $nacionalidad=2;           
                                    $tipo_boleto=3;
                                    $subtotal=$boletosE*(10*$tasaCambio);        
                                            
                                    $sql=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                        modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                    $sql->bind_param('iiiiiissss',$boletosE, $subtotal, $nacionalidad, $idusuario, $tipo_boleto, $idbolevenE, $usuario, $fecha, $usuario, $fecha);
                                    $sql->execute();

                                    if($sql->error){
                                        echo "revise problema";
                                    }else{
                                        echo "con exito";
                                    }
                                    $sql->close();
                                    $sql=null;
                                }
                                    //echo '<script type="text/javascript"> location.href="/saat-proyecto-amitigra/senderos"; </script>';
                        }
                        
                        if($boletosNE>0){             
                            
                            require_once("./modelo/conexionbd.php");
                            $captura=$conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario=?;");
                            $captura->bind_Param("s", $usuario); 
                            $captura->execute();
                            $captura->bind_result($id);

                            while ($captura->fetch()) {
                                $idusuario = $id;
                            }            

                            require_once("./modelo/conexionbd.php");
                            $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                            $captura1->bind_Param("i", $totalizadoE);                   
                            $captura1->execute();
                            $captura1->bind_result($idbv);

                            if($captura1->affected_rows)
                            $id_cobradoNE= $captura1->fetch();


                        while ($captura1->fetch()) {
                                $idbolevenNE = $idbv;
                            }

                            if($id_cobradoNE){
                                       
                                include "./modelo/conexionbd.php";                           
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha=date('Y-m-d H:i:s', time());                   
                                $nacionalidad=2;           
                                $tipo_boleto=4;
                                $subtotal=$boletosNE*(5*$tasaCambio);        
                                        
                                $sql=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                            modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $sql->bind_param('iiiiiissss',$boletosNE, $subtotal, $nacionalidad, $idusuario, $tipo_boleto, $idbolevenNE, $usuario, $fecha, $usuario, $fecha);
                                $sql->execute();

                                if($sql->error){
                                    echo "revise problema";
                                }else{
                                    echo "con exito";
                                }
                                $sql->close();
                                $sql=null;
                        
                                
                            }
                        }                   
                        //echo '<script type="text/javascript"> location.href="/saat-proyecto-amitigra/senderos"; </script>';

                    if($sql1->error){
                        echo "Se produjo un error, no se facturo registro en la base de datos";
                    }else{
                        echo "Se registro en la base de datos";
                    }
                    $sql1->close();
                    $sql1=null;
                        
                }catch(Exception $e) {
                    die("se produjo un error". $e->getMessage());
                } 
            }
        }
       
    }
}
?>