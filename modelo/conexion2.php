<?php
$server2 = 'localhost';
$user_name2 = 'root';
$pass2 = '';
$data_base2 = 'bd_fundacion_amitigra';
$puerto = "3306";

try{
    $conn2 = new mysqli($server2, $user_name2, $pass2, $data_base2, $puerto);
    $conn2->set_charset('utf8');

} catch (Exception $e){
    echo ('Se produjó un error en la conexión'. $e->getMessage());
}