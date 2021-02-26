<?php
include "../modelo/conexionbd.php";
$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    case 'registrarCamping': //realizar una reservacion para camping
        $cliente = $_POST['cliente'];
        $identidad = $_POST['identidad'];
        $nacionalidad = $_POST['nacionalidad'];
        $telefono = $_POST['telefono'];
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];//fecha de entrada
        $area = $_POST['area'];
        $localidad = $_POST['localidad'];
        $precioA = $_POST['precioAdulto'];
        $precioN = $_POST['precioNiños'];
        $salida = $_POST['salida'];//fecha salida
        $personas = $_POST['personas'];//cantidad de personas
        $niños = $_POST['ninos'];//cantidad de niños
        $tipoT = $_POST['tipoTienda'];
        //$sleeping = $_POST['sleeping'];
        $precioT = $_POST['precioTienda'];
        //$precioS = $_POST['precioSleeping'];
        $cant_tienda = $_POST['cant_tienda'];
        //$cant_sleeping = $_POST['cant_sleeping'];
        $total = $_POST['pago'];
        $id_usuario = $_POST['id_usuario'];
        $usuario_actual = $_POST['usuario_actual'];
        $estado_eliminado =1;
        //$estado_habitacion = 'DISPONIBLE';
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
        

        if(empty($_POST['cliente'])||empty($_POST['identidad'])||empty($_POST['nacionalidad'])||
            empty($_POST['telefono']) || empty($_POST['reservacion']) || empty($_POST['entrada'])
            || empty($_POST['area']) ||empty($_POST['precioTienda']) /*||empty($_POST['precioSleeping']) */
            /* || empty($_POST['cant_sleeping'])*/ || empty($_POST['tipoTienda']) /*|| empty($_POST['sleeping']) || */  
            || empty($_POST['localidad']) ||empty($_POST['precioAdulto']) ||empty($_POST['precioNiños'])
            || empty($_POST['salida']) || empty($_POST['personas']) || empty($_POST['ninos']) || empty($_POST['cant_tienda'])
            || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                //VERIFICAR E INSERTAR CLIENTE
                $verificar = $conn->prepare("SELECT id_cliente FROM tbl_clientes 
                                                WHERE identidad=?;");
                $verificar->bind_Param("s", $identidad);
                $verificar->execute();
                $verificar->bind_result($id);

                if($verificar->affected_rows){
                    $existe_cliente = $verificar->fetch();

                    while ($verificar->fetch()) {
                       $id_cliente = $id;
                    }
                    if($existe_cliente){
                        
                        //insercion en la tabla reservaciones
                        $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                        localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                        VALUES (?,?,?,?,?,?,?,?,?,?);");
                        $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id,$id_usuario,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $inserta->execute();

                        //se captura el id de la tabla de reservaciones
                        $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                        WHERE fecha_reservacion= ?;");
                        $capturar_reserva->bind_Param("s", $reservacion);
                        $capturar_reserva->execute();
                        $capturar_reserva->bind_result($idr);

                        if($capturar_reserva->affected_rows){
                            $existe_reservacion = $capturar_reserva->fetch();

                            while ($capturar_reserva->fetch()) {
                                $id_reserva = $idr;
                            }
                            if($existe_reservacion){
                                //require "../modelo/conexionbd.php";

                                //inserta en la tabla detalle de reservacion
                                $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                                                        inventario_id,cantidad_articulo,precio_articulo,total_pago,estado_eliminar,
                                                        creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
                                $insert->bind_param('iiiiiiiiissss', $idr,$area,$personas, $niños,$tipoT,$cant_tienda,$precioT,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                                $insert->execute();
                                //actualizar estado de habitacion
                                /*$actualizarH ="UPDATE tbl_habitacion_servicio SET estado_id = 2
                                WHERE id_habitacion_servicio = .$habitacion";
                                $actualizarH=$conn->query($actualizarH);*/
                                if ($insert->error) {
                                    $res['msj'] = "Se produjo un error al momento de registrar la reservación";
                                    $res['error'] = true;
                                } else {
                                    $res['msj'] = "la Reservación se Registro Correctamente";
                                }
                                
                            }
                        }
                            
                        
                    }else{
                        //INSERTAR A LA TABLA CLIENTES
                        $insertar=$conn->prepare("INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, creado_por,
                                                fecha_creacion, modificado_por, fecha_modificacion ) VALUES (?,?,?,?,?,?,?,?);");
                        $insertar->bind_param('sssissss', $cliente,$identidad,$telefono,$nacionalidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insertar->execute();
                        
                        //CAPTURAR EL ID DEL CLIENTE
                        $capt_cliente = $conn->prepare("SELECT id_cliente FROM tbl_clientes 
                                                WHERE identidad=?;");
                        $capt_cliente->bind_Param("s", $identidad);
                        $capt_cliente->execute();
                        $capt_cliente->bind_result($idc);

                        if($capt_cliente->affected_rows){
                            $existe_client = $capt_cliente->fetch();
                            while ($capt_cliente->fetch()) {
                                $id_client = $idc;
                            }

                            if($existe_client){

                                //INSERCION EN LA TABLA RESERVACIONES
                                $insert=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                                localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                VALUES (?,?,?,?,?,?,?,?,?,?);");
                                $insert->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id_client,$id_usuario,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
                                $insert->execute();

                                //se captura el id de la tabla de reservaciones
                                $capt_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                                WHERE fecha_reservacion= ?;");
                                $capt_reserva->bind_Param("s", $reservacion);
                                $capt_reserva->execute();
                                $capt_reserva->bind_result($idre);

                                if($capt_reserva->affected_rows){
                                    $existe_reserva = $capt_reserva->fetch();

                                     while ($capt_reserva->fetch()) {
                                     $id_reserv = $idre;
                                    }
                                    if($existe_reserva){
                                        //require "../modelo/conexionbd.php";

                                        //inserta en la tabla detalle de reservacion
                                        $inser=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                                                                inventario_id,cantidad_articulo,precio_articulo,total_pago,estado_eliminar,
                                                                creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
                                        $inser->bind_param('iiiiiiiiissss', $idre,$area,$personas, $niños,$tipoT,$cant_tienda,$precioT,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                                        $inser->execute();
                                        //actualizar estado de habitacion
                                        /*$actualizarH ="UPDATE tbl_habitacion_servicio SET estado_id = 2
                                        WHERE id_habitacion_servicio = .$habitacion";
                                        $actualizarH=$conn->query($actualizarH);*/
                                        if ($inser->error) {
                                            $res['msj'] = "Se produjo un error al momento de registrar la reservación";
                                            $res['error'] = true;
                                        } else {
                                            $res['msj'] = "la Reservación se Registro Correctamente";
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
        }
    break;
}