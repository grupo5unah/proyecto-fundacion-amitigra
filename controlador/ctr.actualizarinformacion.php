<?php

include '../modelo/conexionbd.php';

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasenas = $_POST['verificarContrasena'];
$imagen = $_FILES['imagen'];

    if(!empty($imagen) || !empty($usuario) || !empty($nombre) || !empty($correo) || !empty($telefono) || !empty($contrasenas) || !empty($imagen)){

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

                        //Directorio donde se guardan las fotos
                        $carpetaFotoPerfil = '../fotoPerfil/';

                        //verifica si el directorio existe
                        if(!is_dir($carpetaFotoPerfil)){
                            mkdir($carpetaFotoPerfil,0777, true);
                        }

                        $nombre_foto ="";

                        if($imagen['name']){
                            //Eliminar la imagen previa
                            unlink($carpetaFotoPerfil . $mi_foto);

                            //Crea un nombre a la foto, este es unico entre todos
                            $nombre_foto = md5(uniqid(rand(),true)).".png";

                            //Mueve la foto del estado temporal a la carpeta fotoPerfil
                            move_uploaded_file($imagen['tmp_name'], $carpetaFotoPerfil . $nombre_foto);
                        }else{
                            $nombre_foto = $mi_foto;
                        }

                        include "../modelo/conexionbd.php";
                        $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                    SET nombre_completo = ?, foto = ?, correo = ?, telefono = ?
                                                    WHERE nombre_usuario = ?;");
                        $actualizar->bind_Param("sssss", $nombre, $nombre_foto, $correo, $telefono, $usuario);
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