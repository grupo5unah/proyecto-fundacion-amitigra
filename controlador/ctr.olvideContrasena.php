<?php 

    class OlvideContrasena{

        public function ctrOlvideContrasena(){

            require '../../funciones/config_serverMail.php';
            require '../../funciones/gen-tkn.php';
            require '../../modelo/conexionbd.php';

            if(isset($_POST['tipo_correo']) == 'recuperarCorreo') {
                $correo = $_POST['email'];

                date_default_timezone_set("America/Tegucigalpa");
                //require_once('config/config.php');
                $VerificarUsuario = $conn->prepare("SELECT id_usuario
                                                    FROM tbl_usuarios
                                                    WHERE correo = ?; ");
                $VerificarUsuario->bind_param("s", $correo);
                $VerificarUsuario->execute();
                $VerificarUsuario->bind_Result($id_usuario);
                //$id = $stmt->bind_Result($id_usuario);

                if($VerificarUsuario->affected_rows) {
                    $existe = $VerificarUsuario->fetch();
                    //Capturar el ID del usuario al que se le enviara el correo
                while ($VerificarUsuario->fetch()) {
                    $id = $id_usuario;
               }
                    if($existe){
                        if(!isset($_COOKIE['_unp_'])) {
                            $correo = $_POST['email'];
                            
                            date_default_timezone_set("America/Tegucigalpa");

                            $mail->addAddress($_POST['email']);
                            $tkn = getToken(32);
                            $encode_token = base64_encode(urlencode($tkn));
                            $email = base64_encode(urlencode($correo));
                            $expire_date = date("Y-m-d H:i:s", time() + 60 * 2);
                            $expire_date = base64_encode(urlencode($expire_date));
                            
                            //Se incluye la CONEXION
                            require_once('../../modelo/conexionbd.php');
                            $stmt1 = $conn->prepare("UPDATE tbl_usuarios SET token = '$tkn' WHERE id_usuario = ?;");
                            $stmt1->bind_Param('i', $id_usuario);
                            $stmt1->execute();

                            if($stmt1->error) {
                                die("error en la conexion" . mysqli_error($conn));
                            } else {
                                $mail->Subject = "Confirmacion cambio de contrasena Fundacion AMITIGRA";
                                $mail->Body = "<h4>Se solicitó recientemente cambiar la contraseña de su cuenta.</h4>
                                            <p>Si usted ha solicitado el cambio de contraseña, pulse el siguiente enlace para establecer una nueva contraseña:</p>
                                            <a href='localhost/proyectos/proyecto-fundacion-amitigra/vista/modulos/nueva_contrasena.php?eid={$correo}&tkn={$encode_token}&exd={$expire_date}'>Haga clic aquí para cambiar su contraseña</a>
                                            <p>De no ser asi ignore el enlace</p>
                                            <p> <spam><strong>Nota:<strong></spam> este enlace es válido por 24 horas, puedes solicitar otro cambio de contraseña una vez a pasado el tiempo estipulado.</p>";

                                if($mail->send()) {
                                    echo '<script>
                                                if (window.history.replaceState){
                                                window.history.replaceState(null, null, window.location.href);
                                                }
                                            </script>';
                                    setcookie('_unp_', getToken(16), time() + 60 * 2, '', '', '', true);
                                  
                                    //echo $id;
                                    echo "<div class='text-center alert alert-success' role = 'alert'>
                                            Verifique su correo electrónico para el enlace de restablecimiento de contraseña.
                                            </div>";
                                }
                            }
                        } else {
                          
                            echo "<div class='text-center alert alert-warning' role = 'alert'>
                                    Debe esperar al menos 20 minutos para otra solicitud.
                                    </div>";
                        }
                    }else{
                    
                    echo "<div class='text-center alert alert-danger' role = 'alert'>
                        Correo o nombre de usuario no encontrado.
                        </div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                            ¡Lo siento! el usuario no fue encontrado.
                            </div>";
                }
                $VerificarUsuario->close();
                $VerificarUsuario = null;
            }
        }


        public function ctrRecuPregunta(){

            if (isset($_POST['tipo_pregunta']) == 'recuperarPregunta'){
                $correo = $_POST['email'];
    
                include("../../modelo/conexionbd.php");
                $consultarPregunta = $conn->prepare("SELECT correo FROM tbl_usuarios WHERE correo = ?;");
                $consultarPregunta->bind_Param("s",$correo);
                $consultarPregunta->execute();
                $consultarPregunta->bind_Result($correo_electronico);
    
                if ($consultarPregunta->affected_rows){
                    $existePregunta = $consultarPregunta->fetch();
    
                    while($consultarPregunta->fetch()){
                        $mi_correo = $correo_electronico;
                    }
    
                    if($existePregunta){
                        echo "<div class='alert alert-success' role ='alert'>
                                Bien hecho, en un momento te redirigimos al cambio de contrasena.
                                </div>";
    
                        sleep(3);
    
                        if(isset($correo_electronico)){
                            session_start();
                            $_SESSION['correo'] = $correo_electronico;
                            echo '<script type="text/javascript">
                                    location.href="recupregunta.php";
                                    </script>';
                        }
    
                    } else {
                        echo "<div class='text-center alert alert-danger' role='alert'>
                                No existe el usuario con correo.
                                </div>";
                    }
                }
    
            }
        }
    }