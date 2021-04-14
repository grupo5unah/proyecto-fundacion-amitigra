<?php
    //Conexion a la base de datos
    include "conexion2.php";
    global $conn;
    
   /* $Pdatabase = "SELECT valor FROM tbl_parametros WHERE parametro = 'PUERTO_DATABASE'";
    $ResultPdatabase = mysqli_query($conn2, $Pdatabase);
    $PPdatabase = mysqli_fetch_assoc($ResultPdatabase);*/

    $server = 'localhost';
    $user_name = 'root';
    $pass = '';
    $data_base = 'bd_fundacion_amitigra';
    //$puerto = $PPdatabase["valor"];

    try{
        $conn = new mysqli($server, $user_name, $pass, $data_base);
        $conn->set_charset('utf8');

    } catch (Exception $e){
        echo ('Se produjó un error en la conexión'. $e->getMessage());
    }
