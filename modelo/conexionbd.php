<?php
    //Conexion a la base de datos

    global $conn;
    
    $server = 'localhost';
    $user_name = 'root';
    $pass = '';
    $data_base = 'bd_fundacion_amitigra';

    try{
        $conn = new mysqli($server, $user_name, $pass, $data_base);
        $conn->set_charset('utf8');

    } catch (Exception $e){
        echo ('Se produjó un error en la conexión'. $e->getMessage());
    }
