<?php
include "../modelo/conexionbd.php";

if()

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 

    case 'obtenerCliente':
        $cliente = $_GET['cliente'];
        $sql = "SELECT id_cliente, nombre_completo
        FROM tbl_clientes WHERE nombre_completo = '" . $cliente . "'";
        $result = $conn->query($sql);
        $cliente_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($cliente_db, $row);
        }
        $res['nombre_completo'] = $cliente_db;
    break;
    case 'registrarCliente':
        $identidad= $_POST['identidad'];
        $nombre=$_POST['nombre_cliente'];
        $nacionalidad=$_POST['nacionalidad'];                 
        $telefono=$_POST['telefono'];
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());

        if(empty($_POST['identidad'])|| empty($_POST['nombre_cliente'])||
            empty($_POST['nacionalidad'])|| empty($_POST['telefono'])|| empty($_POST['usuario_actual'])){
            
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;

        }else{
            try{
                $insertar=$conn->prepare("INSERT INTO `tbl_clientes`(nombre_completo, identidad, telefono, tipo_nacionalidad, 
                                creado_por,fecha_creacion, modificado_por, fecha_modificacion)
                                VALUES (?,?,?,?,?,?,?,?);");
                $insertar->bind_param('sssissss', $nombre,$identidad,$telefono,$nacionalidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
    case 'registrarHotel': //realizar una reservacion
        $cliente = $_POST['cliente'];
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];
        $habitacion = $_POST['habitacion'];
        $localidad = $_POST['localidad'];
        $precioA = $_POST['precioAdulto'];
        $precioN = $_POST['precioNiños'];
        $salida = $_POST['salida'];
        $personas = $_POST['personas'];
        $cant_habitacion = $_POST['cant_habitacion'];
        $total = $_POST['pago'];
        $usuario_actual = $_POST['usuario_actual'];
        $user=4;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
        

        if(empty($_POST['cliente'])|| empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['habitacion'])
            || empty($_POST['localidad']) ||empty($_POST['precioAdulto']) ||empty($_POST['precioNiños'])
            || empty($_POST['salida']) || empty($_POST['personas']) || empty($_POST['cant_habitacion'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                
                $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                                        localidad_id,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?);");
                $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$cliente,$user,$localidad,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                        $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona,inventario_id,
                                                cantidad_articulo,precio_articulo,total_pago,
                                                creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
                        $insert->bind_param('iiiiiiiiissss', $idr,$habitacion,$personas,$inventario,$cantiA,$precioArti,$precioA,$precioN,$total,
                                                            $usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();
                    }
                }
                if ($insert->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar la reservación";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "la Reservación se Registro Correctamente";
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    break;
    case 'actualizarHotel':
        if(isset($_POST['id_reservacion']) && isset($_POST['reservacion']) &&
            isset($_POST['entrada']) && isset($_POST['salida'])){

                $id_reservacion=$_POST['id_reservacion'];
                $reservacion=$_POST['reservacion'];
                $entrada=$_POST['entrada'];
                $salida = $_POST['salida'];

                $actualizarhotel = "UPDATE tbl_reservaciones SET fecha_reservacion='$reservacion',
                                    fecha_entrada='$entrada', fecha_salida='$salida'
                                    WHERE id_reservacion=".$id_reservacion;
                
                $resultado=$conn->query($actualizarhotel);
                if ($resultado == 1) {
                    $res['msj'] = "Reservación se Edito Correctamente";
                } else {
                    $res['msj'] = "Se produjo un error al momento de Editar la reservación ";
                    $res['error'] = true;
                }
            }else{
                $res['msj'] = "Las variables no estan definidas";
                $res['error'] = true;
            }
    break;
    case 'eliminarHotel':
        if (isset($_POST['id_reservacion'])) {
            $id_reservacion = $_POST['id_reservacion'];
            $sql = "UPDATE tbl_reservaciones SET estado_eliminar = 0 WHERE id_reservacion = " . $id_reservacion;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Reservacion Eliminada  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar la reservación";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id de la reservacion a eliminar";
            $res['error'] = true;
        }

    break;
    default:
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);