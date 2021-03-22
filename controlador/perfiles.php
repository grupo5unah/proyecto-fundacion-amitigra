<?php
include ('../modelo/conexionbd.php');

$usuario = $_POST['usuario'];

if(!empty($usuario)){
    
    $password = 'Admin@12345';
    
    $query = "SELECT contrasena, nombre_completo, id_usuario FROM tbl_usuarios WHERE nombre_usuario = '$usuario'";
    $resultado = mysqli_query($conn, $query);

    $json = array();
    while($consulta = mysqli_fetch_array($resultado)){
        if(password_verify($password, $consulta['contrasena'])){
            $json[] = array(
                'nombre_completo' => $consulta['nombre_completo'],
                'id_usuario' => $consulta['id_usuario'],
                'bien' => 'bien',
                'error' => 'Lo sentimos hubo un error'
            );
        }
        
       
    }

    echo json_encode($json);
}