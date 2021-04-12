<?php
include "../modelo/conexionbd.php";
//INSERTAR PARA CAMPING
if(isset($_POST['action']) == 'registroCamping'){
    $descripcionC = $_POST['descripcion'];
    $cantidad_adultosC = $_POST['cantidad_adultosC'];
    $cantidad_ninosC = $_POST['cantidad_ninosC'];
    $articulo = $_POST['articulo'];
    $cantarti = $_POST['cantarti'];
    $totalC = $_POST['totalC'];
    $fecha_reservacion = $_POST['reservacion'];
    $fecha_entrada = $_POST['entrada'];
    $fecha_salida = $_POST['salida'];
    $idCliente = $_POST['idCliente'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];
    

    if(!empty($descripcionC) || !empty($cantidad_adultosC)  || !empty($totalC)  ||!empty($idCliente)
        ||!empty($fecha_reservacion)||!empty($fecha_entrada)||!empty($fecha_salida)
        ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            $camping = 'camping';
            $estado_eliminado = 1;
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entrar = $fecha_entrada ." ".date('H:i:s',time());
            $salir = $fecha_salida ." ".date('H:i:s',time());

            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiisissss', $fecha_reservacion, $entrar,$salir,$idCliente,$id_usuario,$camping,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                    inventario_id, cantidad_articulo,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?);");
                    $insert->bind_param('iiiiiiiissss', $idr,$descripcionC,$cantidad_adultosC, $cantidad_ninosC,$articulo,$cantarti,
                    $totalC,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $insert->execute();
                    //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                    $captura_a = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                    WHERE habitacion_id = ?;");
                    $captura_a->bind_Param("s", $descripcionC);
                    $captura_a->execute();
                    $captura_a->bind_result($idA);

                    if($captura_a->affected_rows){
                        $existe_a = $captura_a->fetch();

                        while ($captura_a->fetch()) {
                            $id_area = $idA;
                        }
                        if($existe_a){
                            $actulizar_estado = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 5
                            WHERE id_habitacion_servicio = ?;");

                            $actulizar_estado -> bind_param('i', $idA);
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
