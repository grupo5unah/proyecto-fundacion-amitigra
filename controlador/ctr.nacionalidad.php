<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    
    case 'actualizarNacionalidad': //realizar una nueva  nacionalidad      
        if(isset($_POST['id_tipo_nacionalidad']) && isset($_POST['nacionalidad']) &&
        isset($_POST['fecha_modificacion']) && isset($_POST['modificado_por'])){

            $id_nacionalidad=$_POST['id_tipo_nacionalidad'];
            $nacionalidad=$_POST['nacionalidad'];
            date_default_timezone_set("America/Tegucigalpa");
            $Fmodificacion=date('Y-m-d H:i:s',time());
            $modificadoPor = $_POST['modificado_por'];
            

            $actualizarnacionalidad = "UPDATE tbl_tipo_nacionalidad                                 
                                set  nacionalidad='$nacionalidad', 
                                fecha_modificacion='$Fmodificacion', modificado_por='$modificadoPor'
                                WHERE id_tipo_nacionalidad=".$id_nacionalidad;
            
            $resultado=$conn->query($actualizarnacionalidad);
            if ($resultado == 1) {
                $res['msj'] = "Nacionalidad se Edito Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar la Nacionalidad ";
                $res['error'] = true;
            }
        }else{
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }               

    break; 
    case 'eliminarNacionalidad':
        if (isset($_POST['id_tipo_nacionalidad'])) {
            $id_nacionalidad = $_POST['id_tipo_nacionalidad'];
            $sql = "UPDATE tbl_tipo_nacionalidad SET estado_eliminado = 0 WHERE id_tipo_nacionalidad = " . $id_nacionalidad;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Nacionalidad Eliminada  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar la nacionalidad";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id de la nacionalidad a eliminar";
            $res['error'] = true;
        }

    break;   
    
    default:
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//header("Location: ../senderos?signup=success");
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);