<?php
include "../modelo/conexionbd.php";
$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    case 'registrarCampingNE': //realizar una reservacion para camping
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];//fecha de entrada
        $salida = $_POST['salida'];//fecha salida
        $area = $_POST['area'];
        $precioA = $_POST['precioAN'];
        $precioN = $_POST['precioNN'];
        $precioA = $_POST['precioAE'];
        $precioN = $_POST['precioNE'];
        $adultoN = $_POST['AdultN'];//cantidad de adulto nacional
        $ninoN = $_POST['NinoN'];//cantidad de niños nacional
        $adultoE = $_POST['AdultE'];//cantidad de adulto extranjero
        $ninoE = $_POST['NinoE'];//cantidad de niños extranjero;
        $total2 = $_POST['total2'];
        $id_usuario = $_POST['id_usuario'];
        $usuario_actual = $_POST['usuario_actual'];
        $estado_eliminado =1;
        //$estado_habitacion = 'DISPONIBLE';
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
        

        if( empty($_POST['reservacion']) || empty($_POST['entrada'])
            || empty($_POST['area']) || empty($_POST['precioAN']) ||empty($_POST['precioNN']) || empty($_POST['precioAE']) ||empty($_POST['precioNE'])
            || empty($_POST['salida']) || empty($_POST['AdultN']) || empty($_POST['NinoN']) || empty($_POST['AdultE']) || empty($_POST['NinoE'])
            || empty($_POST['total2'])|| empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                $id_cliente=1;
                $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                VALUES (?,?,?,?,?,?,?,?,?,?);");
                $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                        $canti_adultos = $adultoN + $adultoE;
                        $canti_ninos = $ninoN + $ninoE;
                        //inserta en la tabla detalle de reservacion
                        $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                        total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                        VALUES (?,?,?,?,?,?,?,?,?,?);");
                        $insert->bind_param('iiiiiissss', $idr,$area,$canti_adultos, $canti_ninos,$total2,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();

                        //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                        $captura_area = $conn->prepare("SELECT breaitacion_id FROM tbl_detalle_reservacion
                        WHERE habitacion_id = ?;");
                        $captura_area->bind_Param("s", $area);
                        $captura_area->execute();
                        $captura_area->bind_result($idA);

                        if($captura_area->affected_rows){
                            $existe_area = $captura_area->fetch();

                            while ($captura_area->fetch()) {
                                $id_area = $idA;
                            }
                            if($existe_area){
                                $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                WHERE id_habitacion_servicio = '$idA'";

                                $result=$conn->query($actulizar_estado);
                                if ($result == 1) {
                                    $res['msj'] = "Reservación se realizo Correctamente";
                                } else {
                                    $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                    $res['error'] = true;
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
    case 'actualizarCamping':
        if(isset($_POST['id_reservacion']) && isset($_POST['reservacion']) &&
            isset($_POST['entrada']) && isset($_POST['salida'])){

                $id_reservacion=$_POST['id_reservacion'];
                $reservacion=$_POST['reservacion'];
                $entrada=$_POST['entrada'];
                $salida = $_POST['salida'];
                

                $actualizarcamping = "UPDATE tbl_detalle_reservacion dr
                                    inner join tbl_reservaciones r
                                    on dr.reservacion_id = r.id_reservacion
                                    set 
                                    r.fecha_entrada='$entrada', r.fecha_salida='$salida' 
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
    case 'eliminarCamping':
        if (isset($_POST['idreser'])) {
            $id_reserva = $_POST['idreser'];
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
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);