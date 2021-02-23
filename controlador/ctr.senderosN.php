<?php
class ControladorSenderosN{

        public function ctrSenderosN(){
        
            if(isset($_POST['tipo_generar']) == 'generarB'){
                $boletosN =$_POST['boletosN'];
                $boletosNN=$_POST['boletosNN'];
                $usuario=$_SESSION['usuario'];  
                
                if(($boletosN=="" && $boletosNN=="") || ($boletosN=="0" && $boletosNN=="0")){
                    
                    echo "<div class='alert alert-danger' role='alert'>
                                Tiene que vender un boleto NACIONAL
                                </div>";                        
                    }else{
                
                    try{
                        include "./modelo/conexionbd.php";  
                        $cantidadN=$boletosN+$boletosNN;
                        $totalN=$boletosN*50;
                        $totalNN=$boletosNN*30;
                        $totalizado=$totalN+$totalNN;
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha1=date('Y-m-d H:i:s', time()); 
                        $sql1=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?)");
                        $sql1->bind_param('iissss',$cantidadN, $totalizado, $usuario, $fecha1, $usuario, $fecha1);
                        $sql1->execute();

                        
                            
                            if($boletosN>0){                            
                                
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
                                    $captura1->bind_Param("i", $totalizado);                   
                                    $captura1->execute();
                                    $captura1->bind_result($idbv);

                                    if($captura1->affected_rows)
                                    $id_cobrado= $captura1->fetch();


                                while ($captura1->fetch()) {
                                        $idboleven = $idbv;
                                    }

                                    if($id_cobrado){
                                    
                                        include "./modelo/conexionbd.php";                           
                                        date_default_timezone_set("America/Tegucigalpa");
                                        $fecha=date('Y-m-d H:i:s', time());                   
                                        $nacionalidad=1;           
                                        $tipo_boleto=1;
                                        $subtotal=$boletosN*50;        
                                                
                                        $sql=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                            modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $sql->bind_param('iiiiiissss',$boletosN, $subtotal, $nacionalidad, $idusuario, $tipo_boleto, $idboleven, $usuario, $fecha, $usuario, $fecha);
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
                            
                            if($boletosNN>0){             
                                
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
                                $captura1->bind_Param("i", $totalizado);                   
                                $captura1->execute();
                                $captura1->bind_result($idbv);

                                if($captura1->affected_rows)
                                $id_cobradoN= $captura1->fetch();


                            while ($captura1->fetch()) {
                                    $idbolevenN = $idbv;
                                }

                                if($id_cobradoN){
                                           
                                    include "./modelo/conexionbd.php";                           
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha=date('Y-m-d H:i:s', time());                   
                                    $nacionalidad=1;           
                                    $tipo_boleto=2;
                                    $subtotal=$boletosNN*30;        
                                            
                                    $sql=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                            modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                        $sql->bind_param('iiiiiissss',$boletosNN, $subtotal, $nacionalidad, $idusuario, $tipo_boleto, $idbolevenN, $usuario, $fecha, $usuario, $fecha);
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
                           // echo '<script type="text/javascript"> location.href="/saat-proyecto-amitigra/senderos"; </script>';
                           //header("location:senderos");

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