<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    
    case 'actualizarTipoBoleto': //Actualizar un tipo boleto      
        if(isset($_POST['id_tipo_boleto']) && /*isset($_POST['nombre_tipo_boleto']) && */isset($_POST['precio_venta']) 
        && isset($_POST['descripcion']) && isset($_POST['fecha_modificacion']) && isset($_POST['modificado_por'])){

            $id_tipo_boleto=$_POST['id_tipo_boleto'];
            //$nombre_tipo_boleto=$_POST['nombre_tipo_boleto'];
            $precio_venta=$_POST['precio_venta'];
            $descripcion=$_POST['descripcion'];
            date_default_timezone_set("America/Tegucigalpa");
            $Fmodificacion=date('Y-m-d H:i:s',time());
            $modificadoPor = $_POST['modificado_por'];
            $user_id = $_POST['id_usuario'];  

            $actualizarTipoBoleto = "UPDATE tbl_tipo_boletos                                 
                                set   precio_venta='$precio_venta',
                                descripcion='$descripcion', fecha_modificacion='$Fmodificacion', modificado_por='$modificadoPor'
                                WHERE id_tipo_boleto=".$id_tipo_boleto;
            
            $resultado=$conn->query($actualizarTipoBoleto);
            if ($resultado == 1) {
                 //INSERTAR LA ACCION EN BITACORA
                 date_default_timezone_set("America/Tegucigalpa");
                 $fecha2=date('Y-m-d H:i:s',time());
                 $objeto = 35;
                $acciones = "Actualizacion de Precio de Boleto";
                $descp = "Se ha Actualizado el Precio de un Boleto";
                require_once("../modelo/conexionbd.php");
                $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                $llamar1->execute();
                $llamar1->close(); 
                $res['msj'] = "Tipo de Boleto se Edito Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de Editar el Tipo de Boleto";
                $res['error'] = true;
            }
        }else{
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }               

    break; 
    case 'eliminarTipoBoleto': //Eliminar un Tipo de Boleto
        if (isset($_POST['id_tipo_boleto'])) {
            $id_tipo_boleto = $_POST['id_tipo_boleto'];
            $user_id = $_POST['id_usuario'];
            $estado_eliminar = 0;
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $sql = "UPDATE tbl_tipo_boletos SET estado_eliminado = $estado_eliminar, modificado_por='$usuario_actual', fecha_modificacion='$fecha' WHERE id_tipo_boleto = " . $id_tipo_boleto;
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                 //INSERTAR LA ACCION EN BITACORA
                 date_default_timezone_set("America/Tegucigalpa");
                 $fecha2=date('Y-m-d H:i:s',time());
                 $objeto = 35;
                $acciones = "Eliminación de Tipo y Precio de Boletos";
                $descp = "Se ha eliminado un Tipo de boleto";
                require_once("../modelo/conexionbd.php");
                $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                $llamar1->execute();
                $llamar1->close();   
                $res['msj'] = "Tipo de Boleto Eliminado  Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Tipo de Boleto";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "No se envió el id del Tipo de Boleto a eliminar";
            $res['error'] = true;
        }

    break;   

    case 'registrarTipoBoleto':
        $nombreTipoBoleto= $_POST['NombreBoletoN'];
        $descripcionTB= $_POST['DescripcionN'];
        $precioVenta= $_POST['PrecioVN'];        
        $usuario_actual = $_POST['usuario_actual'];
        $estado=1;
        $user_id = $_POST['id_usuario'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());

        if(empty($_POST['NombreBoletoN']) ||empty($_POST['DescripcionN']) ||empty($_POST['PrecioVN']) ||empty($_POST['usuario_actual'])){
            
            $res['msj'] = 'Es necesario Nombre, Descripcion y Precio';
            $res['error'] = true;

        }else{
            try{
                $insertar=$conn->prepare("INSERT INTO tbl_tipo_boletos (nombre_tipo_boleto, precio_venta, descripcion, estado_eliminado,
                                creado_por,fecha_creacion, modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?);");
                $insertar->bind_param('sisissss', $nombreTipoBoleto, $precioVenta, $descripcionTB, $estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Tipo de Boleto";
                    $res['error'] = true;
                } else {
                        //INSERTAR LA ACCION EN BITACORA
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha2=date('Y-m-d H:i:s',time());
                    $objeto = 35;
                    $acciones = "Creacion de Tipo y Precio de Boletos";
                    $descp = "Se ha Creado un Nuevo Tipo de boleto" . $nombreTipoBoleto;
                    require_once("../modelo/conexionbd.php");
                    $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                    $llamar1->execute();
                    $llamar1->close();   
                    $res['msj'] = "Tipo de Boleto Registrada Correctamente";
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