<?php
include ('../modelo/conexionbd.php');

$correoBuscar = $_POST['correoBuscar'];

if(!empty($correoBuscar)){

    $query2 = "SELECT id_usuario FROM tbl_usuarios WHERE correo = '$correoBuscar';";
    $resultado2 = mysqli_query($conn, $query2);

    $json2 = array();
    while($consulta2 = mysqli_fetch_array($resultado2)){
        $json2[] = array(
            'id_usuario' => $consulta2['id_usuario']
        );
    }
}

echo json_encode($json2);