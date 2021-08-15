<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'obtenerPregunta': // OBTIENE UN PREGUNTA POR NOMBRE
        $pregunta = $_GET['pregunta'];
        $sql = "SELECT 
        pregunta, id_pregunta
        FROM tbl_preguntas WHERE pregunta = '" . $pregunta . "'";
        $result = $conn->query($sql);
        $pregunta_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($pregunta_db, $row);
        }
        $res['pregunta'] = $pregunta_db;
        break;

    case 'registrarPregunta': // REGISTRA UN Preguntas
        $pregunta = $_POST['pregunta'];
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());
        $id_usuario = $_POST['id_usuario'];

        if (empty($_POST['pregunta']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_preguntas (pregunta, estado_eliminado, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?)");
                $sql->bind_param("sissss", $pregunta, $estado,$usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar la pregunta";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "pregunta Registrada Correctamente";
                         $objeto = 31;
                        $acciones = "REGISTRO DE UNA PREGUNTA";
                        $descp = "SE INGRESADO UN NUEVA PREGUNTA";
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    break;
    case 'actualizarPregunta':
    
        if (
            isset(($_POST['id_pregunta']))
            && isset($_POST['pregunta'])) {
            $id_pregunta = (int)$_POST['id_pregunta'];
            $pregunta = $_POST['pregunta'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
            
           
            $sql = "UPDATE tbl_preguntas SET pregunta = '$pregunta', modificado_por = '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_pregunta=" . $id_pregunta;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "Pregunta se  Edito  Correctamente";
                $objeto = 31;
                        $acciones = "ACTUALIZACION";
                        $descp = "SE ACTUALIZO UNA PREGUNTA";
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Pregunta ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break; 
    case 'eliminarPregunta':
        if (isset($_POST['id_pregunta'])) {
            $id_pregunta = (int)$_POST['id_pregunta'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
            $sql = "UPDATE tbl_preguntas SET estado_eliminado = 0 WHERE id_pregunta = " . $id_pregunta;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Pregunta Eliminada  Correctamente";
                $objeto = 31;
                        $acciones = "ELIMINAR";
                        $descp = "SE ELIMINO UNA PREGUNTA";
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Pregunta";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Pregunta a eliminar";
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
