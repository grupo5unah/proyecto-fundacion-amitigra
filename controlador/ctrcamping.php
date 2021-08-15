<?php
include_once "../modelo/conexionbd.php";
//INSERTAR PARA CAMPING

if(isset($_POST['action']) == 'registroCamping'){
    $conte = json_decode($_POST['conteCamping']);
    $fecha_reservacion = $_POST['fecha_reservacion'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $idCliente = $_POST['idcliente'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];
    
 
    if(!empty($_POST['conteCamping']) ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
            $camping = 'CAMPING';
            $estado_eliminado = 1;
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $entrar = $fecha_entrada ." ".date('H:i:s',time());
            $salir = $fecha_salida ." ".date('H:i:s',time());

            include_once ("../modelo/conexionbd.php");
            $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
            tipo_reservacion,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);");
            $inserta->bind_param('sssiisissss', $fecha_reservacion, $entrar,$salir,$idCliente,$id_usuario,$camping,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
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
                                
                    //inserta en la tabla detalle de reservacion
                    $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                    inventario_id, cantidad_articulo,total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?);");
                    foreach($conte as $valor){
                        $id_area = $valor->areaN;
                        $adultos = $valor->adulto;
                        $ninos = $valor->nino;
                        $arti = $valor->articulo;
                        $cantart = $valor->cantarticulo;
                        $total = $valor->totalnc;

                        $insert->bind_param('iiiiiiiissss', $idr,$id_area,$adultos, $ninos,$arti,$cantart,
                        $total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();
                    }
                    
                   
                    if(!$insert -> error){

                        //Registra en la BITACORA la accion realizada
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha_bitacora=date('Y-m-d H:i:s',time());
                        $objeto = 11;
                        $acciones = "Reservación de hotel";
                        $descp = "Reservación de camping realizada correctamente";
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
