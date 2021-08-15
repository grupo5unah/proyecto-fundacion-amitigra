<?php
include "../modelo/conexionbd.php";

//BUSCAR CLIENTE

 if(isset($_POST['accion']) == 'buscarCliente'){
    if(!empty($_POST['identidad'])){
        $identidad = strval($_POST['identidad']);
        //echo $identidad;

        $resultado = 0;
        $sql=mysqli_query($conn,"SELECT id_cliente,nombre_completo,identidad,telefono,tipo_nacionalidad
        FROM tbl_clientes WHERE identidad = '$identidad'  AND estado_eliminado=1");
        mysqli_close($conn);
        $resultado = mysqli_num_rows($sql);
            $data = '';
        if ($resultado) {
            $data= mysqli_fetch_assoc($sql);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } 
        
    }
    exit;
    
 }
$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    case 'registrarCliente':
        $identidad= $_POST['identidad'];
        $nombre=$_POST['cliente'];
        $nacionalidad=$_POST['nacionalidad'];                 
        $telefono=$_POST['telefono'];
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());

        if(empty($_POST['identidad'])|| empty($_POST['cliente'])||
            empty($_POST['nacionalidad'])|| empty($_POST['telefono'])|| empty($_POST['usuario_actual'])){
            
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;

        }else{
            try{
                $insertar=$conn->prepare("INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, 
                                estado_eliminado,creado_por,fecha_creacion, modificado_por, fecha_modificacion)
                                VALUES (?,?,?,?,?,?,?,?,?);");
                $insertar->bind_param('sssiissss', $nombre,$identidad,$telefono,$nacionalidad,$estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Cliente";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Cliente Registrado Correctamente";
                }
            }catch(exception $e){
                echo $e->getMessage();
            }
        } 
    break;
    case 'actualizarReservacion':
        if(isset($_POST['id_reservacion']) && isset($_POST['reservacion']) &&
            isset($_POST['entrada']) && isset($_POST['salida'])){

                $id_reservacion=$_POST['id_reservacion'];
                $reservacion=$_POST['reservacion'];
                $entrada=$_POST['entrada'];
                $salida = $_POST['salida'];
                $user = $_POST['idu'];
                date_default_timezone_set("America/Tegucigalpa");
                $entrar = $entrada ." ".date('H:i:s',time());
                $salir = $salida ." ".date('H:i:s',time());
                

                $actualizarcamping = "UPDATE tbl_detalle_reservacion dr
                                    inner join tbl_reservaciones r
                                    on dr.reservacion_id = r.id_reservacion
                                    set 
                                    r.fecha_entrada='$entrar', r.fecha_salida='$salir' 
                                    WHERE id_reservacion=".$id_reservacion;
                
                $resultado=$conn->query($actualizarcamping);
                if ($resultado == 1) {
                    //Registra en la BITACORA la accion realizada
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha_bitacora=date('Y-m-d H:i:s',time());
                    $objeto = 11;
                    $acciones = "Actualización de una reservación";
                    $descp = "Actualización de reservación N° ".$id_reservacion;
                    //include("../modelo/conexionbd.php");
                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha_bitacora, $user, $objeto);
                    $llamar->execute();
                    $res['msj'] = "Reservación se edito correctamente";
                } else {
                    $res['msj'] = "Se produjo un error al momento de Editar la reservación ";
                    $res['error'] = true;
                }
            }else{
                $res['msj'] = "Las variables no estan definidas";
                $res['error'] = true;
            }
    break;
    case 'traerDetalle':
        $DetReserva = $_GET['idReservacion'];
        try {

            $sql = "SELECT id_detalle_reservacion, reservacion_id, tbl_habitacion_servicio.habitacion_area, tbl_habitacion_servicio.precio_adulto_nacional,
            tbl_habitacion_servicio.precio_nino_nacional,cantidad_persona,cantidad_ninos,
           tbl_producto.nombre_producto as producto
           FROM tbl_detalle_reservacion
           INNER JOIN tbl_habitacion_servicio
           ON tbl_detalle_reservacion.habitacion_id = tbl_habitacion_servicio.id_habitacion_servicio
           INNER JOIN tbl_inventario
           ON tbl_detalle_reservacion.inventario_id = tbl_inventario.id_inventario
           INNER JOIN tbl_producto
           ON tbl_inventario.producto_id = tbl_producto.id_producto
           WHERE id_detalle_reservacion = '$DetReserva'";
            $result = $conn->query($sql);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $vertbl = array();
        while ($eventos = $result->fetch_assoc()) {
            $evento = array(
                'numero' => $eventos['reservacion_id'],
                'habitacionArea' => $eventos['habitacion_area'],
                'adultos' => $eventos['cantidad_persona'],
                'padulto' => $eventos['precio_adulto_nacional'],
                'niños' => $eventos['cantidad_ninos'],
                'pniño' => $eventos['precio_nino_nacional'],
                'articulos' => $eventos['producto'],
                
            );
            array_push($vertbl, $evento);
        }
        $res['reserva'] = $vertbl;

    break;
    case 'salidaReservacion':
        if(isset($_POST['id_reserva']) && isset($_POST['habiarea']) && isset($_POST['arti'])){

                $id_reservasale=$_POST['id_reserva'];
                $habiarea=$_POST['habiarea'];
                $arti=$_POST['arti'];
                $usua = $_POST['iduh'];
                date_default_timezone_set("America/Tegucigalpa");
                $fechahabiarea=date('Y-m-d H:i:s',time());
                

                $captura_ha = $conn->prepare("SELECT id_detalle_reservacion, habitacion_id FROM tbl_detalle_reservacion
                                            WHERE id_detalle_reservacion = ?;");
                $captura_ha->bind_Param("i", $id_reservasale);
                $captura_ha->execute();
                $captura_ha->bind_result($idH, $r);

                if($captura_ha->affected_rows){
                    $existe_ha = $captura_ha->fetch();

                    while ($captura_ha->fetch()) {
                        $id_hab = $idH;
                    }
                    if($existe_ha){

                        $actualizarestado = "UPDATE tbl_habitacion_servicio 
                        set  estado_id = 4
                        WHERE id_habitacion_servicio = 5";

                        $resultado=$conn->query($actualizarestado);
                        if ($resultado == 1) {
                            //Registra en la BITACORA la accion realizada
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha_bitacora=date('Y-m-d H:i:s',time());
                            $objeto = 11;
                            $acciones = "Marcar salida";
                            $descp = "Reservación actualizada correctamente";
                            //include("../modelo/conexionbd.php");
                            $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                            $llamar->bind_Param("sssii", $acciones, $descp, $fecha_bitacora, $usua, $objeto);
                            $llamar->execute();
                            $res['msj'] = "Salida realizada Correctamente";
                        } else {
                            $res['msj'] = "Se produjo un error al momento de marcar salida ";
                            $res['error'] = true;
                        }

                        
                    }
                }
            }else{
                $res['msj'] = "Las variables no estan definidas";
                $res['error'] = true;
            }

    break;
    case 'eliminarReservacion':
        if (isset($_POST['id_reservacion'])) {
            $id_reserva = $_POST['id_reservacion'];
            $user_id = $_POST['id_user'];
            $sql = "UPDATE tbl_detalle_reservacion SET estado_eliminado = 0 WHERE reservacion_id = " .$id_reserva;
            $resultado = $conn->query($sql);
                
            //se captura el id de la tabla de habitacion servicio para cambiarle el estado a disponible
                $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                WHERE reservacion_id =  ?;");
                $captura_ha->bind_Param("i", $id_reserva);
                $captura_ha->execute();
                $captura_ha->bind_result($idH);

                if($captura_ha->affected_rows){
                    $existe_ha = $captura_ha->fetch();

                    while ($captura_ha->fetch()) {
                        $id_hab = $idH;
                    }
                    if($existe_ha){
                        $actulizar_estado = $conn -> prepare( "UPDATE tbl_habitacion_servicio SET estado_id = 4
                        WHERE id_habitacion_servicio = ?;");

                        $actulizar_estado -> bind_param('i', $idH);
                        $actulizar_estado -> execute();

                        if(!$actulizar_estado -> error){
            
                            //Registra en la BITACORA la accion realizada
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha_bitacor=date('Y-m-d H:i:s',time());
                            $objeto = 11;
                            $accione = "Eliminación de una reservación";
                            $descpc = "Eliminación de reservcaion N°" .$id_reserva;
                            //include("../modelo/conexionbd.php");
                            $llamar_bi = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                            $llamar_bi->bind_Param("sssii", $accione, $descpc, $fecha_bitacor, $user_id, $objeto);
                            $llamar_bi->execute();
                            
                            $res['msj'] = "Reservacion eliminada correctamente";
                        } else {
                            $res['msj'] = "Se produjo un error al momento de eliminar la reservación";
                            $res['error'] = true;
                        }
                    }
                }
        } else {
            $res['msj'] = "No se envió el id de la reservacion a eliminar";
            $res['error'] = true;
        }

    break;
       default:
        //echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($res);