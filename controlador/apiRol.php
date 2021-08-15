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
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());
        $id_usuario = $_POST['id_usuario'];


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
                        $objeto = 34;
                        $acciones = "REGISTRO DE ROL";
                        $descp = "SE INGRESADO UN NUEVO ROL";
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                }
                
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
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
           
            $sql = "UPDATE tbl_roles SET rol = '$nombreR', descripcion= '$descripcion',modificado_por = '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_rol=" .$id_rol;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "Rol se  Edito  Correctamente";
                $objeto = 29;
                        $acciones = "ACTUALIZACION DE ROL";
                        $descp = "SE A ACTUALIZADO UN ROL";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
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
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
            $sql = "UPDATE tbl_roles SET estado_eliminado = 0 WHERE id_rol = " . $id_rol;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Rol Eliminado  Correctamente";
                $objeto = 29;
                        $acciones = "ELIMINACION DE ROL";
                        $descp = "SE A ELIMINADO UN ROL";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Rol";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Rol a eliminar";
            $res['error'] = true;
        }
    break;

        //mantenimientos Tipo Producto


    case 'obtenerTipoP': // OBTIENE UN tipo POR NOMBRE
        $tipoP = $_GET['tipoP'];
        $sql = "SELECT 
        nombre_tipo_producto, id_tipo_producto
        FROM tbl_tipo_producto WHERE nombre_tipo_producto = '" . $tipoP . "'";
        $result = $conn->query($sql);
        $tipo_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($tipo_db, $row);
        }
        $res['tipoP'] = $tipo_db;
        break;

    case 'registrarTProduct': // REGISTRA UN tipo p
        $nombreTP = $_POST['tipo_Producto'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());
        $id_usuario = $_POST['id_usuario'];
        if (empty($_POST['tipo_Producto'])  || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_tipo_producto (nombre_tipo_producto,  estado_eliminado, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?)");
                $sql->bind_param("sissss", $nombreTP,  $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el tipo producto";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Tipo producto Registrado Correctamente";
                    $objeto = 26;
                        $acciones = "REGISTRO DE NUEVO TIPO DE PRODUCTO";
                        $descp = "SE INGRESO UN NUEVO TIPO PRODUCTO";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    break;
     //edita tipo producto
    case 'actualizarTP':

        if (
            isset(($_POST['id_tipoProducto']))
            && isset($_POST['tProducto'])) {
            $id_tipoP = (int)$_POST['id_tipoProducto'];
            $nombreTP = $_POST['tProducto'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];

            $sql = "UPDATE tbl_tipo_producto SET nombre_tipo_producto = '$nombreTP', modificado_por= '$usuario_actual', fecha_modificacion='$fecha' WHERE id_tipo_producto=" .$id_tipoP;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {

                $res['msj'] = "Tipo producto se  Edito  Correctamente";
                $objeto = 26;
                        $acciones = "ACTUALIZACIÓN DE TIPO PRODUCTO";
                        $descp = "SE HA ACTUALIZADO UN TIPO DE PRODUCTO";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Tipo producto ";
                $res['error'] = true;
            }
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    //elimina el tipo producto
    case 'eliminarTipoP':
        if (isset($_POST['id_tipo_producto'])) {
            $id_tipoP = $_POST['id_tipo_producto'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
            $sql = "UPDATE tbl_tipo_producto SET estado_eliminado = 0 WHERE id_tipo_producto = " . $id_tipoP;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Tipo Producto Eliminado  Correctamente";
                $objeto = 26;
                        $acciones = "ELIMINACION DE TIPO PRODUCTO";
                        $descp = "SE ELIMINO UN TIPO PRODUCTO";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Tipo producto";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Tipo producto a eliminar";
            $res['error'] = true;
        }
    break;
    case 'obtenerLocalidad': // OBTIENE la localidad POR NOMBRE
            $localidad = $_GET['localidad'];
            $sql = "SELECT 
            nombre_localidad
            FROM tbl_localidad WHERE nombre_localidad = '" . $localidad . "'";
            $result = $conn->query($sql);
            $localidad_db = array();
            while ($row = $result->fetch_assoc()) {
                array_push($localidad_db, $row);
            }
            $res['localidad'] = $localidad_db;
    break;
    
    case 'registrarLocalidad': // REGISTRA UN localidad
            $nombreLocalidad = $_POST['localidad'];
            $estado = 1;
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            $id_usuario = $_POST['id_usuario'];
    
            if (empty($_POST['localidad'])  || empty($_POST['usuario_actual'])) {
                $res['msj'] = 'Es necesario rellenar todos los campos';
                $res['error'] = true;
            } else {
                try {
                    $sql = $conn->prepare("INSERT INTO tbl_localidad (nombre_localidad,  estado_eliminado, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?)");
                    $sql->bind_param("sissss", $nombreLocalidad,  $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $sql->execute();
    
                    if ($sql->error) {
                        $res['msj'] = "Se produjo un error al momento de registrar La Localidad";
                        $res['error'] = true;
                    } else {
                        $res['msj'] = "Localidad Registrada Correctamente";
                        $objeto = 26;
                        $acciones = "REGISTRO DE LOCALIDAD";
                        $descp = "SE INGRESADO UNA LOCALIDAD";
                        
                        
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
         break;
         //edita localidad
    case 'actualizarLocalidad':
    
            if (
                isset(($_POST['id_localidad']))
                && isset($_POST['localidad']) && isset($_POST['usuario_actual'])) {
                $id_localidad = (int)$_POST['id_localidad'];
                $nombreLocalidad = $_POST['localidad'];
                $usuario_actual = $_POST['usuario_actual'];
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d H:i:s', time());
                $id_usuario = $_POST['id_usuario'];

                $sql = "UPDATE tbl_localidad SET nombre_localidad = '$nombreLocalidad', modificado_por= '$usuario_actual', fecha_modificacion=' $fecha' WHERE id_localidad =" .$id_localidad;          
                $resultado = $conn->query($sql);
              
                if ($resultado == 1) {
                    $res['msj'] = "La localidad se  Edito  Correctamente";
                    $objeto = 26;
                        $acciones = "ACTUALIZACIÓN DE LOCALIDAD";
                        $descp = "SE ACTUALIZADO UNA LOCALIDAD";
                                                
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                } else {
                    $res['msj'] = "Se produjo un error al momento de Editar el nombre de la Localidad ";
                    $res['error'] = true;
                }
            } else {
                $res['msj'] = "Las variables no estan definidas";
                $res['error'] = true;
            }
    
    break;
        //elimina el tipo producto
    case 'eliminarLocalidad':
            if (isset($_POST['id_localidad'])) {
                $id_Localidad = $_POST['id_localidad'];
                date_default_timezone_set("America/Tegucigalpa");
               $fecha = date('Y-m-d H:i:s', time());
               $id_usuario = $_POST['id_usuario'];
                $sql = "UPDATE tbl_localidad SET estado_eliminado = 0 WHERE id_localidad = " . $id_Localidad;
                $resultado = $conn->query($sql);
                if ($resultado == 1) {
                    $res['msj'] = "Localidad Eliminada  Correctamente";
                    $objeto = 5;
                        $acciones = "ELIMINACION DE LOCALIDAD";
                        $descp = "SE ELIMINO LOCALIDAD";
                        $llamar = $conn->prepare("INSERT INTO tbl_bitacora(accion, descripcion_bitacora,fecha_accion, usuario_id, objeto_id) values (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                        $llamar->execute();
                } else {
                    $res['msj'] = "Se produjo un error al momento de eliminar el registro Localidad";
                    $res['error'] = true;
                }
            } else {
                $res['msj'] = "No se envió el id de la Localidad a eliminar";
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
