<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';
global $lastid;
global $id;
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


$re = mysqli_query($conn, "SELECT MAX(id_producto) AS id FROM tbl_producto");
if ($row = mysqli_fetch_row($re)) {
    $lastid = trim($row[0]);
}
$ri = mysqli_query($conn, "SELECT MAX(id_movimientos) AS id FROM tbl_movimientos");
if ($row = mysqli_fetch_row($ri)) {
    $id= trim($row[0]);
}

switch ($action) {

    case 'obtenerProducto': // OBTIENE UN PRODUCTO POR NOMBRE
        $producto = $_GET['nombreProducto'];
        $sql = "SELECT 
        nombre_producto, id_producto
        FROM tbl_producto WHERE nombre_producto = '" . $producto . "'";
        $result = $conn->query($sql);
        $producto_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($producto_db, $row);
        }
        $res['producto'] = $producto_db;
    break;

    case 'registrarProducto': // REGISTRA UN PRODUCTO
            
        $cont= json_decode($_POST['contProducto']);
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());
        
         if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
             $res['msj'] = 'Es necesario rellenar todos los campos';
             $res['error'] = true;
        } else {
             try {
                 $sql = $conn->prepare("INSERT INTO tbl_producto (nombre_producto,  precio_compra, descripcion,  tipo_producto_id,  estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                 foreach ($cont as $valor) {
                    $nombre =$valor->nombre;
                    $precio =$valor->precio;
                    $descripcion =$valor->descripcion;
                    $tipoP =$valor->id;

                 $sql->bind_param("sisiissss", $nombre, $precio,  $descripcion,  $tipoP, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                 $sql->execute();
               }
            } catch (Exception $e) {
                   echo $e->getMessage();
            }

         }
    break;
    case 'registrarInventarioInicial': // REGISTRA UN PRODUCTO
            
        $cont= json_decode($_POST['contProducto']);
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        $local= $_POST['local'];
        $idorden=0;
        $fecha = date('Y-m-d H:i:s', time());
        
         if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
             $res['msj'] = 'Es necesario rellenar todos los campos';
             $res['error'] = true;
        } else {
             try {
                 $sql = $conn->prepare("INSERT INTO tbl_inventario (existencias, minimo,  	maximo, stock , estado_eliminar , producto_id, movimientos_id,  creado_por, fecha_creacion, modificado_por , fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                 foreach ($cont as $valor) {
                    $cantInicial =$valor->inicial;
                    $minimo =$valor->minimo;
                    $maximo =$valor->maximo;
                 
                 
                 $sql->bind_param("iiiiiiissss", $cantInicial, $minimo,  $maximo, $cantInicial,  $estado, $lastid, $id,  $usuario_actual, $fecha, $usuario_actual, $fecha);
                 $sql->execute();
               }
                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el producto";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Producto Registrado Correctamente";
                }
                //$sql->close();
                // $sql = null;
            } catch (Exception $e) {
                   echo $e->getMessage();
            }

         }
    break;
    case 'registrarEntradaInicial': // REGISTRA UN PRODUCTO
            
        $cont= json_decode($_POST['contProducto']);
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        $entrada = $_POST['entrada'];
        $descripcion= 'ENTRADA INICIAL';
        $fecha = date('Y-m-d H:i:s', time());
         echo $lastid;
         if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
             $res['msj'] = 'Es necesario rellenar todos los campos';
             $res['error'] = true;
        } else {
             try {
                 $sql = $conn->prepare("INSERT INTO tbl_movimientos (producto_id, tipo_movimiento_id, descripcion, cantidad,fecha_movimiento,  creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                 foreach ($cont as $valor) {
                    $cantInicial =$valor->inicial;
                       
             
                 $sql->bind_param("iisisssss", $lastid,$entrada, $descripcion,$cantInicial,$fecha, $usuario_actual, $fecha, $usuario_actual, $fecha);
                 $sql->execute();
               }
               
                //$sql->close();
                // $sql = null;
            } catch (Exception $e) {
                   echo $e->getMessage();
            }

         }
    break;
    case 'eliminarProducto':
        if (isset($_POST['id_inventario'])) {
            $id_producto = $_POST['id_producto'];
            $sql = "UPDATE tbl_producto SET estado_eliminado = 0 WHERE id_producto = " . $id_producto;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Producto Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el producto";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del producto a eliminar";
            $res['error'] = true;
        }
        break;
    case 'actualizarProducto':
        if (
            isset($_POST['id_product'])
            && isset($_POST['nameP']) && isset($_POST['priceP'])  && isset($_POST['countP']) && isset($_POST['desc'])
            && isset($_POST['typeP']) && isset($_POST['id_product'])
        ) {
            $id_product = $_POST['id_product'];
            $nombreP = $_POST['nameP'];
            $costoP = $_POST['priceP'];
            $cantidadP = $_POST['countP'];
            $desc = $_POST['desc'];
            $tipoP = $_POST['typeP'];
            $precioAl = $_POST['rentalP'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $sql = "UPDATE tbl_producto 
                        SET nombre_producto = '$nombreP', precio_compra = '$costoP', cantidad_producto = '$cantidadP', descripcion = '$desc', tipo_producto_id =' $tipoP', precio_alquiler = '$precioAl', modificado_por = '$usuario_actual', fecha_modificacion = '$fecha'     WHERE id_producto= '" . $id_product . "'";
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                $res['msj'] = "Producto Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el producto ";
                $res['error'] = true;
            }
        } else {
           
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    case 'actualizarInventario':
        if (
            isset($_POST['id_inventario'])
            && isset($_POST['stock']) && isset($_POST['usuario_actual'])
        ) {
            $id_inventario = $_POST['id_inventario'];
            $valor=$_POST['stock'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());
     
            $sql = "UPDATE tbl_inventario 
                        SET existencias = '$valor',modificado_por = '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_inventario= '" . $id_inventario . "'";
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                $res['msj'] = "Producto Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el producto ";
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
