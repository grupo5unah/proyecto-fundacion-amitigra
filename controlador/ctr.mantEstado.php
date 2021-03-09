<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    // OBTIENE UN cliente POR NOMBRE
    case 'obtenerEstado': 
        $nomE = $_GET['estado'];
        $sql = "SELECT 
         id_estado, nombre_estado
        FROM tbl_estado WHERE nombre_estado = '" . $nomE . "'";
        $result = $conn->query($sql);
        $estado_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($estado_db, $row);
        }
        $res['estado'] = $estado_db;
    break;
    // REGISTRA UN CLIENTE
     case 'registrarEstado': 
        $nombreEstado = $_POST['nombreE'];
        $descrip = $_POST['descrip'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['nombreE']) || empty($_POST['descrip']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $insertar=$conn->prepare("INSERT INTO tbl_estado (nombre_estado, descripcion, estado_eliminado,
                                        creado_por,fecha_creacion, modificado_por, fecha_modificacion)
                VALUES (?,?,?,?,?,?,?);");
                $insertar->bind_param('ssissss', $nombreEstado,$descrip,$estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Estado";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Estado Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
    case 'actualizarEstado':

        if (isset(($_POST['id_estado']))
            && isset($_POST['estado']) && isset($_POST['descripcion'])
            && isset($_POST['usuario_actual'])) {
            $id_estado = (int)$_POST['id_estado'];
            $nombreE = $_POST['estado'];
            $descripc = $_POST['descripcion'];
            $usuario = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fech=date('Y-m-d H:i:s',time());
           
            $sql = "UPDATE tbl_estado SET nombre_estado = '$nombreE', descripcion  = '$descripc', 
             modificado_por='$usuario',fecha_modificacion = '$fech'
             WHERE id_estado=" .$id_estado;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "El Estado se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Estado ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
    break;
    case 'eliminarEstado':
        if (isset($_POST['id_estad'])) {
            $id_estad= $_POST['id_estad'];
            $sql = "UPDATE tbl_estado SET estado_eliminado = 0 WHERE id_estado = " . $id_estad;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Estado Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Estado";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del estado a eliminar";
            $res['error'] = true;
        }
    break;

    break;
    default:

    break;

}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);