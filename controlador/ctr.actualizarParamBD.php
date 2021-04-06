<?php
//INFO BD
$usuario = $_POST["usuario"];
$host = $_POST["host"];
$puertoBD = $_POST["puertoBD"];
$nombreBD = $_POST["nombreBD"];
$contrasena1 = $_POST["contrasena1"];
//$ = $_POST[""];
//ACTUALIZAR PARAMETROS DE LA BASE DE DATOS
if(!empty($host) || !empty($puertoBD) || !empty($nombreBD)){

    include("../modelo/conexionbd.php");
    $verificarUsuario2 = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
    $verificarUsuario2->bind_Param("s",$usuario);
    $verificarUsuario2->execute();
    $verificarUsuario2->bind_Result($contrasenaUsuario2);

    if($verificarUsuario2->affected_rows){
        $existe2 = $verificarUsuario2->fetch();

        if($existe2){

            if(password_verify($contrasena1, $contrasenaUsuario2)){

                $hostBD = "HOST_HOSPEDADOR";
                $Pbd = "PUERTO_DATABASE";
                $Nbd = "NOMBRE_DATABASE";

                include "../modelo/conexionbd.php";
                $ActualizarParam2 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam2->bind_Param("ss",$host, $hostBD);
                $ActualizarParam2->execute();

                $ActualizarParam2 = $conn->prepare("UPDATE tbl_parametros 
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam2->bind_Param("ss", $puertoBD, $Pbd);
                $ActualizarParam2->execute();

                $ActualizarParam2 = $conn->prepare("UPDATE tbl_parametros 
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam2->bind_Param("ss", $nombreBD, $Nbd);
                $ActualizarParam2->execute();
                
                if(!$ActualizarParam2->error){
                    $respuestaBD = array(
                        "respuesta" => "exito"
                    );
                }else{
                    $respuestaBD = array(
                        "respuesta" => "error"
                    );
                }
                
            }
        }
    } else {
        $respuestaBD = array(
            "respuesta" => "error_contrasena"
        );
    }

    echo json_encode($respuestaBD);
}