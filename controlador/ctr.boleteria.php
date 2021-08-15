<?php
include_once "../modelo/conexionbd.php";
//INSERTAR PARA BOLETOS
if(isset($_POST['action']) == 'registrartickets'){
    $conte = json_decode($_POST['conteBoletos']);
    $totalBoletos = $_POST['TotalBoletos'];
    $totalPagar = $_POST['TotalPagar'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];           
    date_default_timezone_set("America/Tegucigalpa");
    $fecha=date('Y-m-d H:i:s',time());
    $estado=1;
    

    if(!empty($_POST['conteBoletos']) ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
                     //include_once "../modelo/conexionbd.php"; 
                    $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, estado_eliminado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                    $inserta->bind_param('iiissss',$totalBoletos, $totalPagar, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $inserta->execute();
                    
                    
                    //se captura el id de la tabla tbl_boletos recien creado  
                         //include_once "../modelo/conexionbd.php";          
                         $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                        $captura1->bind_Param("i", $totalPagar);                   
                        $captura1->execute();
                        $captura1->bind_result($idbv);

                        if($captura1->affected_rows){
                        $id_cobrado= $captura1->fetch();

                        while ($captura1->fetch()) {
                            $idboleven = $idbv;
                        }
                            if($id_cobrado){      
                                
                                        //inserta en la tabla tbl_boletos_detalle por boletos adultos nacional vendidos 
                                        $insert=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, usuario_id, tipo_boleto_id, localidad_id, boletos_vendidos_id,
                                                            estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                                                            foreach($conte as $valor){
                                                                $cantidad = $valor->CantBoleto;
                                                                $TipoBoletoS = $valor->TipoBoletoS;
                                                                $Localidad = $valor->Localidad;
                                                                $subtotal = $valor->totalPB;
                                                                
                                                            
                                        $insert->bind_param('iiiiiiissss',$cantidad, $subtotal, $id_usuario, $TipoBoletoS, $Localidad, $idbv, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                        $insert->execute();    
                                                            }
                                                 }      
                }
               
                if (!$inserta->error){
                                     
                     //Registra en la BITACORA la accion realizada
                     date_default_timezone_set("America/Tegucigalpa");
                     $fecha2=date('Y-m-d H:i:s',time());
                     $objeto = 7;
                    $acciones = "Venta de Boletos";
                    $descp = "Nueva Venta de Boletos Con Orden No. " . $idbv;
                    require_once("../modelo/conexionbd.php");
                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha2, $id_usuario, $objeto);
                    $llamar->execute();
                    $llamar->close();  

                    $respuesta= array("respuesta"=>"exito");         
                } else {
                    $respuesta= array("respuesta"=>"fallo");                                         
                    }   
        }catch(Exception $e){
        echo $e->getMessage();
        }   
         
    }else{
        $respuesta = array (
            "respuesta"=>"error"
        );
    }
    echo json_encode($respuesta);
}
