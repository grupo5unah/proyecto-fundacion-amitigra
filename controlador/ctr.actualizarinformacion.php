<?php

include '../modelo/conexionbd.php';

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasenas = $_POST['verificarContrasena'];
//$imagen = $_FILES['imagen'];

    if(!empty($usuario) || !empty($nombre) || !empty($correo) || !empty($telefono) || !empty($contrasenas) || !empty($imagen)){

        //include '../modelo/conexionbd.php';
        //$json = array();

        try{
            $informacion = $conn->prepare("SELECT id_usuario, foto, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
            $informacion->bind_Param("s", $usuario);
            $informacion->execute();
            $informacion->bind_Result($id, $mi_foto, $password);

            if($informacion->affected_rows){
                $existe = $informacion->fetch();
        
                if($existe){

                    /*$respuesta = array(
                        "respuesta" => "correcto"
                    );*/
            
                    if(password_verify($contrasenas, $password)){

                        include "../modelo/conexionbd.php";
                        $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                    SET nombre_completo = ?, correo = ?, telefono = ?
                                                    WHERE nombre_usuario = ?;");
                        $actualizar->bind_Param("ssss", $nombre, $correo, $telefono, $usuario);
                        $actualizar->execute();

                        if(!$actualizar->error){
                            $respuesta = array(
                                "respuesta" => "info_actualizada");

                        }else{

                            $respuesta = array(
                                "respuesta" => "info_noActualizada"
                            );
                        }
                        
                    }else{
                        $respuesta = array(
                        "respuesta" => "error_pass"
                        );
                    }

                }
                
            }
        } catch( Exception $e){

            $respuesta = array(
                "respuesta" => "error_catch"
                );
        }

        echo json_encode($respuesta);
        
    }