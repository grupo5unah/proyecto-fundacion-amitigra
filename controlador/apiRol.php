<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'obtenerRol': // OBTIENE UN rol POR NOMBRE
        $rol = $_GET['rol'];
        $sql = "SELECT 
        rol, id_rol
        FROM tbl_roles WHERE rol = '" . $rol . "'";
        $result = $conn->query($sql);
        $rol_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($rol_db, $row);
        }
        $res['rol'] = $rol_db;
        break;

     case 'registrarRol': // REGISTRA UN ROL
        $nombreRol = $_POST['rol'];
        $descripcion = $_POST['descripcion'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['rol']) || empty($_POST['descripcion'])  || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_roles (rol, descripcion, estado_eliminado, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?)");
                $sql->bind_param("ssissss", $nombreRol, $descripcion, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Rol";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Rol Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
     case 'actualizarRol':

        if (
            isset(($_POST['id_rol']))
            && isset($_POST['rol']) && isset($_POST['descripcion'])) {
            $id_rol = (int)$_POST['id_rol'];
            $nombreR = $_POST['rol'];
            $descripcion = $_POST['descripcion'];
           
            $sql = "UPDATE tbl_roles SET rol = '$nombreR', descripcion= '$descripcion' WHERE id_rol=" .$id_rol;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "Rol se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Rol ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    case 'eliminarRol':
        if (isset($_POST['id_rol'])) {
            $id_rol = $_POST['id_rol'];
            $sql = "UPDATE tbl_roles SET estado_eliminado = 0 WHERE id_rol = " . $id_rol;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Producto Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Rol";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del producto a eliminar";
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
