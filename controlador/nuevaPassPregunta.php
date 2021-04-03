<?php

    //INPUTS
    $respuestaUsuario = $_POST["respuestaUsuario"];
    $usuario = $_POST["usuario"];
    //SELECT
    $id_pregunta = $_POST["id_pregunta"];
    $PassPregunta = $_POST["PassPregunta"];
    $ConfPassPregunta = $_POST["ConfPassPregunta"];

    if(!empty($respuestaUsuario) || !empty($id_pregunta) || !empty($PassPregunta) ||
        !empty($ConfPassPregunta || !empty($usuario))){

        //Traer la informacion del usuario
        require "../modelo/conexionbd.php";
        $verificarUsuario = $conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = ?;");
        $verificarUsuario->bind_Param("s",$usuario);
        $verificarUsuario->execute();
        $verificarUsuario->bind_Result($id_usuario);

        if ($verificarUsuario->affected_rows){
            $existeUsuario = $verificarUsuario->fetch();
            
            if($existeUsuario){
                
                //VERIFICAR RESPUESTA
                require "../modelo/conexionbd.php";
                $VerificarPreg = $conn->prepare("SELECT usuario_id, pregunta_id, respuesta
                                                FROM tbl_preguntas_usuario
                                                WHERE usuario_id = ? AND pregunta_id = ?;");
                $VerificarPreg->bind_Param("ii",$id_usuario, $id_pregunta);
                $VerificarPreg->execute();
                $VerificarPreg->bind_Result($usuario_id, $preguntas, $respuestaCorrecta);

                if($VerificarPreg->affected_rows){
                    $existeRespuesta = $VerificarPreg->fetch();

                    if($existeRespuesta){
                        //ACTUALIZAR CONTRASENA
                        
                        if($respuestaUsuario === $respuestaCorrecta){

                            $hashed_password = password_hash($PassPregunta, PASSWORD_BCRYPT);

                            if($PassPregunta === $ConfPassPregunta){

                                require "../modelo/conexionbd.php";

                                $actualizacion = $conn->prepare("UPDATE tbl_usuarios
                                                                SET contrasena = ?
                                                                WHERE id_usuario = ?;");
                                $actualizacion->bind_Param("si", $hashed_password, $id_usuario);
                                $actualizacion->execute();

                                if(!$actualizacion->error){

                                    $respuesta = array(
                                        "respuesta" => "exito"
                                    );

                                }else{
                                    $respuesta = array(
                                        "respuesta" => "error_actualizacion"
                                    );
                                }
                            }else{

                                $respuesta = array(
                                    "respuesta" => "contrasena_noCoinciden"
                                );

                            }
                        }else{
                            $respuesta = array(
                                "respuesta" => "respuesta_noCoincide"
                            );
                        }
                    }else{

                        $respuesta = array(
                            "respuesta" => "respuesta_incorrecta"
                        );
                    }
                }
            }
        }

        echo json_encode($respuesta);
    }