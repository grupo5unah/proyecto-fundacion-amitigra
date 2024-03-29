<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {


    case 'registrarEstadoSolicitud':
        $estadoSolicitud = $_POST['estadoSolicitud'];
        $usuario_actual = $_POST['usuario_actual'];

        //Fecha ACTUAL del sistema
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());


        if (
            empty($_POST['estadoSolicitud'])
        ) {
            $res['msj'] = 'Es necesario rellenar este campo';
            $res['error'] = true;
        } else {

            try {

                // select para ver si existe el estado en la Base de datos
                $consult = mysqli_query($conn, "SELECT estatus
                FROM tbl_estatus_solicitud
                WHERE estatus = '$estadoSolicitud' and estado_eliminado=1 ");
                $result = mysqli_fetch_array($consult);


                if ($result > 0) {
                    //mandara un mensaje que ya existe el tipo de dato en la BD 
                    $res['msj'] = "Este estado ya existe en la base de datos";
                    $res['error'] = true;
                } else {
                    $estado_elim = 1;

                    $sql = $conn->prepare("INSERT INTO tbl_estatus_solicitud(estatus,estado_eliminado,creado_por,fecha_creacion,
                           modificado_por,fecha_modificacion)
                    VALUES (?,?,?,?,?,?)");
                    $sql->bind_param(
                        "sissss",
                        $estadoSolicitud,
                        $estado_elim,
                        $usuario_actual,
                        $fecha,
                        $usuario_actual,
                        $fecha
                    );
                    $sql->execute();
                    if ($sql->error) {
                        $res['msj'] = "Se produjo un error al momento de registrar el estado";
                        $res['error'] = true;
                    } else {
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                                         WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Creación de estado de solicitud";
                            $descripcion = "Se ha registrado una nuevo estado de solicitud";
                            $objeto = 23;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                        $res['msj'] = "El estado de solicitud se ha registrado correctamente";
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        break;
    case 'actualizarEstSolicitud':

        if (
            isset(($_POST['id_estatus_solicitud'])) && isset($_POST['estatus'])

        ) {
            $id_estatus_solicitud = (int)$_POST['id_estatus_solicitud'];
            $estatus = $_POST['estatus'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());


            $sql = "UPDATE tbl_estatus_solicitud SET estatus='$estatus', modificado_por='$usuario_actual',
            fecha_modificacion='$fecha'
           
            WHERE id_estatus_solicitud=" . $id_estatus_solicitud;

            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                //select para traer el id del usuario
                $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
     WHERE nombre_usuario='$usuario_actual'");
                $resulta = mysqli_fetch_array($consulid);
                if ($resulta > 0) {
                    $id_user = $resulta['id_usuario'];

                    date_default_timezone_set("America/Tegucigalpa");
                    $fechaAccion = date("Y-m-d H:i:s", time());

                    $accion = "Actualización de estado de solicitud";
                    $descripcion = "Se ha actualizado un estado de solicitud";
                    $objeto = 23;
                    include "../modelo/conexionbd.php";

                    //INSERTAR LA ACCION EN BITACORA
                    $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                    $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                    $bitacora->execute();
                }
                $res['msj'] = "Estado de solicitud editado exitosamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de editar el estado de solicitud ";
                $res['error'] = true;
            }
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;

    case 'eliminarEstadoSolicitud':
        if (isset($_POST['id_estatus_solicitud'])) {
            $id_estatus_solicitud = $_POST['id_estatus_solicitud'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $estado_eliminar = 0;

            $sql = "UPDATE tbl_estatus_solicitud SET estado_eliminado= $estado_eliminar, modificado_por='$usuario_actual', fecha_modificacion='$fecha'
             WHERE id_estatus_solicitud = " . $id_estatus_solicitud;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                //select para traer el id del usuario
                $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                           WHERE nombre_usuario='$usuario_actual'");
                $resulta = mysqli_fetch_array($consulid);
                if ($resulta > 0) {
                    $id_user = $resulta['id_usuario'];

                    date_default_timezone_set("America/Tegucigalpa");
                    $fechaAccion = date("Y-m-d H:i:s", time());

                    $accion = "Eliminación de estado de solicitud";
                    $descripcion = "Se ha eliminado un estado de solicitud";
                    $objeto = 23;
                    include "../modelo/conexionbd.php";

                    //INSERTAR LA ACCION EN BITACORA
                    $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                    $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                    $bitacora->execute();
                }
                $res['msj'] = "Estado de solicitud eliminado exitosamente";
            } else {
                //select para traer el id del usuario
                $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                   WHERE nombre_usuario='$usuario_actual'");
                $resulta = mysqli_fetch_array($consulid);
                if ($resulta > 0) {
                    $id_user = $resulta['id_usuario'];

                    date_default_timezone_set("America/Tegucigalpa");
                    $fechaAccion = date("Y-m-d H:i:s", time());

                    $accion = "Eliminación de estado de solicitud";
                    $descripcion = "Se ha intentado eliminar un estado de solicitud";
                    $objeto = 23;
                    include "../modelo/conexionbd.php";

                    //INSERTAR LA ACCION EN BITACORA
                    $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                    $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                    $bitacora->execute();
                }
                $res['msj'] = "Se produjo un error al momento de eliminar el estado de solicitud";
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
