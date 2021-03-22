<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'obtenerObjeto': // OBTIENE UN Objeto POR NOMBRE
        $objeto = $_GET['objeto'];
        $sql = "SELECT 
         id_objeto, objeto
        FROM tbl_objeto WHERE objeto = '" . $objeto . "'";
        $result = $conn->query($sql);
        $objeto_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($objeto_db, $row);
        }
        $res['objeto'] = $objeto_db;
    break;

    case 'registrarObjeto': // REGISTRA UN objeto
        $nombreObjetos = $_POST['objeto'];
        $tipoObjeto = $_POST['tipo_objeto'];
        $descripcion = $_POST['descripcion'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['objeto']) || empty($_POST['descripcion'])  || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_objeto (objeto, tipo_objeto, descripcion, estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?)");
                $sql->bind_param("sssissss", $nombreObjetos, $tipoObjeto, $descripcion, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Objeto";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Objeto Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
    case 'actualizarObjeto':

        if (
            isset(($_POST['id_objeto']))
            && isset($_POST['objeto']) && isset($_POST['tipo_objeto'])&& isset($_POST['descripcion'])) {
            $id_objetos = (int)$_POST['id_objeto'];
            $nombreO = $_POST['objeto'];
            $tipoObjeto = $_POST['tipo_objeto'];
            $descripcion = $_POST['descripcion'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());
           
            $sql = "UPDATE tbl_objeto SET objeto = '$nombreO', tipo_objeto  = '$tipoObjeto', descripcion= '$descripcion', modificado_por= '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_objeto=" .$id_objetos;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "Objetos se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Objetos ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    case 'eliminarObjetos':
        if (isset($_POST['id_objeto'])) {
            $id_objetos = $_POST['id_objeto'];
            $sql = "UPDATE tbl_objeto SET estado_eliminado = 0 WHERE id_objeto = " . $id_objetos;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Objeto Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Objeto";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del producto a eliminar";
            $res['error'] = true;
        }
        break;
    case 'actualizarPermiso':

            if (
                isset(($_POST['id_permiso']))
                && isset($_POST['permiso_insercion']) && isset($_POST['permiso_eliminacion']) && isset($_POST['permiso_actualizacion']) && isset($_POST['permiso_consulta'])) {
                $id_permiso = (int)$_POST['id_permiso'];
                $PInsertar = $_POST['permiso_insercion'];
                $PEliminar = $_POST['permiso_eliminacion'];
                $PActualizacion = $_POST['permiso_actualizacion'];
                $PConsulta = $_POST['permiso_consulta'];
                $usuario_actual = $_POST['usuario_actual'];
                $fecha = date('Y-m-d H:i:s', time());
               
                $sql = "UPDATE tbl_permisos SET permiso_insercion  = '$PInsertar', permiso_eliminacion= '$PEliminar', permiso_actualizacion= '$PActualizacion', permiso_consulta = '$PConsulta' , modificado_por = '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_permiso=" .$id_permiso;          
                $resultado = $conn->query($sql);
              
                if ($resultado == 1) {
                    
                    $res['msj'] = "Permisos se  Edito  Correctamente";
                } else {
                    $res['msj'] = "Se produjo un error al momento de Editar el Permiso ";
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
