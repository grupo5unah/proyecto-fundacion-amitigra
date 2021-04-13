<?php
include "../modelo/conexionbd.php";
//INSERTAR PARA JUTIAPA
if(isset($_POST['action']) == 'registrarJutiapa'){
    $habitacion = $_POST['habitacion'];
    $cantidad_adultos = $_POST['cantidad_adultos'];
    $cantidad_ninos = $_POST['cantidad_ninos'];
    $total = $_POST['total'];
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $telefono = $_POST['telefono'];
    $nacionalidad = $_POST['nacionalidad'];
    $identidad = $_POST['identidad'];
    $idCliente = $_POST['idCliente'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];
    

    if(!empty($habitacion) || !empty($cantidad_adultos) ||!empty($cantidad_ninos) || !empty($total) ||!empty($nombre_cliente) ||!empty($idCliente)
    ||!empty($fecha_reservacion)||!empty($fecha_entrada)||!empty($fecha_salida)||!empty($identidad)||!empty($telefono)||!empty($nacionalidad)
    ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            $estado_eliminado = 1;
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entra = $fecha_entrada ." ".date('H:i:s',time());
            $salida = $fecha_salida ." ".date('H:i:s',time());

            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiiissss', $fecha_reservacion, $entra,$salida,$idCliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
