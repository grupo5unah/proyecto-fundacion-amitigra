<?php 

    //SI LA RECUPERACION ES POR CORREO
    require '../funciones/config_serverMail.php';
    require '../funciones/gen-tkn.php';
    require '../modelo/conexionbd.php';

    $correo = $_POST["correo"];
    $idObjeto = $_POST["idObjeto"];

    if(!empty($correo) || !empty($idObjeto)) {

        date_default_timezone_set("America/Tegucigalpa");
        
        $VerificarUsuario = $conn->prepare("SELECT id_usuario, nombre_usuario
                                            FROM tbl_usuarios
                                            WHERE correo = ?; ");
        $VerificarUsuario->bind_param("s", $correo);
        $VerificarUsuario->execute();
        $VerificarUsuario->bind_Result($id_usuario, $usuario);
        //$id = $stmt->bind_Result($id_usuario);

        if($VerificarUsuario->affected_rows) {
            $existe = $VerificarUsuario->fetch();
            //Capturar el ID del usuario al que se le enviara el correo
            while ($VerificarUsuario->fetch()) {
                 $id = $id_usuario;
            }
            if($existe){
                if(!isset($_COOKIE['_unp_'])) {
                    // $correo = $_POST['email'];
                    
                    date_default_timezone_set("America/Tegucigalpa");

                    $mail->addAddress($_POST['correo']);
                    $tkn = getToken(32);
                    $encode_token = base64_encode(urlencode($tkn));
                    $email = base64_encode(urlencode($correo));
                    $expire_date = date("Y-m-d H:i:s", time() + 60 * 2);
                    $expire_date = base64_encode(urlencode($expire_date));
                    
                    //Se incluye la CONEXION
                    require_once('../modelo/conexionbd.php');
                    $stmt1 = $conn->prepare("UPDATE tbl_usuarios SET token = '$tkn' WHERE id_usuario = ?;");
                    $stmt1->bind_Param("i", $id_usuario);
                    $stmt1->execute();

                    if($stmt1->error) {
                        die("error en la conexion" . mysqli_error($conn));
                    } else {

                        $mail->Subject = "Confirmación cambio de contraseña AMITIGRA";
                        $mail->Body = "<h3>Hola: {$usuario}.</h3><h4>Se solicitó recientemente cambio de su contraseña.</h4>
                                    <p>Si usted ha solicitado el cambio de contraseña, pulse el siguiente enlace para establecer una nueva contraseña:</p>
                                    <a href='http://fundacionamitigra.com/vista/modulos/nueva_contrasena.php?eid={$correo}&tkn={$encode_token}&exd={$expire_date}'>Haga clic aquí para cambiar su contraseña</a>
                                    <p>De no ser asi ignore el enlace.</p>
                                    <p> <spam><strong>Nota:<strong></spam> este enlace es válido por 24 horas, puedes solicitar otro cambio de contraseña una vez a pasado el tiempo establecido.</p>";

                        if($mail->send()) {

                            setcookie('_unp_', getToken(16), time() + 60 * 2, '', '', '', true);

                            //ENVIO DEL CORREO PARA CAMBIO DE CONTRASENA
                            $respuesta = array(
                                "respuesta" => "exito"
                            );

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Envio de correo";
                            $descripcion = "Envio de correo para recuperación de contraseña";

                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_usuario, $idObjeto);
                            $bitacora->execute();

                        } else {

                            $respuesta = array(
                                "respuesta" => "NoEnvio"
                            );

                        }

                    }
                } else {

                    //MENSAJE POR SI EL USUARIO VUELVE A SOLICITAR UN NUEVO CAMBIO DE CONTRASENA
                    //NUEVO
                    $respuesta = array(
                        "respuesta" => "tiempo"
                    );
                }
            }else{

                //MENSAJE POR SI EL CORREO INGRESADO NO ES ENCONTRADO
                //NUEVO
                $respuesta = array(
                    "respuesta" => "no_Encontrado"
                );
            }
        } else {

            //SI EL USUARIO NO FUE ENCONTRADO
            //NUEVO
            $respuesta = array(
                "respuesta" => "usuario_no"
            );
        }
        $VerificarUsuario->close();
        $VerificarUsuario = null;
    }
        
    //FIN SI ES MEDIANTE CORREO
    echo json_encode($respuesta);