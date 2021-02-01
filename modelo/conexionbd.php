<?php

/*$server = 'f-a-aws.cqcxwtscprfd.us-east-1.rds.amazonaws.com';
$user_name = 'root';
$pass = 'Unah_fernando';
$data_base = 'bd_fundacion_amitigra';
//$puerto = '3308';*/

/*try {
$conn = new mysqli($server, $user_name, $pass, $data_base, $puerto);
$conn->set_charset('utf8');
} catch (mysqlException $e){
    die('Hubo un error con la conexion a la base de datos: '. $e->getMessage());
}*/

$server = 'localhost';
$user_name = 'root';
$pass = '';
$data_base = 'bd_fundacion_amitigra';

try{
    $conn = new mysqli($server, $user_name, $pass, $data_base);
    $conn->set_charset('utf8');

} catch (mysqlException){
    die('Se produjó un error en la conexión');
}
