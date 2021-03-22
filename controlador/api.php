<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
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
        $articulo1 = ($_POST['articulo1']);
        $precio1 =  ($_POST['articulo2']);
        $cantidad = ($_POST['articulo3']);
        $descripcion =  ($_POST['articulo4']);     
        $precioAl = ($_POST['articulo6']);
        $tipoP =  ($_POST['articulo5']);
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        $convArti6= intval($precioAl);
        $fecha = date('Y-m-d H:i:s', time());
        
         if (empty($_POST['articulo1']) || empty($_POST['articulo2']) || empty($_POST['articulo3'])|| empty($_POST['articulo4'])  || empty($_POST['articulo5']) || empty($_POST['articulo6'])|| empty($_POST['usuario_actual'])) {
             $res['msj'] = 'Es necesario rellenar todos los campos';
             $res['error'] = true;
        } else {
             try {
                 $sql = $conn->prepare("INSERT INTO tbl_producto (nombre_producto, cantidad_producto, precio_compra, descripcion, precio_alquiler, tipo_producto_id,  estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                 $sql->bind_param("siisiiissss", $articulo1, $precio1, $cantidad, $descripcion, $precioAl, $tipoP, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                 $sql->execute();

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
                        SET nombre_producto = '$nombreP', precio_compra = '$costoP', cantidad_producto = '$cantidadP', descripcion = '$desc', tipo_producto_id =' $tipoP', precio_alquiler = '$precioAl', modificado_por = '$usuario_actual', fecha_modificacion = '$fecha'     WHERE id_producto= '" . $id_product . "'";;
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
    case 'ingresarOrden':

    break;
    case 'traer_productosOrden':

        $sql = "SELECT id_inventario, nombre_articulo FROM tbl_inventario WHERE estado_eliminar = 1   AND existencia != 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        $listas = '<option value = "0"> Elige una opcion </option>';
            while ($row = $result->fetch_assoc()) {
              echo  $listas .="<option value=" . $row['id_inventario'] . ">" . $row['nombre_articulo'] . "</option>";
            }
            
        } else {
            echo "0 results";
        }
                                    
        break;
    case 'registrarOrden':

        if (empty($_POST['nombreProducto']) || empty($_POST['cantidad']) || ((int)$_POST['id_localidad'] > 0 &&  empty($_POST['id_localidad']) || empty($_POST['id_inventario']) || empty($_POST['usuario_actual']))) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            $nombreProducto = $_POST['nombreProducto'];
            $cantidad = $_POST['cantidad'];
            $localidad = $_POST['id_localidad'];
            $id_inventario = $_POST['id_inventario'];
            $usuario_actual = $_POST['usuario_actual'];
            try {
                $sql = $conn->prepare("INSERT INTO tbl_orden (nombre_producto, cantidad, id_localidad, id_inventario, creado_por) VALUES (?,?,?,?,?)");
                $sql->bind_param("siiis", $nombreProducto, $cantidad,  $localidad, $id_inventario, $usuario_actual);
                $sql->execute();
                if($sql->error){ 
                    $res['msj'] = "Se produjo un error al momento de registrar un nuevo pedido";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Pedido de Insumos Registrado Correctamente";
                    $res['msj'] = "Se produjo un error al momento de registrar la orden MAESTRA";
                    $res['error'] = true;

                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        break;

   

    
    case 'registrarDetalleOrden':
        if(isset($_POST['id_orden']) && isset($_POST['productos'])){
            print_r($_POST['id_orden']);
            print_r($_POST['productos']);

            //$sql = "INSERT INTO tbl_detalleorden () VALUES ";

            /*print_r($sql);
            $resultado = $conn->query($sql);
            if($resultado === 1){
                $res['msj'] = "Solicitud de Insumos Agregada Correctamente"; 
            }else{
                $res['error'] = true;
                $res['msj'] = "Hubo un error al registrar los productos de la orden";
            }*/
        }

        break;
    
        
        //preguntas
        
        
    
        default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
