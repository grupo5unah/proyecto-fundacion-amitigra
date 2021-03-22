<?php
include "../modelo/conexionbd.php";

//BUSCAR CLIENTE
 if($_POST['action'] == 'buscarCliente'){
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

 //REGISTRAR CLIENTE
//  if($_POST['action'] == 'agregarCliente'){
//     $identidad = strval($_POST['identidad']);
//     $nomCliente = $_POST['cliente'];
//     $nacionalidad = $_POST['nacionalidad'];
//     $telefono = strval($_POST['telefono']);
//     $estado = 1;
//     $usuario_actual = $_POST['usuario_actual'];
//     date_default_timezone_set("America/Tegucigalpa");
//     $fecha=date('Y-m-d H:i:s',time());
    

//     $insert=mysqli_query($conn,"INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, estado_eliminado
//                             creado_por,fecha_creacion, modificado_por, fecha_modificacion) 
//                             VALUES ('$nomCliente','$identidad','$telefono','$nacionalidad','$estado',
//                                     '$usuario_actual','$fecha','$usuario_actual','$fecha')");
//     if($insert){
//         $idCliente = mysqli_insert_id($conn);
//         $msg=$idCliente;
//     }else{
//         $msg='error desde el controlador';
//     }
//     mysqli_close($conn);
//     echo $msg;
//     exit;
//  }

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
    // case 'registrarHotel': //realizar una reservacion para hotel
    //     $cliente = $_POST['cliente'];
    //     $identidad = $_POST['identidad'];
    //     $nacionalidad = $_POST['nacionalidad'];
    //     $telefono = $_POST['telefono'];
    //     $reservacion = $_POST['reservacion']; //fecha de reservacion
    //     $entrada = $_POST['entrada'];//fecha de entrada
    //     $habitacion = $_POST['habitacion'];
    //     $localidad = $_POST['localidad'];
    //     $precioA = $_POST['precioAdulto'];
    //     $precioN = $_POST['precioNiños'];
    //     $salida = $_POST['salida'];//fecha salida
    //     $personas = $_POST['personas'];
    //     $niños = $_POST['niños'];
    //     $cant_habitacion = $_POST['cant_habitacion'];
    //     $total = $_POST['pago'];
    //     $usuario_actual = $_POST['usuario_actual'];
    //     $id_usuario = $_POST['id_usuario'];
    //     $estado_eliminado =1;
    //     date_default_timezone_set("America/Tegucigalpa");
    //     $fecha=date('Y-m-d H:i:s',time());
        

    //     if(empty($_POST['cliente'])|| empty($_POST['identidad'])||empty($_POST['nacionalidad'])||
    //         empty($_POST['telefono'])|| empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['habitacion'])
    //         || empty($_POST['localidad']) ||empty($_POST['precioAdulto']) ||empty($_POST['precioNiños'])
    //         || empty($_POST['salida']) || empty($_POST['personas']) || empty($_POST['niños']) || empty($_POST['cant_habitacion'])
    //         || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
    //             $res['msj'] = 'Todos los campos son obligatorios';
    //             $res['error'] = true;
    //     }else{
    //         try{
    //             //VERIFICAR E INSERTAR CLIENTE
    //             $verificar = $conn->prepare("SELECT id_cliente FROM tbl_clientes 
    //                                             WHERE identidad=?;");
    //             $verificar->bind_Param("s", $identidad);
    //             $verificar->execute();
    //             $verificar->bind_result($id);

    //             if($verificar->affected_rows){
    //                 $existe_cliente = $verificar->fetch();

    //                 while ($verificar->fetch()) {
    //                    $id_cliente = $id;
    //                 }
    //                 if($existe_cliente){
    //                     //require "../modelo/conexionbd.php";
    //                     //insercion en la tabla reservaciones
    //                     $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
    //                     localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
    //                     VALUES (?,?,?,?,?,?,?,?,?,?);");
    //                     $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id,$id_usuario,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
    //                     $inserta->execute();

    //                     //se captura el id de la tabla de reservaciones
    //                     $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
    //                                     WHERE fecha_reservacion= ?;");
    //                     $capturar_reserva->bind_Param("s", $reservacion);
    //                     $capturar_reserva->execute();
    //                     $capturar_reserva->bind_result($idr);

    //                     if($capturar_reserva->affected_rows){
    //                         $existe_reservacion = $capturar_reserva->fetch();

    //                         while ($capturar_reserva->fetch()) {
    //                             $id_reserva = $idr;
    //                         }
    //                         if($existe_reservacion){
    //                             //require "../modelo/conexionbd.php";

    //                             //inserta en la tabla detalle de reservacion
    //                             $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
    //                                                     total_pago,estado_eliminar,
    //                                                     creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
    //                                                     VALUES (?,?,?,?,?,?,?,?,?,?);");
    //                             $insert->bind_param('iiiiiissss', $idr,$habitacion,$personas, $niños,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
    //                             $insert->execute();
    //                             //actualizar estado de habitacion
    //                             /*$actualizarH ="UPDATE tbl_habitacion_servicio SET estado_id = 2
    //                             WHERE id_habitacion_servicio = .$habitacion";
    //                             $actualizarH=$conn->query($actualizarH);*/
    //                             if ($insert->error) {
    //                                 $res['msj'] = "Se produjo un error al momento de registrar la reservación";
    //                                 $res['error'] = true;
    //                             } else {
    //                                 $res['msj'] = "la Reservación se Registro Correctamente";
    //                             }
                                
    //                         }
    //                     }
                            
                        
    //                 }else{
    //                     //INSERTAR A LA TABLA CLIENTES
    //                     $insertar=$conn->prepare("INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, creado_por,
    //                                             fecha_creacion, modificado_por, fecha_modificacion ) VALUES (?,?,?,?,?,?,?,?);");
    //                     $insertar->bind_param('sssissss', $cliente,$identidad,$telefono,$nacionalidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
    //                     $insertar->execute();
                        
    //                     //CAPTURAR EL ID DEL CLIENTE
    //                     $capt_cliente = $conn->prepare("SELECT id_cliente FROM tbl_clientes 
    //                                             WHERE identidad=?;");
    //                     $capt_cliente->bind_Param("s", $identidad);
    //                     $capt_cliente->execute();
    //                     $capt_cliente->bind_result($idc);

    //                     if($capt_cliente->affected_rows){
    //                         $existe_client = $capt_cliente->fetch();
    //                         while ($capt_cliente->fetch()) {
    //                             $id_cliente = $idc;
    //                         }

    //                         if($existe_client){

    //                             //INSERCION EN LA TABLA RESERVACIONES
    //                             $insert=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
    //                             localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
    //                             VALUES (?,?,?,?,?,?,?,?,?,?);");
    //                             $insert->bind_param('sssiiissss', $reservacion, $entrada,$salida,$idc,$id_usuario,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
    //                             $insert->execute();

    //                             //se captura el id de la tabla de reservaciones
    //                             $capt_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
    //                                             WHERE fecha_reservacion= ?;");
    //                             $capt_reserva->bind_Param("s", $reservacion);
    //                             $capt_reserva->execute();
    //                             $capt_reserva->bind_result($idre);

    //                             if($capt_reserva->affected_rows){
    //                                 $existe_reserva = $capt_reserva->fetch();

    //                                  while ($capt_reserva->fetch()) {
    //                                  $id_reserva = $idre;
    //                                 }
    //                                 if($existe_reserva){
    //                                     //require "../modelo/conexionbd.php";

    //                                     //inserta en la tabla detalle de reservacion
    //                                     $inser=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
    //                                                             total_pago,estado_eliminar,
    //                                                             creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
    //                                                             VALUES (?,?,?,?,?,?,?,?,?,?);");
    //                                     $inser->bind_param('iiiiiissss', $idre,$habitacion,$personas, $niños,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
    //                                     $inser->execute();
    //                                     //actualizar estado de habitacion
    //                                     /*$actualizarH ="UPDATE tbl_habitacion_servicio SET estado_id = 2
    //                                     WHERE id_habitacion_servicio = .$habitacion";
    //                                     $actualizarH=$conn->query($actualizarH);*/
    //                                     if ($inser->error) {
    //                                         $res['msj'] = "Se produjo un error al momento de registrar la reservación";
    //                                         $res['error'] = true;
    //                                     } else {
    //                                         $res['msj'] = "la Reservación se Registro Correctamente";
    //                                     }
                                        
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }                         
                                        
    //         }catch(Exception $e){
    //             echo $e->getMessage();
    //         }
    //     }
    // break;
    // case 'actualizarHotel':
    //     if(isset($_POST['id_reservacion']) && isset($_POST['reservacion']) &&
    //         isset($_POST['entrada']) && isset($_POST['salida'])&& isset($_POST['adultos'])
    //         && isset($_POST['ninos'])&& isset($_POST['pago'])){

    //             $id_reservacion=$_POST['id_reservacion'];
    //             $reservacion=$_POST['reservacion'];
    //             $entrada=$_POST['entrada'];
    //             $salida = $_POST['salida'];
    //             $cant_adultos = $_POST['adultos'];
    //             $cant_ninos = $_POST['ninos'];
    //             $totalPagar = $_POST['pago'];
                

    //             $actualizarhotel = "UPDATE tbl_detalle_reservacion dr
    //                                 inner join tbl_reservaciones r
    //                                 on dr.reservacion_id = r.id_reservacion
    //                                 inner join tbl_clientes c
    //                                 on r.cliente_id = c.id_cliente
    //                                 inner join tbl_habitacion_servicio hs
    //                                 on dr.habitacion_id = hs.id_habitacion_servicio
    //                                 inner join tbl_estado e
    //                                 on hs.estado_id = e.id_estado
    //                                 set  r.fecha_reservacion='$reservacion', 
    //                                 r.fecha_entrada='$entrada', r.fecha_salida='$salida',
    //                                 dr.cantidad_persona='$cant_adultos', 
    //                                 dr.cantidad_ninos='$cant_ninos',dr.total_pago='$totalPagar'
    //                                 WHERE id_reservacion=".$id_reservacion;
                
    //             $resultado=$conn->query($actualizarhotel);
    //             if ($resultado == 1) {
    //                 $res['msj'] = "Reservación se Edito Correctamente";
    //             } else {
    //                 $res['msj'] = "Se produjo un error al momento de Editar la reservación ";
    //                 $res['error'] = true;
    //             }
    //         }else{
    //             $res['msj'] = "Las variables no estan definidas";
    //             $res['error'] = true;
    //         }
    // break;
    // case 'eliminarHotel':
    //     if (isset($_POST['id_reservacion'])) {
    //         $id_reservacion = $_POST['id_reservacion'];
    //         $sql = "UPDATE tbl_detalle_reservacion SET estado_eliminar = 0 WHERE id_detalle_reservacion = " . $id_reservacion;
    //         $resultado = $conn->query($sql);
    //         if ($resultado == 1) {
    //             $res['msj'] = "Reservacion Eliminada  Correctamente";
    //         } else {
    //             $res['msj'] = "Se produjo un error al momento de eliminar la reservación";
    //             $res['error'] = true;
    //         }
    //     } else {
    //         $res['msj'] = "No se envió el id de la reservacion a eliminar";
    //         $res['error'] = true;
    //     }

    // break;
    default:
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);