<?php
//
$usuario = $_POST["usuario"];

//INFO CORREO
$correo = $_POST["correo"];
$puertoCorreo = $_POST["puertoCorreo"];
//$ = $_POST[""];
//$ = $_POST[""];

//INFO BD
$host = $_POST["host"];
$puertoBD = $_POST["puertoBD"];
$nombreBD = $_POST["nombreBD"];
//$ = $_POST[""];

//INFO SISTEMA
$nombreOrganizacion = $_POST["nombreOrganizacion"];
$nombreSistema = $_POST["nombreSistema"];
$usuarioAdministrador = $_POST["usuarioAdministrador"];
//$ = $_POST[""];

if(!empty($correo) || !empty($puertoCorreo) || !empty($usuario)){

    include("../modelo/conexionbd.php");
    $verificarUsuario = $conn->prepare("SELECT FROM WHERE nombre_usuario = ?");
    $verificarUsuario->bind_Param("",);
    $verificarUsuario->execute();
    $verificarUsuario->bind_Result();

    if(){
        $respuestaCorreo = array(
            "" => ""
        );
    }

    echo json_encode($respuestaCorreo);
}


if(!empty($host) || !empty($puertoBD) || !empty($nombreBD)){

    include("../modelo/conexionbd.php");
    $verificarUsuario = $conn->prepare("SELECT FROM WHERE nombre_usuario = ?");
    $verificarUsuario->bind_Param("",);
    $verificarUsuario->execute();
    $verificarUsuario->bind_Result();

    if(){
        $respuestaBD = array(
            "" => ""
        );
    }

    echo json_encode($respuestaBD);
}


if(!empty($nombreOrganizacion) || !empty($nombreSistema) || !empty($usuarioAdministrador)){

    include("../modelo/conexionbd.php");
    $verificarUsuario = $conn->prepare("SELECT FROM WHERE nombre_usuario = ?");
    $verificarUsuario->bind_Param("",);
    $verificarUsuario->execute();
    $verificarUsuario->bind_Result();
    
    if(){
        $respuestaSistema = array(
            "" => ""
        );
    }

    echo json_encode($respuestaSistema);
}