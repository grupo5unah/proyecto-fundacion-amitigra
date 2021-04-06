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
    case 'eliminarReservacion':
        if (isset($_POST['id_reservacion'])) {
            $id_reserva = $_POST['id_reservacion'];
            $sql = "UPDATE tbl_detalle_reservacion SET estado_eliminado = 0 WHERE id_detalle_reservacion = " .$id_reserva;
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
        //echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
echo json_encode($res);