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

                    echo "<br>";
                    echo $cantInicial;
                    echo "<br>";
                    echo $minimo;
                    echo "<br>";
                    echo $maximo;
                    echo "<br>";
                    echo $id;
                    echo "<br>";
                    echo $lastid;
                    echo "<br>";
                 
                 
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
                    echo "<br>";
                    echo $entrada;
                    echo "<br>";
                    echo $descripcion;
                    echo "<br>";
                    echo $cantInicial;
                    echo "<br>";
                    echo $usuario_actual;
                    echo "<br>";
                    echo $lastid;


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

    case 'registrarEntrada': // REGISTRA UN movimiento de entrada

        $cont = json_decode($_POST['contMovi']);
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        //$entrada = $_POST['entrada'];
        //$descripcion= 'ENTRADA INICIAL';
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


    default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
