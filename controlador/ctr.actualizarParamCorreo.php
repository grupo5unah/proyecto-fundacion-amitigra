<?php
//INFO CORREO
$usuario = $_POST["usuario"];
$contrasena = $_POST["contrasena"];
$correo = $_POST["correo"];
$puertoCorreo = $_POST["puertoCorreo"];
//$ = $_POST[""];
//$ = $_POST[""];

//ACTUALIZAR PARAMETROS DEL CORREO
if(!empty($correo) || !empty($puertoCorreo) || !empty($usuario)){

    include("../modelo/conexionbd.php");
    $verificarUsuario1 = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
    $verificarUsuario1->bind_Param("s",$usuario);
    $verificarUsuario1->execute();
    $verificarUsuario1->bind_Result($contrasenaUsuario1);

    if($verificarUsuario1->affected_rows){
        $existe1 = $verificarUsuario1->fetch();

        if($existe1){

            if(password_verify($contrasena, $contrasenaUsuario1)){

                $Scorreo = "CORREO_SISTEMA";
                $Pcorreo = "PUERTO_CORREO";

                include "../modelo/conexionbd.php";
                $ActualizarParam1 = $conn->prepare("UPDATE tbl_parametros 
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam1->bind_Param("ss", $correo, $Scorreo);
                $ActualizarParam1->execute();

                $ActualizarParam1 = $conn->prepare("UPDATE tbl_parametros 
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam1->bind_Param("ss", $puertoCorreo, $Pcorreo);
                $ActualizarParam1->execute();
                
                if(!$ActualizarParam1->error){
                    $respuestaCorreo = array(
                        "respuesta" => "exito"
                    );
                }else{
                    $respuestaCorreo = array(
                        "respuesta" => "error"
                    );
                }
                
            } else {
                $respuestaCorreo = array(
                    "respuesta" => "error_contrasena"
                );
            }
        }
    }

    echo json_encode($respuestaCorreo);
}