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

switch ($action) {


    case 'registrarSolicitud':
        $nombreCompleto = $_POST['nombreCompleto'];
        $identidad = $_POST['identidad'];
        $telefono = $_POST['telefono'];
        $recibo = $_POST['n_recibo'];
        $tipo_nac = $_POST['tipo_nac'];
        $tipo = $_POST['tipo_sol'];

        $usuario_actual = $_POST['usuario_actual'];

        //Fecha ACTUAL del sistema
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        $fecha_actual = new DateTime($fecha);

        if (
            empty($_POST['nombreCompleto']) || empty($_POST['identidad'])  || empty($_POST['telefono'])
            || empty($_POST['n_recibo']) || empty($_POST['tipo_nac']) || empty($_POST['tipo_sol'])
        ) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

            try {



                //consulta para traer el precio de la solicitud
                if (isset($_POST['tipo_sol'])) {
                    $tiposolicitud = $_POST['tipo_sol'];

                    // select para traer el precio de la solicitud
                    $preciosolicitud = mysqli_query($conn, "  SELECT id_tipo_solicitud,tipo,precio_solicitud FROM tbl_tipo_solicitud 
                    WHERE id_tipo_solicitud= $tiposolicitud");
                    $resultado = mysqli_fetch_array($preciosolicitud);

                    if ($resultado > 0) {
                        $tot_a_pagar = $resultado['precio_solicitud'];
                    }
                }

                // select para ver si existe el cliente de acuerdo al numero de identidad
                $consult = mysqli_query($conn, "SELECT id_cliente,nombre_completo,telefono,nac.nacionalidad 
                        FROM tbl_clientes cli JOIN tbl_tipo_nacionalidad nac 
                        ON cli.tipo_nacionalidad=nac.id_tipo_nacionalidad WHERE identidad = $identidad");
                $result = mysqli_fetch_array($consult);


                if ($result > 0) {

                    //capturamos el id del cliente
                    $id_clientecap = $result['id_cliente'];


                    //ver si se repite el numero de deposito
                    $consulta_id = mysqli_query($conn, "SELECT id_solicitud,recibo FROM tbl_solicitudes   
                    WHERE recibo=$recibo");
                    $resultado_deposito = mysqli_fetch_array($consulta_id);
                    if ($resultado_deposito > 0) {
                        //$deposito_capturado = $$resultado_deposito['recibo'];
                        $res['msj'] = "Por favor verifique el número de depósito ingresado";
                        $res['error'] = true;
                    } else {

                        //consulta para traer el id del estado de la solicitud
                        $consulta_id = mysqli_query($conn, "SELECT id_estatus_solicitud,estatus FROM tbl_estatus_solicitud
                            WHERE estatus = 'PROCESO'");
                        $resultado_estado = mysqli_fetch_array($consulta_id);
                        if ($resultado_estado > 0) {
                            $estado_capturado = $resultado_estado['id_estatus_solicitud'];
                        }

                        //consulta para el id del usuario
                        $consulta_id = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                            WHERE nombre_usuario= '$usuario_actual'");
                        $resultado = mysqli_fetch_array($consulta_id);
                        if ($resultado > 0) {
                            //capturamos el id del usuario
                            $id_usercap = $resultado['id_usuario'];

                            //Insertamos en la tabla solicitudes
                            $sql = $conn->prepare("INSERT INTO tbl_solicitudes(fecha_solicitud,recibo,total,cliente_id,usuario_id,estatus_solicitud,
                                tipo_solicitud,creado_por,fecha_creacion,modificado_por,fecha_modificacion) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                            $sql->bind_param(
                                "ssiiiiissss",
                                $fecha,
                                $recibo,
                                $tot_a_pagar,
                                $id_clientecap,
                                $id_usercap,
                                $estado_capturado,
                                $tipo,
                                $usuario_actual,
                                $fecha,
                                $usuario_actual,
                                $fecha

                            );
                            $sql->execute();
                            if ($sql->error) {
                                $res['msj'] = "Se produjo un error al momento de registrar la solicitud";
                                $res['error'] = true;
                            } else {
                                $res['msj'] = "Solicitud Registrada Correctamente";
                            }
                        }
                    }

                    //si no existe el cliente
                } else {


                    //ver si se repite el numero de deposito
                    $consulta_id = mysqli_query($conn, "SELECT id_solicitud,recibo FROM tbl_solicitudes   
                    WHERE recibo=$recibo");
                    $resultado_deposito = mysqli_fetch_array($consulta_id);
                    if ($resultado_deposito > 0) {

                        $res['msj'] = "Por favor verifique el número de deposito ingresado";
                        $res['error'] = true;
                    } else {
                        $estado_elim = 1;

                        $sql = $conn->prepare("INSERT INTO tbl_clientes(nombre_completo,identidad,telefono,tipo_nacionalidad,estado_eliminado,
                            creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                        VALUES (?,?,?,?,?,?,?,?,?)");
                        $sql->bind_param(
                            "sssiissss",
                            $nombreCompleto,
                            $identidad,
                            $telefono,
                            $tipo_nac,
                            $estado_elim,
                            $usuario_actual,
                            $fecha,
                            $usuario_actual,
                            $fecha
                        );
                        $sql->execute();
                        if ($sql->error) {
                            $res['msj'] = "Se produjo un error al momento de registrar el cliente";
                            $res['error'] = true;
                        } else {


                            // select para ver si existe el cliente registrado de acuerdo al numero de identidad
                            $consult = mysqli_query($conn, "SELECT id_cliente,nombre_completo,telefono,nac.nacionalidad 
                        FROM tbl_clientes cli JOIN tbl_tipo_nacionalidad nac 
                        ON cli.tipo_nacionalidad=nac.id_tipo_nacionalidad WHERE identidad = $identidad");
                            $result = mysqli_fetch_array($consult);

                            if ($result) {
                                $cliente_capturado = $result['id_cliente'];

                                //Capturar el id_usuario 
                                $consulta_id = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                            WHERE nombre_usuario= '$usuario_actual'");
                                $resultado = mysqli_fetch_array($consulta_id);

                                if ($resultado) {
                                    $id_usercap = $resultado['id_usuario'];
                                }

                                //consulta para traer el id del estado de la solicitud
                                $consulta_id = mysqli_query($conn, "SELECT id_estatus_solicitud,estatus FROM tbl_estatus_solicitud
                                WHERE estatus = 'PROCESO'");
                                $resultado_estado = mysqli_fetch_array($consulta_id);
                                if ($resultado_estado > 0) {
                                    $estado_capturado = $resultado_estado['id_estatus_solicitud'];
                                }
                                //insertamos en tbl_solicitudes

                                $sql = $conn->prepare("INSERT INTO tbl_solicitudes(fecha_solicitud,recibo,total,cliente_id,usuario_id,
                                                   estatus_solicitud,
                                                   tipo_solicitud,creado_por,fecha_creacion,modificado_por,fecha_modificacion) 
                                                   VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                                $sql->bind_param(
                                    "ssiiiiissss",
                                    $fecha,
                                    $recibo,
                                    $tot_a_pagar,
                                    $cliente_capturado,
                                    $id_usercap,
                                    $estado_capturado,
                                    $tipo,
                                    $usuario_actual,
                                    $fecha,
                                    $usuario_actual,
                                    $fecha
                                );
                                $sql->execute();
                                if ($sql->error) {
                                    $res['msj'] = "Se produjo un error al momento de registrar la solicitud";
                                    $res['error'] = true;
                                } else {
                                    $res['msj'] = "Solicitud Registrada Correctamente";
                                }
                            }
                        }
                    }
                }



                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        break;
    case 'actualizarSolicitud':

        if (
            isset(($_POST['id_solicitud'])) && isset($_POST['recibo']) && isset($_POST['estatus_solicitud']) && isset($_POST['tipo_solicitud'])
            && isset($_POST['fecha_creacion'])
        ) {
            $id_solicitud = (int)$_POST['id_solicitud'];
            $nuevo_recibo = $_POST['recibo'];
            $estatus_solicitud = $_POST['estatus_solicitud'];
            $tipo_solicitud = $_POST['tipo_solicitud'];

            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());


                //consulta para traer el precio de la solicitud
                if (isset($_POST['tipo_solicitud'])) {
                    $tiposolicitud = $_POST['tipo_solicitud'];

                    $preciosolicitud = mysqli_query($conn, "  SELECT id_tipo_solicitud,tipo,precio_solicitud FROM tbl_tipo_solicitud 
        WHERE id_tipo_solicitud= $tiposolicitud");
                    $resultado = mysqli_fetch_array($preciosolicitud);
                    if ($resultado > 0) {
                        $tot_a_pagar = $resultado['precio_solicitud'];
                    }
                }

                $sql = "UPDATE tbl_solicitudes SET recibo='$nuevo_recibo', total= $tot_a_pagar, estatus_solicitud=$estatus_solicitud , tipo_solicitud =  $tipo_solicitud,
            modificado_por='$usuario_actual', fecha_modificacion='$fecha'
           
            WHERE id_solicitud=" . $id_solicitud;

                $resultado = $conn->query($sql);

                if ($resultado > 0) {

                    $res['msj'] = "La solicitud se ha editado correctamente";
                } else {
                    $res['msj'] = "Se produjo un error al momento de editar la solicitud ";
                    $res['error'] = true;
                }
            
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;

    case 'eliminarSolicitud':
        if (isset($_POST['id_solicitud'])) {
            $id_solicitud = $_POST['id_solicitud'];

            $sql = " DELETE FROM tbl_solicitudes WHERE id_solicitud = " . $id_solicitud;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "La solicitud se ha eliminado correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar la solicitud";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
        break;


    default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
