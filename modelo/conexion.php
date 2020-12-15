<?php

$server = 'localhost';
$user_name = 'root';
$pass = '';
$data_base = 'fundacion_amitigra';

try {
$conn = new mysqli($server, $user_name, $pass, $data_base);
$conn->set_charset('utf8');
} catch (mysqlException $e){
    die('Hubo un error con la conexion a la base de datos: '. $e->getMessage());
}
