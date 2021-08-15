<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
   /* case 'obtenerhabserv': 
        $idhabser = $_GET['habser'];
        $sql = "SELECT 
         id_habitacion_servicio, habitacion_area
        FROM tbl_clientes WHERE habitacion_area = '" . $idhabser . "'";
        $result = $conn->query($sql);
        $habiser_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($habiser_db, $row);
        }
        $res['habser'] = $habiser_db;
    break;*/
    // REGISTRA UN CLIENTE
     case 'registrarhabserv': 
        $habserv = $_POST['habitacion_area'];
        $descripcion = $_POST['descripcion'];
        $localidad = $_POST['localidad'];
        $estado = $_POST['estado'];
        $prean = $_POST['precioAN'];
        $prenn = $_POST['precioNN'];
        $preae = $_POST['precioAE'];
        $prene = $_POST['precioNE'];
        $usuario_actual = $_POST['usuario_actual'];
        $idusuario= $_POST['usuarioid'];
       
        if (empty($_POST['habitacion_area']) || empty($_POST['descripcion']) || empty($_POST['localidad']) 
            || empty($_POST['estado'])|| empty($_POST['precioAN'])|| empty($_POST['precioNN'])||
            empty($_POST['precioAE'])|| empty($_POST['precioNE'])|| empty($_POST['usuario_actual'])) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {
            try {
                $estado_eliminado = 1;
                date_default_timezone_set("America/Tegucigalpa");
                $fecha = date('Y-m-d H:i:s', time());
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
                    $objeto = 24;
                    $accione = "Creación de una habitación/área";
                    $descpt = "habitación/área creado correctamente";
                    require_once("../modelo/conexionbd.php");
                    $llamarha = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamarha->bind_Param("sssii", $accione, $descpt, $fecha, $idusuario, $objeto);
                    $llamarha->execute();
                    $llamarha->close();
                    $res['msj'] = "Habitación-Áarea registrada correctamente";
                }
                // $sql->close();
                // $sql = null;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
     break;
    case 'actualizarHabServ':

        if (isset(($_POST['id_habserv']))&& isset($_POST['hab_are']) 
        && isset($_POST['estad'])&& isset($_POST['preNN']) && isset($_POST['preAN'])&& isset($_POST['preAE'])
         && isset($_POST['preNE'])  && isset($_POST['descrip'])&& isset($_POST['usuario_actual'])) {
            $id_hab_are = (int)$_POST['id_habserv'];
            $hab_are = $_POST['hab_are'];
            $estad = $_POST['estad'];
            $descrip = $_POST['descrip']; 
            $preAN = $_POST['preAN'];
            $preNN = $_POST['preNN'];
            $preNE = $_POST['preNE'];
            $preAE = $_POST['preAE'];
            $usuario = $_POST['usuario_actual'];
            date_default_timezone_set("America/Tegucigalpa");
            $fech=date('Y-m-d H:i:s',time());
           
            $sql = "UPDATE tbl_habitacion_servicio SET habitacion_area = '$hab_are', descripcion  = '$descrip', 
             estado_id= '$estad', precio_adulto_nacional= '$preAN', precio_nino_nacional ='$preNN', precio_adulto_extranjero = '$preAE',
            precio_nino_extranjero = '$preNE', modificado_por='$usuario',fecha_modificacion = '$fech'
             WHERE id_habitacion_servicio=" .$id_hab_are;          
            $resultado = $conn->query($sql);
          
             if ($resultado == 1) {
                 //print_r($resultado);
                $objeto = 24;
                $accionese = "Actualización de una habitación/área";
                $descp = "habitación/área editada correctamente";
                require_once("../modelo/conexionbd.php");
                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar->bind_Param("sssii", $accionese, $descp, $fech, $idusuario, $objeto);
                $llamar->execute();
                $llamar->close();
               $res['msj'] = "La habitación/Área se  Edito  Correctamente";
           } else {
               $res['msj'] = "Se produjo un error al momento de Editar la habitación/área ";
               $res['error'] = true;
           }
       } else {
           //print_r($id_inventario);
           $res['msj'] = "Las variables no estan definidas";
           $res['error'] = true;
       }
   break;
   case 'eliminarHabServ':
       if (isset($_POST['id_habiSer'])) {
           $idhabitaserv = $_POST['id_habiSer'];
           $sql = "UPDATE tbl_habitacion_servicio SET estado_eliminado = 0 WHERE id_habitacion_servicio = " . $idhabitaserv;
           $resultado = $conn->query($sql);
           if ($resultado == 1) {

                $objeto = 24;
                $accionese = "Ekiminación de una habitación/área";
                $descp = "habitación/área eliminada correctamente";
                require_once("../modelo/conexionbd.php");
                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar->bind_Param("sssii", $accionese, $descp, $fech, $idusuario, $objeto);
                $llamar->execute();
                $llamar->close();
               $res['msj'] = "Habitación/área Eliminada  Correctamente";
           } else {
               $res['msj'] = "Se produjo un error al momento de eliminar el habitacion/area";
               $res['error'] = true;
           }
       } else {
           $res['msj'] = "No se envió el id del habitacion/area a eliminar";
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