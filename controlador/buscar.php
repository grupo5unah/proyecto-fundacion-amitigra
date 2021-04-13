<?php
include ('../modelo/conexionbd.php');

$usuarioBuscar = $_POST['usuarioBuscar'];
//$correoBuscar = $_POST['correoBuscar'];

if(!empty($usuarioBuscar)){

    $query = "SELECT nombre_completo FROM tbl_usuarios WHERE nombre_usuario = '$usuarioBuscar';";
    $resultado = mysqli_query($conn, $query);

    $json = array();
    while($consulta = mysqli_fetch_array($resultado)){
        $json[] = array(
            'nombre_completo' => $consulta['nombre_completo']
        );
    }

}
echo json_encode($json);