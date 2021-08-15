<?php
include_once "../modelo/conexionbd.php";
//INSERTAR PARA BOLETOS
if(isset($_POST['action']) == 'registrartickets'){
    $conte = json_decode($_POST['conteBoletos']);
    $totalBoletos = $_POST['TotalBoletos'];
    $totalPagar = $_POST['TotalPagar'];
    $id_usuario = $_POST['idusuario'];
    $usuario_actual= $_POST['usuario_actual'];           
    date_default_timezone_set("America/Tegucigalpa");
    $fecha=date('Y-m-d H:i:s',time());
    $estado=1;
    

    if(!empty($_POST['conteBoletos']) ||!empty($id_usuario)||!empty($usuario_actual)){

        try{
                     //include_once "../modelo/conexionbd.php"; 
                    $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, estado_eliminado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                    $inserta->bind_param('iiissss',$totalBoletos, $totalPagar, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $inserta->execute();
                    
                    
                    //se captura el id de la tabla tbl_boletos recien creado  
                         //include_once "../modelo/conexionbd.php";          
                         $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                        $captura1->bind_Param("i", $totalPagar);                   
                        $captura1->execute();
                        $captura1->bind_result($idbv);

                        if($captura1->affected_rows){
                        $id_cobrado= $captura1->fetch();

                        while ($captura1->fetch()) {
                            $idboleven = $idbv;
                        }
                            if($id_cobrado){      
                                
                                        //inserta en la tabla tbl_boletos_detalle por boletos adultos nacional vendidos                               
                                        $nacionalidad=1;
                                        $insert=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, localidad_id, boletos_vendidos_id,
                                                            estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                                            foreach($conte as $valor){
                                                                $cantidad = $valor->CantBoleto;
                                                                $TipoBoletoS = $valor->TipoBoletoS;
                                                                $Localidad = $valor->Localidad;
                                                                $subtotal = $valor->totalPB;
                                                                
                                                            
                                        $insert->bind_param('iiiiiiiissss',$cantidad, $subtotal, $nacionalidad, $id_usuario, $TipoBoletoS, $Localidad, $idbv, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                        $insert->execute();    
                                                            }
                                                 }      
                }
               
                if (!$inserta->error){
                                     
                     //Registra en la BITACORA la accion realizada
                     date_default_timezone_set("America/Tegucigalpa");
                     $fecha2=date('Y-m-d H:i:s',time());
                     $objeto = 7;
                    $acciones = "Venta de Boletos";
                    $descp = "Nueva Venta de Boletos Con Orden No. " . $idbv;
                    require_once("../modelo/conexionbd.php");
                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha2, $id_usuario, $objeto);
                    $llamar->execute();
                    $llamar->close();  

                    $respuesta= array("respuesta"=>"exito");         
                } else {
                    $respuesta= array("respuesta"=>"fallo");                                         
                    }   
        }catch(Exception $e){
        echo $e->getMessage();
        }   
         
    }else{
        $respuesta = array (
            "respuesta"=>"error"
        );
    }
    echo json_encode($respuesta);
}

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){     
   
    case 'eliminarBoleto':
        if (isset($_POST['id_boletos_vendidos'])) {            
            $id_boletos_vendidos = $_POST['id_boletos_vendidos'];     
            $user_id = $_POST['id_usuario'];
            $estado_eliminar = 0;
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            $sql = "UPDATE tbl_boletos SET estado_eliminado = $estado_eliminar, modificado_por='$usuario_actual', fecha_modificacion='$fecha' WHERE id_boletos_vendidos = " . $id_boletos_vendidos;
            $resultado = $conn->query($sql);
            
            if ($resultado == 1) {                 
               
                 //INSERTAR LA ACCION EN BITACORA
                date_default_timezone_set("America/Tegucigalpa");
                     $fecha2=date('Y-m-d H:i:s',time());
                     $objeto = 7;
                    $acciones = "Eliminación de Boletos";
                    $descp = "Se ha eliminado la Orden de Venta No ". $id_boletos_vendidos;
                    require_once("../modelo/conexionbd.php");
                    $llamar1 = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $llamar1->bind_Param("sssii", $acciones, $descp, $fecha2, $user_id, $objeto);
                    $llamar1->execute();
                    $llamar1->close();    
                    $res['msj'] = "Factura de Boleto(s) Eliminado(s)  Correctamente";  
            } else {
               
                $res['msj'] = "Se produjo un error al momento de eliminar la factura";
                $res['error'] = true;                
            }
                
        } else {
            $res['msj'] = "No se envió el id de la Factura a eliminar";
            $res['error'] = true;
        }
        
    break;   

    case 'traerDetallesB':
        $factura = $_GET['idbolvendido'];
        try {

            $sql =  "SELECT cantidad_boletos, sub_total, tbl_tipo_boletos.nombre_tipo_boleto, tbl_tipo_boletos.precio_venta, tbl_tipo_boletos.descripcion
            FROM tbl_boletos_detalle            
            INNER JOIN tbl_tipo_boletos
            ON tbl_boletos_detalle.tipo_boleto_id=tbl_tipo_boletos.id_tipo_boleto
            INNER JOIN tbl_boletos
            ON tbl_boletos_detalle.boletos_vendidos_id=tbl_boletos.id_boletos_vendidos           
            WHERE tbl_boletos.id_boletos_vendidos = $factura";                           
            
            $result = $conn->query($sql);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $vertbl = array();
        while ($eventos = $result->fetch_assoc()) {
            $evento = array(               
                'cantidad' => $eventos['cantidad_boletos'],
                'NombreBoleto' => $eventos['nombre_tipo_boleto'],
                'precio' => $eventos['precio_venta'],
                'subtotal' => $eventos['sub_total'],
                'moneda' => $eventos['descripcion'],
               
                
            );
            array_push($vertbl, $evento);
        }
        $res['boletos'] = $vertbl;

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
