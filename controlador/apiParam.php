<?php

include "../modelo/conexion.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'obtenerParametro': // OBTIENE UN Parametro POR NOMBRE
        $parametro = $_GET['parametro'];
        $sql = "SELECT 
        parametro, id_parametro
        FROM tbl_parametros WHERE parametro = '" . $parametro . "'";
        $result = $conn->query($sql);
        $parametro_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($parametro_db, $row);
        }
        $res['parametro'] = $parametro_db;
        break;

case 'registrarParametro': // REGISTRA UN parametro
        $nombreParametro = $_POST['parametro'];
        $valor= $_POST['valor'];
        $estado= 1;
        $id_usuario=7;
        //$usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['parametro']) || empty($_POST['valor'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_parametros (parametro, valor, estado, id_usuario, fecha_creacion,  fecha_modificacion) VALUES (?,?,?,?,?,?)");
                $sql->bind_param("ssiiss", $nombreParametro, $valor, $estado, $id_usuario, $fecha, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Parametro";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Parametro Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    break;    
case 'actualizarParametro':

        if (
            isset(($_POST['id_parametro']))
            && isset($_POST['parametro']) && isset($_POST['valor'])) {
            $id_param = (int)$_POST['id_parametro'];
            $parametro = $_POST['parametro'];
            $valor = $_POST['valor'];
           
            $sql = "UPDATE tbl_parametros SET parametro = '$parametro', valor= '$valor' WHERE id_parametro=" . $id_param;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "parametro se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el parametro ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break; 
case 'eliminarParametro':
        if (isset($_POST['id_parametro'])) {
            $id_param = (int)$_POST['id_parametro'];
            $sql = "UPDATE tbl_parametros SET estado = 0 WHERE id_parametro = " . $id_param;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Parametro Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Parametro";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Parametro a eliminar";
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
