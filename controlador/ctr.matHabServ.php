<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    // OBTIENE UNA HABITACION O AREA
    // case 'obtenerHabServ': 
    //     $idha = $_GET['id_habserv'];
    //     $sql = "SELECT 
    //      id_cliente, identidad
    //     FROM tbl_clientes WHERE identidad = '" . $iden . "'";
    //     $result = $conn->query($sql);
    //     $cliente_db = array();
    //     while ($row = $result->fetch_assoc()) {
    //         array_push($cliente_db, $row);
    //     }
    //     $res['cliente'] = $cliente_db;
    // break;
    // REGISTRA UN CLIENTE
     case 'registrarhabServ': 
        $habserv = $_POST['habitacion_area'];
        $descripcion = $_POST['descripcion'];
        $localidad = $_POST['localidad'];
        $estado = $_POST['estado'];
        $prean = $_POST['precioAN'];
        $prenn = $_POST['precioNN'];
        $preae = $_POST['precioAE'];
        $prene = $_POST['precioNE'];
        $estado_eliminado = 1;
        $usuario_actual = $_POST['usuario_actual'];
        $fecha = date('Y-m-d H:i:s', time());

        if (empty($_POST['habitacion_area']) || empty($_POST['descripcion']) || empty($_POST['localidad']) 
            || empty($_POST['estado'])|| empty($_POST['precioAN'])|| empty($_POST['precioNN'])||
            empty($_POST['precioAE'])|| empty($_POST['precioNE'])|| empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $insertar=$conn->prepare("INSERT INTO tbl_habitacion_servicio (descripcion, habitacion_area,localidad_id,estado_id,
                precio_adulto_nacional,precio_nino_nacional,precio_adulto_extranjero,precio_nino_extranjero,estado_eliminado, creado_por,
                fecha_creacion, modificado_por,fecha_modificacion)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);");
                $insertar->bind_param('ssiiiiiiissss', $descripcion,$habserv,$localidad,$estado,$prean,$prenn,$preae,$prene,$estado_eliminado,
                $usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar la habitación o área";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Habitación-Áarea Registrada Correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
    case 'actualizarCliente':

        if (isset(($_POST['id_cliente']))
            && isset($_POST['cliente']) && isset($_POST['identidad'])&& isset($_POST['nacionalidad'])&& isset($_POST['telefono'])
            && isset($_POST['usuario_actual'])) {
            $id_cliente = (int)$_POST['id_cliente'];
            $nombreC = $_POST['cliente'];
            $ident = $_POST['identidad'];
            $tel = $_POST['telefono'];
            $nacionalidad = $_POST['nacionalidad'];
            $usuario = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fech=date('Y-m-d H:i:s',time());
           
            $sql = "UPDATE tbl_clientes SET nombre_completo = '$nombreC', identidad  = '$ident', 
            telefono= '$tel', tipo_nacionalidad= '$nacionalidad', modificado_por='$usuario',fecha_modificacion = '$fech'
             WHERE id_cliente=" .$id_cliente;          
            $resultado = $conn->query($sql);
          
            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "El cliente se  Edito  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Cliente ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
    break;
    case 'eliminarCliente':
        if (isset($_POST['id_cliente'])) {
            $id_client = $_POST['id_cliente'];
            $sql = "UPDATE tbl_clientes SET estado_eliminado = 0 WHERE id_cliente = " . $id_client;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Cliente Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Cliente";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del cliente a eliminar";
            $res['error'] = true;
        }
    break;

    break;
    default:

    break;

}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);