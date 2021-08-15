<?php

require ("../modelo/conexionbd.php");

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_final = $_POST['fecha_final'];

if(!empty($fecha_inicio) || !empty($fecha_final)){
    
    $eliminarRegistro = $conn->prepare("DELETE FROM tbl_bitacora
                                        WHERE  fecha_creacion BETWEEN $fecha_inicio AND $fecha_final");
    $eliminarRegistro->bind_Param();
    $eliminarRegistro->execute();


    if(!$eliminarRegistro->error){

        $respuesta = array (
            'respuesta' => 'eliminar_bitacora'
        );

    } else {

    }
}else {

    $respuesta = array(
        'respuesta' => 'no_datos'
    );

}

json_encode($respuesta);