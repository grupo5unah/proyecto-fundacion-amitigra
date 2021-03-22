<?php
include ('../modelo/conexionbd.php');

$usuario = $_POST['usuario'];
$correo = $_POST['correo'];

if(!empty($usuario) || !empty($correo)){

    $query = "SELECT nombre_completo FROM tbl_usuarios WHERE nombre_usuario = '$usuario' OR correo = '$correo'";
    $resultado = mysqli_query($conn, $query);

    $json = array();
    while($consulta = mysqli_fetch_array($resultado)){
        $json[] = array(
            'nombre_completo' => $consulta['nombre_completo']
        );
    }

    echo json_encode($json);

}