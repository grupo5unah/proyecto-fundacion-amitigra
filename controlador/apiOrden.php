<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';
$sql = "SELECT id_producto, nombre_producto from tbl_producto WHERE estado_eliminado=1 ";
        $result = $conn->query($sql);
        while ($res = mysqli_fetch_array($result)) {
            $producto[] = $array = array(
                'id_producto'=> $res['id_producto'],
                'nombre_producto'=> $res['nombre_producto']);

            };

    echo json_encode($producto);
    //print_r($producto);
        

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}


$conn->close();
header('Content-Type: application/json');


 