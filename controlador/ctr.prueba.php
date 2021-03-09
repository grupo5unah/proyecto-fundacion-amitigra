<?php

$accion = $_POST['accion'];
$password = $_POST['password'];
$usuario = $_POST['usuario'];

if($accion === 'login'){

    $hash_password = password_hash($password, PASSWORD_BCRYPT);

    $respuesta = array(
        'pass' => $hash_password
    );

    echo json_encode($respuesta);
} 