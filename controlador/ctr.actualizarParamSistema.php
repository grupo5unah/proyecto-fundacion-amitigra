<?php
//INFO SISTEMA
$usuario = $_POST["usuario"];
$nombreOrganizacion = $_POST["nombreOrganizacion"];
$nombreSistema = $_POST["nombreSistema"];
$usuarioAdministrador = $_POST["usuarioAdministrador"];
$contrasena2 = $_POST["contrasena2"];
//$ = $_POST[""];
//ACTUALIZAR PARAMETROS DEL SISTEMA
if(!empty($nombreOrganizacion) || !empty($nombreSistema) || !empty($usuarioAdministrador)){

    include("../modelo/conexionbd.php");
    $verificarUsuario3 = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
    $verificarUsuario3->bind_Param("s", $usuario);
    $verificarUsuario3->execute();
    $verificarUsuario3->bind_Result($contrasenaUsuario3);
 
    if($verificarUsuario3->affected_rows){
        $existe3 = $verificarUsuario3->fetch();

        if($existe3){

            if(password_verify($contrasena2, $contrasenaUsuario3)){

                $Norganizacion = "NOMBRE_ORGANIZACION";
                $Nsistema = "NOMBRE_SISTEMA";
                $Uadministrador = "USUARIO_ADMIN";

                include "../modelo/conexionbd.php";
                $ActualizarParam3 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam3->bind_Param("ss", $nombreOrganizacion, $Norganizacion);
                $ActualizarParam3->execute();

                $ActualizarParam3 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam3->bind_Param("ss", $nombreSistema, $Nsistema);
                $ActualizarParam3->execute();

                $ActualizarParam3 = $conn->prepare("UPDATE tbl_parametros
                                                    SET valor = ?
                                                    WHERE parametro = ?;");
                $ActualizarParam3->bind_Param("ss", $usuarioAdministrador, $Uadministrador);
                $ActualizarParam3->execute();
                
                if(!$ActualizarParam3->error){
                    $respuestaSistema = array(
                        "respuesta" => "exito"
                    );
                }else{
                    $respuestaSistema = array(
                        "respuesta" => "error"
                    );
                }
                
            }else{
                $respuestaSistema = array(
                    "respuesta" => "error_contrasena"
                );
            }
        }
    }

    echo json_encode($respuestaSistema);
}