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
        $nombreProducto = $_POST['nombreProducto'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $estado=1;
        $tipoProducto = $_POST['tipo_producto'];
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['nombreProducto']) || empty($_POST['cantidad']) || empty($_POST['precio']) || ((int)$_POST['tipo_producto'] > 0 &&  empty($_POST['tipo_producto']) || empty($_POST['usuario_actual']))) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_producto (nombre_producto, cantidad_producto, precio, tipo_producto_id,  estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?)");
                $sql->bind_param("sidiissss", $nombreProducto, $cantidad, $precio, $tipoProducto,$estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();

                if ($sql->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el producto";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Producto Registrado Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        }
    break;
 

    case 'obtenerProductos':
        try {
            $sql = "SELECT id_articulo, nombre_articulo FROM tbl_inventario WHERE estado_eliminado = 1";
            $resultado = $conn->query($sql);
            if($resultado == 1){
                //$res['productos'] = 
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'eliminarProducto':
        if (isset($_POST['id_inventario'])) {
            $id_inventario = $_POST['id_inventario'];
            $sql = "UPDATE tbl_inventario SET estado_eliminar = 0 WHERE id_inventario = " . $id_inventario;
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
            isset($_POST['id_inventario'])
            && isset($_POST['nombre_inventario']) && isset($_POST['existencia'])  && isset($_POST['costo'])
        ) {
            $id_inventario = $_POST['id_inventario'];
            $nombreP = $_POST['nombre_inventario'];
            $existenciaP = $_POST['existencia'];
            $costoP = $_POST['costo'];

            //echo ($id_inventario);
            $sql = "UPDATE tbl_inventario 
                        SET nombre_articulo='$nombreP', existencias=$existenciaP, costo=$costoP
                        WHERE id_inventario=" . $id_inventario;
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                $res['msj'] = "Producto Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el producto ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;
    case 'ingresarOrden':


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
