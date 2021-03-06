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
    $idCliente = $_POST['idCliente'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];
    

    if(!empty($habitacion) || !empty($cantidad_adultos) ||!empty($cantidad_ninos) || !empty($total)  ||!empty($idCliente)
    ||!empty($fecha_reservacion)||!empty($fecha_entrada)||!empty($fecha_salida) ||!empty($id_usuario)||!empty($usuario_actual)
    ||!empty($hotel)){

        try{
            //require "../modelo/conexionbd.php";
            $estado_eliminado = 1;
            $hotel = 'hotel';
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entra = $fecha_entrada ." ".date('H:i:s',time());
            $salida = $fecha_salida ." ".date('H:i:s',time());

            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiiisssss', $fecha_reservacion, $entra,$salida,$idCliente,$id_usuario,$hotel,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                    
                    // capturar el id de la habitacion
                    $caphabi = $conn -> prepare("SELECT id_habitacion_servicio FROM tbl_habitacion_servicio
                    WHERE habitacion_area = ?;");
                    $caphabi->bind_Param("s", $habitacion);
                    $caphabi->execute();
                    $caphabi->bind_result($habit_id);

                    if($caphabi->affected_rows){
                        $existeidha = $caphabi->fetch();

                        while ($caphabi->fetch()){
                            $idhabita = $habit_id;
                        }

                        if($existeidha){
                            $articulo = 1;
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            inventario_id,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiiissss', $idr,$habit_id,$cantidad_adultos, $cantidad_ninos,$articulo,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_ha->bind_Param("s", $habit_id);
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
                                    // actualizar la el estado de la habitacion segun las fechas
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fech = date('Y-m-d H:i:s', time());
                                    //generar fecha para realizar cambio de estado de habitacion
                                    $fecha_actual = new DateTime($fech); 
                                    if($fecha_actual == $salida){
                                        $actulizar = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 4
                                        WHERE id_habitacion_servicio = ?;");
                                    }
                                }

                            }
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
//INSERTAR PARA ROSARIO
else if(isset($_POST['accion']) == 'registrarRosario'){
    $habitacionR = $_POST['habitacionR'];
    $cantidad_adultosR = $_POST['cantidad_adultosR'];
    $cantidad_ninosR = $_POST['cantidad_ninosR'];
    $totalR = $_POST['totalR'];
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
    

    if(!empty($habitacionR) || !empty($cantidad_adultosR) ||!empty($cantidad_ninosR) || !empty($totalR) ||!empty($nombre_cliente) ||!empty($idCliente)
    ||!empty($fecha_reservacion)||!empty($fecha_entrada)||!empty($fecha_salida)||!empty($identidad)||!empty($telefono)||!empty($nacionalidad)
    ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            $hotel = 'hotel';
            $estado_eliminado = 1;
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entra = $fecha_entrada ." ".date('H:i:s',time());
            $salida = $fecha_salida ." ".date('H:i:s',time());

            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiisissss', $fecha_reservacion, $entra,$salida,$idCliente,$id_usuario,$hotel,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                    // capturar el id de la habitacion
                    $capha = $conn -> prepare("SELECT id_habitacion_servicio FROM tbl_habitacion_servicio
                    WHERE habitacion_area = ?;");
                    $capha->bind_Param("s", $habitacionR);
                    $capha->execute();
                    $capha->bind_result($habi_id);

                    if($capha->affected_rows){
                        $existeidh = $capha->fetch();

                        while ($capha->fetch()){
                            $idhabit = $habi_id;
                        }
                        
                        if($existeidh){
                            $articulor=1;
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            inventario_id,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiiissss', $idr,$habi_id,$cantidad_adultosR, $cantidad_ninosR,$articulor,
                            $totalR,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_ha->bind_Param("s", $habi_id);
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
                                        $respuesta2 = array (
                                            "respuesta"=>"exito"
                                        );
                                    }else{
                                        $respuesta2 = array (
                                            "respuesta"=>"error"
                                        );
                                    }
                                    // actualizar la el estado de la habitacion segun las fechas
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fech = date('Y-m-d H:i:s', time());
                                    //generar fecha para realizar cambio de estado de habitacion
                                    $fecha_actual = new DateTime($fech); 
                                    if($fecha_actual == $salida){
                                        $actulizar = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 4
                                        WHERE id_habitacion_servicio = ?;");
                                    } 
                                }

                            }
                        }
                    }
                    
                }
            }                          
        }catch(Exception $e){
        echo $e->getMessage();
        }
    }else{
        $respuesta2 = array (
            "respuesta"=>"error"
        );
    }
    echo json_encode($respuesta2);
}

