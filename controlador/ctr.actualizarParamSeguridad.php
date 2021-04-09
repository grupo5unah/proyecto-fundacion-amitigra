<?php
//INFO SISTEMA
$usuario = $_POST["usuario"];
$intentosSesion = $_POST["intentosSesion"];
$cantPreguntas = $_POST["cantPreguntas"];
$vigUsuario = $_POST["vigUsuario"];
$contrasena4 = $_POST["contrasena4"];
//$ = $_POST[""];
//ACTUALIZAR PARAMETROS DEL SISTEMA
if(!empty($usuario) || !empty($intentosSesion) || !empty($cantPreguntas) || !empty($vigUsuario) || !empty($contrasena)){

    include("../modelo/conexionbd.php");
    $verificarUsuario4 = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
    $verificarUsuario4->bind_Param("s", $usuario);
    $verificarUsuario4->execute();
    $verificarUsuario4->bind_Result($contrasenaUsuario4);
 
    if($verificarUsuario4->affected_rows){
        $existe4 = $verificarUsuario4->fetch();

        if($existe4){

            if(password_verify($contrasena4, $contrasenaUsuario4)){

                $ISesion = "INTENTOS_SESION";
                $CPreguntas = "CANT_PREGUNTAS";
                $VUsuario = "VIGENCIA_CUENTA";

                include "../modelo/conexionbd.php";
                $ActualizarParam4 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam4->bind_Param("ss", $intentosSesion, $ISesion);
                $ActualizarParam4->execute();

                $ActualizarParam4 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam4->bind_Param("ss", $cantPreguntas, $CPreguntas);
                $ActualizarParam4->execute();

                $ActualizarParam4 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam4->bind_Param("ss", $vigUsuario, $VUsuario);
                $ActualizarParam4->execute();
                
                if(!$ActualizarParam4->error){
                    $respuestaSeguridad = array(
                        "respuesta" => "exito"
                    );
                }else{
                    $respuestaSeguridad = array(
                        "respuesta" => "error"
                    );
                }
                
            }else{
                $respuestaSeguridad = array(
                    "respuesta" => "error_contrasena"
                );
            }
        }
    }

    echo json_encode($respuestaSeguridad);
}