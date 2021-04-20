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
$ri = mysqli_query($conn, "SELECT MAX(id_movimiento) AS id FROM tbl_movimientos");
if ($row = mysqli_fetch_row($ri)) {
    $id = trim($row[0]);
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

        $cont = json_decode($_POST['contProducto']);
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_producto (nombre_producto,  precio_compra, descripcion,  tipo_producto_id,  estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                foreach ($cont as $valor) {
                    $nombre = $valor->nombre;
                    $precio = $valor->precio;
                    $descripcion = $valor->descripcion;
                    $tipoP = $valor->id;

                    $sql->bind_param("sisiissss", $nombre, $precio,  $descripcion,  $tipoP, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $sql->execute();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        break;
    case 'registrarInventarioInicial': // REGISTRA UN PRODUCTO

        $cont = json_decode($_POST['contProducto']);
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $local = $_POST['local'];
        $idorden = 0;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
             try {
                 $sql = $conn->prepare("INSERT INTO tbl_inventario (existencias, minimo, maximo, stock , estado_eliminar , producto_id, movimiento_id,  creado_por, fecha_creacion, modificado_por , fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
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

        $cont = json_decode($_POST['contProducto']);
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $entrada = $_POST['entrada'];
        $descripcion = 'ENTRADA INICIAL';
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());
        echo $lastid;
        if (empty($_POST['contProducto']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_movimientos (producto_id, tipo_movimiento_id, descripcion, cantidad, fecha_movimiento, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                foreach ($cont as $valor) {
                    $cantInicial = $valor->inicial;
                    


                    $sql->bind_param("iisisssss", $lastid, $entrada, $descripcion, $cantInicial, $fecha, $usuario_actual, $fecha, $usuario_actual, $fecha);
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
        if (isset($_POST['id_producto'])) {
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
            && isset($_POST['nameP']) && isset($_POST['priceP'])   && isset($_POST['desc'])
            && isset($_POST['typeP'])
        ) {
            $id_product = $_POST['id_product'];
            $nombreP = $_POST['nameP'];
            $costoP = $_POST['priceP'];
            $desc = $_POST['desc'];
            $tipoP = $_POST['typeP'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());

            $sql = "UPDATE tbl_producto 
                        SET nombre_producto = '$nombreP', precio_compra = '$costoP', descripcion = '$desc', tipo_producto_id =' $tipoP',  modificado_por = '$usuario_actual', fecha_modificacion = '$fecha'     WHERE id_producto=  $id_product";
            $resultado = $conn->query($sql);

          
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    case 'actualizarMinimoMaximo':
        if (
            isset($_POST['id_inventario'])
            && isset($_POST['minimo']) && isset($_POST['maximo'])  
        ) {
            
            $id_inventario = $_POST['id_inventario'];
            $minimo = $_POST['minimo'];
            $maximo = $_POST['maximo'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            
            $sql = "UPDATE tbl_inventario 
                        SET minimo = $minimo, maximo = $maximo,   modificado_por = '$usuario_actual', fecha_modificacion = '$fecha'     WHERE id_inventario=  $id_inventario";
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

    case 'registrarEntrada': // REGISTRA UN movimiento de entrada

        $cont = json_decode($_POST['contMovi']);
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        //$entrada = $_POST['entrada'];
        //$descripcion= 'ENTRADA INICIAL';
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());
        echo $lastid;
        if (empty($_POST['contMovi']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_movimientos (producto_id, tipo_movimiento_id, descripcion, cantidad,fecha_movimiento,  creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                foreach ($cont as $valor) {
                    $id_producto = $valor->nombreID;
                    $cantInicial = $valor->cantidad;
                    $descripcion = $valor->descripcion;
                    $entrada=$valor->id_movimiento;

                    $sql->bind_param("iisisssss", intval($id_producto), intval($entrada), $descripcion, intval($cantInicial), $fecha, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $sql->execute();
                   
                }

                //$sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    break;
        //actualiza el inventario
    case 'actualizarInventario':
        if (
             isset($_POST['usuario_actual'])
        ) {
            $cont = json_decode($_POST['contMovi']);
            //$id_inventario = $_POST['id_inventario'];
           // $stock = $_POST['stock'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
            //$movimiento = $_POST['nombre_movimiento'];
            
            //echo $stock;
            foreach ($cont as $valor) {
                $movimiento=$valor->movimiento;
                $cantInicial = $valor->cantidad;
                $local = $valor->id;
                $id_inventario=$valor->id_inventario;
                $stock = $valor->stock;
                $rev = 'ENTRADA';
                $pos = strripos($movimiento, $rev);
                if ($pos === false) {
                   if($stock > $cantInicial) {
                   $nuevoStock=intval($stock) - intval($cantInicial);    
                   echo $nuevoStock;
                    $sql = "UPDATE tbl_inventario SET existencias = '$nuevoStock', stock = '$nuevoStock', localidad_id='$local', movimiento_id = '$id' WHERE id_inventario=". $id_inventario;
                    $resultado = $conn->query($sql);
                    if ($resultado == 1) {
                        $res['msj'] = "Producto adicionado  Correctamente";
                    } else {
                        $res['msj'] = "Se produjo un error al momento de adicion el producto ";
                        $res['error'] = true;
                    }
                  }
                } else{
                    $stockTotal=$stock+$cantInicial;
                    echo $stockTotal;
                    $sql = "UPDATE tbl_inventario SET existencias = '$stockTotal', stock = '$stockTotal', localidad_id='$local', movimiento_id = '$id' WHERE id_inventario= ". $id_inventario;
                    $resultado = $conn->query($sql);
                    if ($resultado == 1) {
                        $res['msj'] = "Producto adicionado  Correctamente";
                    } else {
                        $res['msj'] = "Se produjo un error al momento de laadicion el producto ";
                        $res['error'] = true;
                    }
                }
            }
        } else {

            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }


    break;
    case 'traerMovimientos':
        $id_producto = $_GET['id_producto'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=$fecha = date('Y-m-d ', time());
        try {

            $sql = "SELECT t.movimiento, m.cantidad, m.descripcion, m.fecha_movimiento from tbl_movimientos m INNER JOIN tbl_tipo_movimiento t on t.id_tipo_movimiento INNER JOIN tbl_producto p on p.id_producto= m.producto_id where p.id_producto= $id_producto AND MONTH('$fecha') ORDER BY fecha_movimiento DESC LIMIT 15 ";
            $result = $conn->query($sql);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $vertbl = array();
        while ($eventos = $result->fetch_assoc()) {
            $evento = array(
                'movimiento' => $eventos['movimiento'],
                'cantidad' => $eventos['cantidad'],
                'descripcion' => $eventos['descripcion'],
                'fecha' => $eventos['fecha_movimiento']
                
            );
            array_push($vertbl, $evento);
        }
        $res['movimiento'] = $vertbl;

    break;
    // traer tipo Movimientos
    case 'obtenerTipoMovimiento': // OBTIENE  POR NOMBRE
        $movimiento = $_GET['movimiento'];
        $sql = "SELECT 
        movimiento, id_tipo_movimiento
        FROM tbl_tipo_movimiento WHERE movimiento = '" . $movimiento . "'";
        $result = $conn->query($sql);
        $movimiento_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($movimiento_db, $row);
        }
        $res['movimiento'] = $movimiento_db;
    break;
    //mantenimiento tipo de movimiento
    case 'registrarTipoMovimiento': // REGISTRA UN ROL
        $movimiento = $_POST['movimiento'];
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['movimiento'])   || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_tipo_movimiento(movimiento, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?)");
                $sql->bind_param("sssss", $movimiento,  $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Tipo Movimiento";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Tipo Movimiento Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    break;
    case 'actualizarTipoMovimiento':

        if (
            isset(($_POST['id_movimiento']))
            && isset($_POST['movimiento']) && isset($_POST['usuario_actual'])) {
            $id_mo = (int)$_POST['id_movimiento'];
            $nombre = $_POST['movimiento'];
            $usuario_actual = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s', time());
           
            $sql = "UPDATE tbl_tipo_movimiento SET movimiento = '$nombre', modificado_por = '$usuario_actual', fecha_modificacion = '$fecha' WHERE id_tipo_movimiento=" .$id_mo;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "Tipo Movimiento se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Tipo Movimiento ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

    break;
    case 'eliminarTipoMovimiento':
        if (isset($_POST['id_movimiento'])) {
            $id_mo = $_POST['id_movimiento'];
            $sql = "DELETE from tbl_tipo_movimiento WHERE id_tipo_movimiento=  " . $id_mo;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Tipo Movimiento Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Tipo de Movimiento";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Rol a eliminar";
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
