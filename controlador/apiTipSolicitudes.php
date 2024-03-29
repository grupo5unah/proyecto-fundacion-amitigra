<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {


    case 'registrarTipSolicitud':
        $tipoSolicitud = $_POST['tipoSolicitud'];
        $preciosolicitud = $_POST['preciosolicitud'];
        $usuario_actual = $_POST['usuario_actual'];

        //Fecha ACTUAL del sistema
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());


        if (
            empty($_POST['tipoSolicitud']) || empty($_POST['preciosolicitud'])
        ) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

            try {

                // select para ver si existe el tipo de solicitud en la Base de datos

                $consult = mysqli_query($conn, " SELECT id_tipo_solicitud, tipo 
                FROM tbl_tipo_solicitud 
                WHERE tipo = '$tipoSolicitud' and estado_eliminado=1 ");
                $result = mysqli_fetch_array($consult);


                if ($result > 0) {
                    //mandara un mensaje que ya existe el tipo de dato en la BD 

                    $res['msj'] = "Este tipo de solicitud ya existe en la base de datos";
                    $res['error'] = true;
                } else {
                    $estado_elim = 1;

                    $sql = $conn->prepare("INSERT INTO tbl_tipo_solicitud(tipo,precio_solicitud,estado_eliminado,creado_por,fecha_creacion,
                           modificado_por,fecha_modificacion)
                    VALUES (?,?,?,?,?,?,?)");
                    $sql->bind_param(
                        "siissss",
                        $tipoSolicitud,
                        $preciosolicitud,
                        $estado_elim,
                        $usuario_actual,
                        $fecha,
                        $usuario_actual,
                        $fecha
                    );
                    $sql->execute();
                    if ($sql->error) {
                        $res['msj'] = "Se produjo un error al momento de registrar el tipo de solicitud";
                        $res['error'] = true;
                    } else {
                        //Insertar en bitacora
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                                         WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Creación de tipo de solicitud";
                            $descripcion = "Se ha registrado un nuevo tipo de solicitud";
                            $objeto = 36;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                        $res['msj'] = "El tipo de Solicitud se ha registrado correctamente";
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        break;
    case 'actualizarTipSolicitud':

        if (
            isset(($_POST['id_tipo_solicitud'])) && isset($_POST['tipo']) && isset($_POST['precio_solicitud'])

        ) {
            $id_tipo_solicitud = (int)$_POST['id_tipo_solicitud'];
            $tipo = $_POST['tipo'];
            $precio_solicitud = $_POST['precio_solicitud'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());


            $sql = "UPDATE tbl_tipo_solicitud SET tipo='$tipo' , precio_solicitud =  $precio_solicitud, modificado_por='$usuario_actual',
            fecha_modificacion='$fecha'
           
            WHERE id_tipo_solicitud=" . $id_tipo_solicitud;

            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                             //Insertar en bitacora
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                                         WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Actualización de tipo de solicitud";
                            $descripcion = "Se ha actualizado un tipo de solicitud";
                            $objeto = 36;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }

                $res['msj'] = "Tipo de solicitud actualizada con éxito";
            } else {
                $res['msj'] = "Se produjo un error al momento de editar el tipo de solicitud ";
                $res['error'] = true;
            }
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;

    case 'eliminarTipSolicitud':
        if (isset($_POST['id_tipo_solicitud'])) {
            $id_tipo_solicitud = $_POST['id_tipo_solicitud'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $estado_eliminar = 0;

            $sql = "UPDATE tbl_tipo_solicitud SET estado_eliminado= $estado_eliminar, modificado_por='$usuario_actual', fecha_modificacion='$fecha'
             WHERE id_tipo_solicitud = " . $id_tipo_solicitud;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                             //Insertar en bitacora
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                                         WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Eliminación de tipo de solicitud";
                            $descripcion = "Se ha eliminado un tipo de solicitud";
                            $objeto = 36;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                $res['msj'] = "Tipo solicitud eliminada con éxito";
            } else {
                                //Insertar en bitacora
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                                         WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Eliminación de tipo de solicitud";
                            $descripcion = "Se ha intentado eliminar un tipo de solicitud";
                            $objeto = 36;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                $res['msj'] = "Se produjo un error al momento de eliminar el tipo de solicitud";
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
