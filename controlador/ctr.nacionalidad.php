<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    
    case 'actualizarNacionalidad': //Editar una Nacionalidad    
        if(isset($_POST['id_tipo_nacionalidad']) && isset($_POST['nacionalidad']) &&
        isset($_POST['fecha_modificacion']) && isset($_POST['modificado_por'])){

            $id_nacionalidad=$_POST['id_tipo_nacionalidad'];
            $nacionalidad=$_POST['nacionalidad'];
            date_default_timezone_set("America/Tegucigalpa");
            $Fmodificacion=date('Y-m-d H:i:s',time());
            $modificadoPor = $_POST['modificado_por'];
            $user_id = $_POST['id_usuario'];            

            $actualizarnacionalidad = "UPDATE tbl_tipo_nacionalidad                                 
                                set  nacionalidad='$nacionalidad', 
                                fecha_modificacion='$Fmodificacion', modificado_por='$modificadoPor'
                                WHERE id_tipo_nacionalidad=".$id_nacionalidad;
            
            $resultado=$conn->query($actualizarnacionalidad);
            if ($resultado == 1) {
                //INSERTAR LA ACCION EN BITACORA
                date_default_timezone_set("America/Tegucigalpa");
                $fecha2=date('Y-m-d H:i:s',time());
                $objeto = 27;
               $acciones = "Actualizacion de Nacionalidad";
               $descp = "Se ha Actualizado la Nacionalidad " . $nacionalidad;
               require_once("../modelo/conexionbd.php");
               $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
               $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
               $llamar1->execute();
               $llamar1->close(); 

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
    case 'eliminarNacionalidad': //Eliminar una Nacionalidad
        if (isset($_POST['id_tipo_nacionalidad'])) {
            $id_nacionalidad = $_POST['id_tipo_nacionalidad'];
            $user_id = $_POST['id_usuario'];
            $estado_eliminar = 0;
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $sql = "UPDATE tbl_tipo_nacionalidad SET estado_eliminado = $estado_eliminar, modificado_por='$usuario_actual', fecha_modificacion='$fecha' WHERE id_tipo_nacionalidad = " . $id_nacionalidad;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                 //INSERTAR LA ACCION EN BITACORA
                 date_default_timezone_set("America/Tegucigalpa");
                 $fecha2=date('Y-m-d H:i:s',time());
                 $objeto = 27;
                $acciones = "Eliminación de Nacionalidad";
                $descp = "Se ha eliminado una Nacionalidad";
                require_once("../modelo/conexionbd.php");
                $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                $llamar1->execute();
                $llamar1->close();   
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

    case 'registrarNacionalidad': //Registrar una nueva Nacionalidad
        $nacionalidad= $_POST['NacionalidadN'];        
        $usuario_actual = $_POST['usuario_actual'];
        $estado=1;
        $user_id = $_POST['id_usuario'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());

        if(empty($_POST['NacionalidadN'])||empty($_POST['usuario_actual'])){
            
            $res['msj'] = 'Es necesario Nombre de la Nacionalidad';
            $res['error'] = true;

        }else{
            try{
                $insertar=$conn->prepare("INSERT INTO tbl_tipo_nacionalidad (nacionalidad, estado_eliminado,creado_por,fecha_creacion, 
                                modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?);");
                $insertar->bind_param('sissss', $nacionalidad,$estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar la Nacionalidad";
                    $res['error'] = true;
                } else {
                        //INSERTAR LA ACCION EN BITACORA
                        date_default_timezone_set("America/Tegucigalpa");
                        $fecha2=date('Y-m-d H:i:s',time());
                        $objeto = 27;
                        $acciones = "Creacion de Una Nacionalidad";
                        $descp = "Se ha Creado una Nueva Nacionalidad ". $nacionalidad;
                        require_once("../modelo/conexionbd.php");
                        $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                        $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                        $llamar1->execute();
                        $llamar1->close();   
                    $res['msj'] = "Nacionalidad Registrada Correctamente";
                }
            }catch(exception $e){
                echo $e->getMessage();
            }
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