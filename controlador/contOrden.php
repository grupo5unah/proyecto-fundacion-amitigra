<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';
global $lastid;

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
$rs = mysqli_query($conn, "SELECT MAX(id_orden) AS id FROM tbl_ordenes");
if ($row = mysqli_fetch_row($rs)) {
    $lastid = trim($row[0]);
}
switch ($action) {
    case 'obtenerproducto': // OBTIENE UN PREGUNTA POR NOMBRE
        $pregunta = $_GET['pregunta'];
        $sql = "SELECT  p.nombre_producto, i.existencias from tbl_inventario i INNER JOIN tbl_producto p on p.id_producto= i.producto_id WHERE p.estado_eliminado=i.estado_eliminar AND p.nombre_producto  ='" . $pregunta . "'";
        $result = $conn->query($sql);
        $pregunta_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($pregunta_db, $row);
        }
        $res['pregunta'] = $pregunta_db;
        break;

    case 'registrarOrden': // REGISTRA Orden
        $idLocalidad = $_POST['localidad'];
        $idUsuario = $_POST['usuario_id'];
        $idEstado = 8;
        $estado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());
        // echo $idLocalidad;
        if (empty($_POST['localidad']) || empty($_POST['usuario_id']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $sql = $conn->prepare("INSERT INTO tbl_ordenes ( localidad_id, estado_id, usuario_id, estado_eliminado, creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?)");
                $sql->bind_param("iiiissss", $idLocalidad, $idEstado, $idUsuario, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();
                //obtener el ultimo id insertado
                $lastid = mysqli_insert_id($conn);
                echo $lastid;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        break;

        //https://www.anerbarrena.com/php-array-tipos-ejemplos-3876/
    case 'registrarDetalleOrden':
        echo $lastid;

        if (empty($_POST['contOrden']) || empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

            $proOrdenes = json_decode($_POST['contOrden']);
            $usuario_actual = $_POST['usuario_actual'];
            //$lastid= $_POST['lastId'];
            $estado = 1;
            $fecha = date('Y-m-d H:i:s', time());
            

            $sql = $conn->prepare("INSERT INTO `tbl_detalle_orden`(`cantidad`, `descripcion`, `producto_id`,`ordenes_id`,`estado_eliminado`,`creado_por`,`fecha_creacion`,`modificado_por`,`fecha_modificacion`) VALUES (?,?,?,?,?,?,?,?,?);");
            foreach ($proOrdenes as $valor) {
                
                $cant = $valor->cantidad;
                $des = $valor->descripcion;
                $ids = $valor->id;

                $sql->bind_param("isiiissss", $cant, $des, $ids, $lastid, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                $sql->execute();
            }
            //print($query);
            try {


                if ($sql->error) {

                    $res['msj'] = "Se produjo un error al momento de registrar el detalle de la Orden";
                    $res['sql'] = $sql;
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Detalle de la Orden Registrada Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }




        break;
     
    case 'traerDetalleO':
        $ordenD = $_GET['idOrdenes'];
        try {

            $sql = "SELECT p.nombre_producto, d.cantidad, d.descripcion FROM tbl_detalle_orden d INNER join tbl_producto p on p.id_producto = d.producto_id where d.ordenes_id = $ordenD";
            $result = $conn->query($sql);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $vertbl = array();
        while ($eventos = $result->fetch_assoc()) {
            $evento = array(
                'nombre' => $eventos['nombre_producto'],
                'cantidad' => $eventos['cantidad'],
                'descripcion' => $eventos['descripcion'],
                
            );
            array_push($vertbl, $evento);
        }
        $res['productos'] = $vertbl;

        break;


    default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
