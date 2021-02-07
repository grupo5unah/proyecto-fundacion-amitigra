<?php

include "../modelo/conexion.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch($action){
    case 'reporteInventario':


    break;

}

