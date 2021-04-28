<?php
include_once "../modelo/conexionbd.php";
//INSERTAR PARA CAMPING
// if(isset($_POST['action']) == 'registroCamping'){
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

            //include_once ("../modelo/conexionbd.php");
            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiisissss', $fecha_reservacion, $entrar,$salir,$idCliente,$id_usuario,$camping,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
            $inserta->execute();
            //$inserta-> close();
            
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
                    //captura el id del area 
                    $caparea = $conn -> prepare("SELECT id_habitacion_servicio FROM tbl_habitacion_servicio
                    WHERE habitacion_area = ?;");
                    $caparea->bind_Param("s", $descripcionC);
                    $caparea->execute();
                    $caparea->bind_result($ha_id);

                    if($caparea->affected_rows){
                        $existeid = $caparea->fetch();

                        while ($caparea->fetch()){
                            $idha_area = $ha_id;
                        }

                        if($existeid){
                            //captura el id del area 
                            $arti = $conn -> prepare("SELECT producto_id FROM tbl_inventario
                                INNER JOIN tbl_producto
                                ON tbl_inventario.producto_id = tbl_producto.id_producto
                                WHERE nombre_producto = ?;");
                            $arti->bind_Param("s", $articulo);
                            $arti->execute();
                            $arti->bind_result($id_art);

                            if($arti -> affected_rows){
                                $existe = $arti->fetch();

                                while ($arti -> fetch()){

                                    $art = $id_art;
                                }
                                
                                if($existe){
                                    //include_once ("../modelo/conexionbd.php");
                                    //inserta en la tabla detalle de reservacion
                                    $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                                    inventario_id, cantidad_articulo,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?);");
                                    $insert->bind_param('iiiiiiiissss', $idr,$ha_id,$cantidad_adultosC, $cantidad_ninosC,$id_art,$cantarti,
                                    $totalC,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                                    $insert->execute();

                                    //include_once "../modelo/conexionbd.php";
                                    //capturar el el articulo para registrar la salida
                                    $cap_articulo = $conn->prepare("SELECT inventario_id FROM tbl_detalle_reservacion
                                    WHERE inventario_id = ?;");
                                    $cap_articulo ->bind_Param("i",$id_art);
                                    $cap_articulo ->execute();
                                    $cap_articulo-> bind_result($idarti);

                                    if($cap_articulo->affected_rows){
                                        $existe_articulo = $cap_articulo->fetch();

                                        while($cap_articulo -> fetch()){
                                            $arti_id = $idarti;
                                        }

                                        if($existe_articulo){
                                            $tipoMovimiento = 2;
                                            $descp = "UND";
                                            $cantarti = $_POST['cantarti'];
                                            //$cant =1;
                                            date_default_timezone_set("America/Tegucigalpa");
                                            $fechaM=date('Y-m-d H:i:s',time());
                                            $sql = $conn->prepare("INSERT INTO tbl_movimientos (producto_id, tipo_movimiento_id, descripcion, cantidad,fecha_movimiento,  
                                            creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                            VALUES (?,?,?,?,?,?,?,?,?)");
                                            $sql->bind_Param("iisisssss",$idarti,$tipoMovimiento,$descp,$cantarti,$fechaM,$usuario_actual,$fechaM,$usuario_actual,$fechaM);
                                            $sql->execute();

                                            
                                            //capturar el tipo de movimiento para actualizar el inventario
                                            $cap_mov = $conn->prepare("SELECT id_movimiento FROM tbl_movimientos
                                            WHERE tipo_movimiento_id = ?;");
                                            $cap_mov ->bind_Param("i",$tipoMovimiento);
                                            $cap_mov ->execute();
                                            $cap_mov-> bind_result($idmov);

                                            if($cap_mov->affected_rows){
                                                $existe_mov = $cap_mov->fetch();

                                                while($cap_mov -> fetch()){
                                                    $mov_id = $idmov;
                                                }

                                                if($existe_mov){
                                                    
                                                    $actulizar_inventario = $conn -> prepare( "UPDATE tbl_inventario SET movimiento_id = '$idmov'
                                                        WHERE producto_id = ? ;");
                                                    $actulizar_inventario -> bind_param('i', $idarti);
                                                    $actulizar_inventario -> execute();

                                                    
                                                    $actulizar_estado = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                                    WHERE id_habitacion_servicio = ?;");

                                                    $actulizar_estado -> bind_param('i', $ha_id);
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

                                                    /*CREALIZA CAMBIO DE ESTADO DE HABITACION
                                                    $sql = "SELECT fecha_salida from tbl_reservaciones
                                                    where id_reservacion = 69";
                                                    $resultado = mysqli_query($conn,$sql);
                                                    $ver = mysqli_fetch_assoc($resultado);
                                                    // echo $ver["fecha_salida"];

                                                    date_default_timezone_set("America/Tegucigalpa");
                                                    $fechaHoy = date("Y-m-d H:i:s", time());

                                                    if($ver >= $fechaHoy){
                                                        $actulizar = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 4
                                                        WHERE id_habitacion_servicio = 14");
                                                        $actulizar -> execute();
                                                    }*/
                                                            
                                                        

                                                    
                                                }
                                            }
                                                
                                            
                                        }
                    
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
//}
