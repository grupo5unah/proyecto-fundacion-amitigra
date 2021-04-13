<?php
include "../modelo/conexionbd.php";
//INSERTAR PARA BOLETOS
if(isset($_POST['action']) == 'registrartickets'){
    $localidad = $_POST['localidad'];
    $cant_Badultos = $_POST['cantidadB'];    
    $subtotal  = $_POST['SubTotal'];
    $tipo_boleto = $_POST['tipoBoleto'];       
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];           
    date_default_timezone_set("America/Tegucigalpa");
    $fecha=date('Y-m-d H:i:s',time());
    $estado=1;
    

    if(!empty($localidad) || !empty($cant_Badultos) ||!empty($subtotal) || !empty($tipo_boleto) 
                            ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            
            $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, estado_eliminado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                    $inserta->bind_param('iiissss',$totalBNacional, $totalP, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $inserta->execute();

            //se captura el id de la tabla de reservaciones
            $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                            WHERE fecha_reservacion= ?;");
            $capturar_reserva->bind_Param("s", $fecha_reservacion);
            $capturar_reserva->execute();
            $capturar_reserva->bind_result($idr);

            if($capturar_reserva->affected_rows){
                $existe_reservacion = $capturar_reserva->fetch();

                while ($capturar_reserva->fetch()) {
                    $id_reserva = $idr;
                }
                if($existe_reservacion){
                    //inserta en la tabla detalle de reservacion
                    $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                    total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?);");
                    $insert->bind_param('iiiiiissss', $idr,$habitacion,$cantidad_adultos, $cantidad_ninos,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $insert->execute();

                    //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                    $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                    WHERE habitacion_id = ?;");
                    $captura_ha->bind_Param("s", $habitacion);
                    $captura_ha->execute();
                    $captura_ha->bind_result($idH);

                    if($captura_ha->affected_rows){
                        $existe_ha = $captura_ha->fetch();

                        while ($captura_ha->fetch()) {
                            $id_hab = $idH;
                        }
                        if($existe_ha){
                            $actulizar_estado = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 5
                            WHERE id_habitacion_servicio = ?;");

                            $actulizar_estado -> bind_param('i', $idH);
                            $actulizar_estado -> execute();

                            if(!$actulizar_estado -> error){
                                $respuesta = array (
                                    "respuesta"=>"exito"
                                );
                            }else{
                                $respuesta = array (
                                    "respuesta"=>"error"
                                );
                            }
                            // FALTA QUE ACTUALICE EL ESTADO A DISPONIBLE  
                        }

                    }
                    
                    
                }
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
