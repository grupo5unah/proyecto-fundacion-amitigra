<?php

include "../modelo/conexionbd.php";

$correo = $_POST["correo"];

if(!empty($correo)){

    $verificar = $conn->prepare("SELECT nombre_usuario FROM tbl_usuarios WHERE correo = ?;");
    $verificar->bind_Param("s", $correo);
    $verificar->execute();
    $verificar->bind_Result($usuario);

    if($verificar->affected_rows){
        $existe = $verificar->fetch();

        if($existe){
            
            session_start();
            $_SESSION["usuario"] = strtoupper($usuario);

            $respuesta = array(
                "respuesta" => "exito"
            );

        }else{
            $respuesta = array(
                "respuesta" => "no_existe"
            );
        }
    }

    echo json_encode($respuesta);
}