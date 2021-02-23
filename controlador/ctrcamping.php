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
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];//fecha de entrada
        $habitacion = $_POST['area'];
        $localidad = $_POST['localidad'];
        $precioA = $_POST['precioAdulto'];
        $precioN = $_POST['precioNiños'];
        $salida = $_POST['salida'];//fecha salida
        $personas = $_POST['personas'];//cantidad de personas
        $niños = $_POST['niños'];//cantidad de niños
        $cant_tienda = $_POST['cant_tienda'];
        $cant_sleeping = $_POST['cant_sleeping'];
        $total = $_POST['pago'];
        $usuario_actual = $_POST['usuario_actual'];
        $id_usuario = 4;
        $estado_eliminado =1;
        //$estado_habitacion = 'DISPONIBLE';
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
        

        if(empty($_POST['cliente'])|| empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['habitacion'])
            || empty($_POST['localidad']) ||empty($_POST['precioAdulto']) ||empty($_POST['precioNiños'])
            || empty($_POST['salida']) || empty($_POST['personas']) || empty($_POST['niños']) || empty($_POST['cant_habitacion'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                
                //insercion en la tabla reservaciones
                $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                                localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                VALUES (?,?,?,?,?,?,?,?,?,?);");
                $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$cliente,$id_usuario,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
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

                       
                        //inserta en la tabla detalle de reservacion
                        $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                                                total_pago,estado_eliminar,
                                                creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                                VALUES (?,?,?,?,?,?,?,?,?,?);");
                        $insert->bind_param('iiiiiissss', $idr,$habitacion,$personas, $niños,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                
                
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    break;
}