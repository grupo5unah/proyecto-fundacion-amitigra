<?php
//INFO SISTEMA
$usuario = $_POST["usuario"];
$mostrarSolicitudes = $_POST["mostrarSolicitudes"];
$contrasena5 = $_POST["contrasena5"];
//$ = $_POST[""];
//ACTUALIZAR PARAMETROS DEL SISTEMA
if(!empty($usuario) || !empty($mostrarSolicitudes) || !empty($contrasena5)){

    include("../modelo/conexionbd.php");
    $verificarUsuario5 = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
    $verificarUsuario5->bind_Param("s", $usuario);
    $verificarUsuario5->execute();
    $verificarUsuario5->bind_Result($contrasenaUsuario5);
 
    if($verificarUsuario5->affected_rows){
        $existe5 = $verificarUsuario5->fetch();

        if($existe5){

            if(password_verify($contrasena5, $contrasenaUsuario5)){

                $MSolicitudes = "MOSTRAR_SOLICITUDES";

                include "../modelo/conexionbd.php";
                $ActualizarParam5 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam5->bind_Param("ss", $mostrarSolicitudes, $MSolicitudes);
                $ActualizarParam5->execute();

                if(!$ActualizarParam5->error){
                    $respuestaSolicitudes = array(
                        "respuesta" => "exito"
                    );
                }else{
                    $respuestaSolicitudes = array(
                        "respuesta" => "error"
                    );
                }
                
            }else{
                $respuestaSolicitudes = array(
                    "respuesta" => "error_contrasena"
                );
            }
        }
    }

    echo json_encode($respuestaSolicitudes);
}