<?php
include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    
    case 'registrarBoletos': //realizar una venta de boletos        
            $localidad = $_POST['localidad'];
            $cant_Badultos = $_POST['boletosN'];
            $cant_Bninos = $_POST['boletosNN'];
            $precioAdulto  = $_POST['precioN'];
            $precioNino = $_POST['precioNN'];
            $totalP = $_POST['Tpagar'];
            $totalBNacional = $_POST['TboletosN'];
            $usuario_actual = $_POST['usuario_actual']; 
            $user=$_POST['id_usuario'];            
            date_default_timezone_set("America/Tegucigalpa");
            $fecha=date('Y-m-d H:i:s',time());
            $estado=1;
                    

            if(($cant_Badultos=="" && $cant_Bninos=="") || ($cant_Badultos=="0" && $cant_Bninos=="0")){
                $res['msj'] = 'Tiene que vender un Boleto Nacional';
                $res['error'] = true;
             }else{
                try{   
                    //AQUI INSERTA EN LA BASE DE DATOS EN LA TABLA TBL_BOLETOS                 
                    $inserta=$conn->prepare("INSERT INTO tbl_boletos (cantidad_total_boletos, total_cobrado, estado_eliminado, creado_por, fecha_creacion, modificado_por, 
                                            fecha_modificacion) VALUES(?,?,?,?,?,?,?)");
                    $inserta->bind_param('iiissss',$totalBNacional, $totalP, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                    $inserta->execute();

                    if($cant_Badultos>0){
                    //se captura el id de la tabla tbl_boletos recien creado  
                                        
                        $captura1=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                        $captura1->bind_Param("i", $totalP);                   
                        $captura1->execute();
                        $captura1->bind_result($idbv);

                        if($captura1->affected_rows)
                        $id_cobrado= $captura1->fetch();

                        while ($captura1->fetch()) {
                            $idboleven = $idbv;
                        }
                            if($id_cobrado){                            
                                
                                //inserta en la tabla tbl_boletos_detalle por boletos adultos nacional vendidos                               
                                $nacionalidad=1;           
                                $tipo_boleto=1;
                                $subtotal=$cant_Badultos*$precioAdulto;
                                $insert=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, localidad_id, boletos_vendidos_id,
                                                    estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                $insert->bind_param('iiiiiiiissss',$cant_Badultos, $subtotal, $nacionalidad, $user, $tipo_boleto, $localidad, $idbv, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                $insert->execute();                            
                            
                            }                  
                        }

                        if($cant_Bninos>0){
                            //se captura el id de la tabla tbl_boletos recien creado    
                            
                                $captura=$conn->prepare("SELECT id_boletos_vendidos FROM tbl_boletos WHERE total_cobrado=?;");        
                                $captura->bind_Param("i", $totalP);                   
                                $captura->execute();
                                $captura->bind_result($idbv);
            
                                if($captura->affected_rows)
                                $id_cobradoN= $captura->fetch();
            
                                while ($captura->fetch()) {
                                    $idbolevenN = $idbv;
                                }
                                    if($id_cobradoN){                            
                                        
                                        //inserta en la tabla tbl_boletos_detalle por boletos ninos nacional vendidos
                                        $nacionalidad=1;           
                                        $tipo_boleto=2;
                                        $subtotalN=$cant_Bninos*$precioNino;
                                        $insertN=$conn->prepare("INSERT INTO tbl_boletos_detalle (cantidad_boletos, sub_total, tipo_nacionalidad_id, usuario_id, tipo_boleto_id, localidad_id, boletos_vendidos_id,
                                                                estado_eliminado, creado_por, fecha_creacion, modificado_por, fecha_modificacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                                        $insertN->bind_param('iiiiiiiissss',$cant_Bninos, $subtotalN, $nacionalidad, $user, $tipo_boleto, $localidad, $idbv, $estado, $usuario_actual, $fecha, $usuario_actual, $fecha);
                                        $insertN->execute();                            
                                    
                                    }                   
                            }                    
                    if ($inserta->error){
                        $res['msj'] = "Se produjo un error al momento de vender el boleto";
                        $res['error'] = true;
                    } else {
                        $res['msj'] = "los Boletos se Registraron Correctamente"; 
                                                             
                    }
                    
                }catch(Exception $e){
                    echo $e->getMessage();
                }
                
                

            }    

    break;    

    case 'eliminarBoleto':
        if (isset($_POST['id_boletos_vendidos'])) {            
            $id_boletos_vendidos = $_POST['id_boletos_vendidos'];            
            $sql = "UPDATE tbl_boletos SET estado_eliminado = 0 WHERE id_boletos_vendidos = " . $id_boletos_vendidos;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
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