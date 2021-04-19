<?php
include_once "../modelo/conexionbd.php";
//INSERTAR PARA BOLETOS
if(isset($_POST['action']) == 'registrartickets'){
    $localidad = $_POST['localidad'];
    $cantidad = $_POST['cantidadB'];    
    $subtotal  = $_POST['SubTotal'];
    $tipo_boleto = $_POST['tipoBoleto'];  
    $totalBoletos = $_POST['TotalBoletos'];
    $totalPagar = $_POST['TotalPagar'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];           
    date_default_timezone_set("America/Tegucigalpa");
    $fecha=date('Y-m-d H:i:s',time());
    $estado=1;
    

    if(!empty($localidad) || !empty($cantidad) ||!empty($tipo_boleto)|| !empty($totalBoletos) || !empty($totalPagar) || !empty($subtotal)){

        try{
            
                    $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, estado_eliminado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                    $inserta->bind_param('iiissss',$totalBoletos, $totalPagar, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $inserta->execute();
                    
                    if($cantidad>0){
                    //se captura el id de la tabla tbl_boletos recien creado  
                         include_once "../modelo/conexionbd.php";          
                        $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                        $captura1->bind_Param("i", $totalPagar);                   
                        $captura1->execute();
                        $captura1->bind_result($idbv);

                        if($captura1->affected_rows)
                        $id_cobrado= $captura1->fetch();

                        while ($captura1->fetch()) {
                            $idboleven = $idbv;
                        }
                            if($id_cobrado){                            
                                include_once "../modelo/conexionbd.php"; 
                                //inserta en la tabla tbl_boletos_detalle por boletos adultos nacional vendidos                               
                                $nacionalidad=1;
                                $insert=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, localidad_id, boletos_vendidos_id,
                                                    estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                $insert->bind_param('iiiiiiiissss',$cantidad, $subtotal, $nacionalidad, $id_usuario, $tipo_boleto, $localidad, $idbv, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                $insert->execute();                            
                            
                            } 
                    }
                    if (!$inserta->error){
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
