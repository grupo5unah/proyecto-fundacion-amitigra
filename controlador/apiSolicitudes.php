<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
      

    case 'registrarSolicitud': // REGISTRAR UNA SOLICITUD
        $nombreCompleto = $_POST['nombreCompleto'];
        $identidad = $_POST['identidad'];
        $telefono = $_POST['telefono'];
        $croquis = $_POST['croquis'];
        $recibo = $_POST['recibo'];
        $tipo_nac = $_POST['tipo_nac'];
        $tipo = $_POST['tipo'];
        $estatus_solicitud = $_POST['estatus_solicitud'];
        $usuario_actual = $_POST['usuario_actual'];
        $usuario = $_SESSION['usuario'];

        //Fecha ACTUAL del sistema
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        //Genera la fecha del proximo mes
        $fecha_actual = new DateTime($fecha);
        $fecha_actual->modify('next month');
        $vencimiento = $fecha_actual->format('Y-m-d H:i:s');

        if (
            empty($_POST['nombreCompleto']) || empty($_POST['identidad'])  || empty($_POST['telefono'])
            || empty($_POST['croquis']) || empty($_POST['recibo']) || empty($_POST['tipo_nac'])
            || empty($_POST['tipo']) || empty($_POST['estatus_solicitud'])
        ) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

                    try {

                        // select para ver si existe el cliente de acuerdo al numero de identidad
                        $consult = mysqli_query($conn, "SELECT id_cliente,nombre_completo,telefono,nac.nacionalidad 
                        FROM tbl_clientes cli JOIN tbl_tipo_nacionalidad nac 
                        ON cli.tipo_nacionalidad=nac.id_tipo_nacionalidad WHERE identidad = $identidad");
                        $result = mysqli_fetch_array($consult);

                        if($result > 1){
                            $id_clientecap = $result['id_cliente'];
                        }

                         //Capturar el id_usuario 
                         $consulta_id = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                         WHERE nombre_usuario= '$usuario'");
                         $resultado = mysqli_fetch_array($consulta_id);

                         IF($resultado > 0){
                            $id_usercap = $resultado['id_usuario'];
                         }

                          //insertamos cuando ya tenemos el cliente en la variable y que no exista en solicitudes        
             
                    
                        $sql = $conn->prepare("INSERT INTO tbl_solicitudes(fecha_solicitud,recibo,cliente_id,usuario_id,estatus_solicitud,
                        tipo_solicitud,creado_por,fecha_creacion,modificado_por,fecha_modificacion) 
                        VALUES (?,?,?,?,?,?,?,?,?,?)");
                        $sql->bind_param(
                            "siiiiissss",
                            $fecha,
                            $recibo,
                            $id_clientecap,
                            $id_usercap,
                            $$estatus_solicitud,
                            $tipo,
                            $usuario,
                            $fecha,
                            $usuario,
                            $fecha
                            
                                   
                           
                        );
                        $sql->execute();

                        if ($sql->error) {
                            $res['msj'] = "Se produjo un error al momento de registrar la solicitud";
                            $res['error'] = true;
                        } else {
                            $res['msj'] = "Solicitud Registrada Correctamente";
                        }
                        // $sql->close();
                        // $sql = null;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
               
            }
        
        break;
    case 'actualizarSolicitud':

        if (
            isset(($_POST['id_solicitud'])) && isset($_POST['estatus_solicitud']) && isset($_POST['tipo_solicitud']) 
           
        ) {
            $id_solicitud = (int)$_POST['id_solicitud'];
            $estatus_solicitud = $_POST['estatus_solicitud'];
            $tipo_solicitud = $_POST['tipo_solicitud'];               
            

            $sql = "UPDATE tbl_solicitudes SET estatus_solicitud=$estatus_solicitud , tipo_solicitud =  $tipo_solicitud
           
            WHERE id_solicitud=" . $id_solicitud;

            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                //print_r($resultado);
                $res['msj'] = "La solicitud se ha editado correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de editar la solicitud ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;

    case 'eliminarSolicitud':
        if (isset($_POST['id_solicitud'])) {
            $id_solicitud = $_POST['id_solicitud'];
           
            $sql = " DELETE FROM tbl_solicitudes WHERE id_solicitud = " . $id_solicitud;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "La solicitud se ha eliminado correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar la solicitud";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
        break;


    default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
