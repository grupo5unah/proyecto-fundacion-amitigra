<?php
function correo_autenticado(){
    if(!revisar_correo()){
        header('location:../vista/modulos/olvide_contrasena.php');
        exit();
    }
}

function revisar_correo(){
    return isset($_SESSION['correo']);
}

session_start();
correo_autenticado();