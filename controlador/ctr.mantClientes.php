<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    // OBTIENE UN cliente POR NOMBRE
    case 'obtenerCliente': 
        $iden = $_GET['cliente'];
        $sql = "SELECT 
         id_cliente, identidad
        FROM tbl_clientes WHERE identidad = '" . $iden . "'";
        $result = $conn->query($sql);
        $cliente_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($cliente_db, $row);
        }
        $res['cliente'] = $cliente_db;
    break;
    // REGISTRA UN CLIENTE
     case 'registrarCliente': 
        $nombreCliente = $_POST['nombreCliente'];
        $identC = $_POST['ident'];
        $telef = $_POST['tel'];
        $nacion = $_POST['nacion'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $usuarioid = $_POST['idusuario'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['nombreCliente']) || empty($_POST['ident']) || empty($_POST['tel']) 
            || empty($_POST['nacion'])|| empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $insertar=$conn->prepare("INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, 
                estado_eliminado,creado_por,fecha_creacion, modificado_por, fecha_modificacion)
                VALUES (?,?,?,?,?,?,?,?,?);");
                $insertar->bind_param('sssiissss', $nombreCliente,$identC,$telef,$nacion,$estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Cliente";
                    $res['error'] = true;
                } else {
                    //Registra en la BITACORA la accion realizada
                    $objeto = 19;
                    $acciones = "Creación de un cliente";
                    $descp = "Cliente creado correctamente";
                    require_once("../modelo/conexionbd.php");
                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $usuarioid, $objeto);
                    $llamar->execute();
                    $llamar->close();
                    $res['msj'] = "Cliente Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
    case 'actualizarCliente':

        if (isset(($_POST['id_cliente']))
            && isset($_POST['cliente']) && isset($_POST['identidad'])&& isset($_POST['nacionalidad'])&& isset($_POST['telefono'])
            && isset($_POST['usuario_actual'])) {
            $id_cliente = (int)$_POST['id_cliente'];
            $nombreC = $_POST['cliente'];
            $ident = $_POST['identidad'];
            $tel = $_POST['telefono'];
            $nacionalidad = $_POST['nacionalidad'];
            $usuario = $_POST['usuario_actual'];
            $usuario_id = $_POST['usuario_id'];
            date_default_timezone_set("America/Tegucigalpa");
            $fech=date('Y-m-d H:i:s',time());
           
            $sql = "UPDATE tbl_clientes SET nombre_completo = '$nombreC', identidad  = '$ident', 
            telefono= '$tel', tipo_nacionalidad= '$nacionalidad', modificado_por='$usuario',fecha_modificacion = '$fech'
             WHERE id_cliente=" .$id_cliente;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                //Registra en la BITACORA la accion realizada
                $objeto = 19;
                $acciones = "Actualización de un cliente";
                $descp = "Cliente actualizado correctamente";
                require_once("../modelo/conexionbd.php");
                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar->bind_Param("sssii", $acciones, $descp, $fech, $usuario_id, $objeto);
                $llamar->execute();
                $llamar->close();
                $res['msj'] = "El Cliente se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Cliente ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
    break;
    case 'eliminarCliente':
        if (isset($_POST['id_cliente'])) {
            $id_client = $_POST['id_cliente'];
            $id_usu = $_POST['id_usuario'];
            $sql = "UPDATE tbl_clientes SET estado_eliminado = 0 WHERE id_cliente = " . $id_client;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                //Registra en la BITACORA la accion realizada
                date_default_timezone_set("America/Tegucigalpa");
                $fecha_bitacor=date('Y-m-d H:i:s',time());
                $objeto = 19; 
                $acciones = "Eliminación de un cliente";
                $descp = "Cliente eliminado correctamente";
                require_once("../modelo/conexionbd.php");
                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar->bind_Param("sssii", $acciones, $descp, $fecha_bitacor, $id_usu, $objeto);
                $llamar->execute();
                $llamar->close();
                $res['msj'] = "Cliente Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Cliente";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del cliente a eliminar";
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