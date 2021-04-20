<?php
    //Conexion a la base de datos
    //include "conexion2.php";
    global $conn;

    $server = 'localhost';
    $user_name = 'root';
    $pass = '';
    $data_base = 'fundacion_amitigra';
    //$puerto = $PPdatabase["valor"];

    try{
        $conn = new mysqli($server, $user_name, $pass, $data_base);
        $conn->set_charset('utf8');

    } catch (Exception $e){
        echo ('Se produjó un error en la conexión'. $e->getMessage());
    }
