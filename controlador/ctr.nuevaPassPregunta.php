<?php

class NuevaPassPregunta{

    //VERIFICA SI LA RESPUESTA ES CORRECTA
    public function ctrNuevaPassPregunta(){

        global $conn;
        
        if(isset($_POST['tipo']) == 'newpassword'){
            $idPregunta = $_POST['pregunta_id'];
            $correo = $_SESSION['correo'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];


            //Traer la informacion del usuario
            require "../../modelo/conexionbd.php";
            $verificarUsuario = $conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE correo = ?;");
            $verificarUsuario->bind_Param("s",$correo);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($id_usuario);

            if ($verificarUsuario->affected_rows){
                $existeUsuario = $verificarUsuario->fetch();

                while($verificarUsuario->fetch()){
                    global $id;
                    $id = $id_usuario;
                }
                
                if($existeUsuario){
                    
                    //VERIFICAR RESPUESTA
                    require "../../modelo/conexionbd.php";
                    $VerificarPreg = $conn->prepare("SELECT usuario_id, pregunta_id, respuesta
                                                    FROM tbl_preguntas_usuario
                                                    WHERE usuario_id = ? AND pregunta_id = ?;");
                    $VerificarPreg->bind_Param("ii",$id_usuario, $idPregunta);
                    $VerificarPreg->execute();
                    $VerificarPreg->bind_Result($usuario_id, $preguntas, $respuestaCorrecta);

                    if($VerificarPreg->affected_rows){
                        $existeRespuesta = $VerificarPreg->fetch();

                        if($existeRespuesta){
                            $respuesta = $_POST['RespuestaValidar'];
                            //ACTUALIZAR CONTRASENA
                            
                            if($respuesta === $respuestaCorrecta){

                                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                                if($password == $password2){

                                    require "../../modelo/conexionbd.php";

                                    $actualizacion = $conn->prepare("UPDATE tbl_usuarios SET contrasena = ? WHERE id_usuario = ?;");
                                    $actualizacion->bind_Param("si", $hashed_password, $id_usuario);
                                    $actualizacion->execute();

                                    if(!$actualizacion->error){
                                        echo "<div class='alert alert-success' role='alert'>
                                                Su contraseña se actualizó correctamente.
                                                </div>
                                                <script>
                                                window.setTimeout(function(){
                                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                                function(){
                                                $(this).remove();
                                                });
                                                }, 3000);
                                                </script>";
                                    }
                                }else{
                                    echo "<div class='alert alert-danger' role='alert'>
                                            Las contraseña no coinciden.
                                            </div>
                                            <script>
                                            window.setTimeout(function(){
                                            $('.alert').fadeTo(1500,00).slideDown(1000,
                                            function(){
                                            $(this).remove();
                                            });
                                            }, 3000);
                                            </script>";
                                }
                            }
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Respuesta incorrecta.
                            </div>
                            <script>
                            window.setTimeout(function(){
                            $('.alert').fadeTo(1500,00).slideDown(1000,
                            function(){
                            $(this).remove();
                            });
                            }, 3000);
                            </script>";
                            echo 'Id usuario: '. $id_usuario;
                            echo 'Id pregunta:'. $idPregunta;
                        }
                    }
                }
            }
        }
    }
}