<?php
include "../modelo/conexionbd.php";
//INSERTAR PARA JUTIAPA
if(isset($_POST['action']) == 'registrohotelejutiapa'){
    $conte = json_decode($_POST['conteHotelJutiapa']);
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $idCliente = $_POST['idcliente'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];
    
 
    if(!empty($_POST['conteHotelJutiapa']) ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            $hotel = 'HOTEL';
            $estado_eliminado = 1;
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entrar = $fecha_entrada ." ".date('H:i:s',time());
            $salir = $fecha_salida ." ".date('H:i:s',time());

            include_once ("../modelo/conexionbd.php");
            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiisissss', $fecha_reservacion, $entrar,$salir,$idCliente,$id_usuario,$hotel,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
            $inserta->execute();
            
            
            include_once "../modelo/conexionbd.php";
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
                    $articulo = 1;   
                    //inserta en la tabla detalle de reservacion
                    $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                    inventario_id,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?);");
                    foreach($conte as $valor){
                        $id_habi = $valor->habitaciones;
                        $adultos = $valor->adultoj;
                        $ninos = $valor->ninoj;
                        $total = $valor->totalj;

                        $insert->bind_param('iiiiiiissss', $idr,$id_habi,$adultos, $ninos,$articulo,
                        $total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();
                    }
                     //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                    $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                    WHERE habitacion_id = ?;");
                    $captura_ha->bind_Param("i", $id_habi);
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

                                //Registra en la BITACORA la accion realizada
                                date_default_timezone_set("America/Tegucigalpa");
                                $fecha_bitacora=date('Y-m-d H:i:s',time());
                                $objeto = 10;
                                $acciones = "Reservación de hotel";
                                $descp = "Reservación de hotel en Jutiapa realizada correctamente";
                                //include("../modelo/conexionbd.php");
                                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssii", $acciones, $descp, $fecha_bitacora, $id_usuario, $objeto);
                                $llamar->execute();
                                //$llamar->close();

                                $respuesta = array (
                                    "respuesta"=>"exito"
                                );
                            }else{
                                $respuesta = array (
                                    "respuesta"=>"error"
                                );
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
/*else if(isset($_POST['accion']) == 'registrarRosario'){
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
                    $articulor=1;
                    //inserta en la tabla detalle de reservacion
                    $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                    inventario_id,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?);");
                    $insert->bind_param('iiiiiiissss', $idr,$habitacionR,$cantidad_adultosR, $cantidad_ninosR,$articulor,
                    $totalR,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $insert->execute();

                    //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                    $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                    WHERE habitacion_id = ?;");
                    $captura_ha->bind_Param("s", $habitacionR);
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
        }catch(Exception $e){
        echo $e->getMessage();
        }
    }else{
        $respuesta2 = array (
            "respuesta"=>"error"
        );
    }
    echo json_encode($respuesta2);
}*/

