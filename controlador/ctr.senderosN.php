<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    
    case 'registrarBoletos': //realizar una venta de boletos        
            //$localidad = $_POST['localidad'];
            $cant_Badultos = $_POST['boletosN'];
            $cant_Bninos = $_POST['boletosNN'];
            $precioAdulto  = $_POST['precioN'];
            $precioNino = $_POST['precioNN'];
            $totalP = $_POST['Tpagar'];
            $totalBNacional = $_POST['TboletosN'];
            $usuario_actual = $_POST['usuario_actual']; 
            $user=$_POST['id_usuario'];            
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
                    

            if(($cant_Badultos=="" && $cant_Bninos=="") || ($cant_Badultos=="0" && $cant_Bninos=="0")){
                $res['msj'] = 'Tiene que vender un Boleto Nacional';
                $res['error'] = true;
             }else{
            try{                    
                $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, creado_por, fecha_creacion, modificado_por, 
                                        fecha_modificacion) VALUES(?,?,?,?,?,?)");
                $inserta->bind_param('iissss',$totalBNacional, $totalP, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $inserta->execute();

                if($cant_Badultos>0){
                //se captura el id de la tabla de boletos     
                                    
                    $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                    $captura1->bind_Param("i", $totalP);                   
                    $captura1->execute();
                    $captura1->bind_result($idbv);

                    if($captura1->affected_rows)
                    $id_cobrado= $captura1->fetch();

                    while ($captura1->fetch()) {
                        $idboleven = $idbv;
                    }
                        if($id_cobrado){                            
                            
                            //inserta en la tabla detalle de reservacion                                
                            $nacionalidad=1;           
                            $tipo_boleto=1;
                            $subtotal=$cant_Badultos*$precioAdulto;
                            $insert=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                    modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                            $insert->bind_param('iiiiiissss',$cant_Badultos, $subtotal, $nacionalidad, $user, $tipo_boleto, $idbv, $usuario_actual, $fecha, $usuario_actual, $fecha);
                            $insert->execute();                            
                           
                        }                  
                    }

                    if($cant_Bninos>0){
                        //se captura el id de la tabla de boletos      
                        
                            $captura=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                            $captura->bind_Param("i", $totalP);                   
                            $captura->execute();
                            $captura->bind_result($idbv);
        
                            if($captura->affected_rows)
                            $id_cobradoN= $captura->fetch();
        
                            while ($captura->fetch()) {
                                $idbolevenN = $idbv;
                            }
                                if($id_cobradoN){                            
                                    
                                    //inserta en la tabla detalle de reservacion
                                    $nacionalidad=1;           
                                    $tipo_boleto=2;
                                    $subtotalN=$cant_Bninos*$precioNino;
                                    $insertN=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, boletos_vendidos_id,  creado_por, fecha_creacion,
                                                            modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                    $insertN->bind_param('iiiiiissss',$cant_Bninos, $subtotalN, $nacionalidad, $user, $tipo_boleto, $idbv, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                    $insertN->execute();                            
                                   
                                }                   
                        }                    
                if ($inserta->error){
                    $res['msj'] = "Se produjo un error al momento de vender el boleto";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "los Boletos se Registraron Correctamente";
                }
                
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }

               

    break;    
    
    default:
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//header("Location: ../senderos?signup=success");
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);