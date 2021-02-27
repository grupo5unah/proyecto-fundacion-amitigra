<?php
class PasswordPHP{
        
    public function ctrPasswordInfo(){
        if(isset($_POST['cambio_info']) == 'act_info'){
            $nombre = $_POST['nombre'];
            $usuario = $_POST['usuario'];
            $imagen = $_FILES['imagen'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $p_conf = $_POST['passConf'];

            try{

                require './modelo/conexionbd.php';

                if($p_conf == ""){
                    echo "<div class ='text-center alert alert-warning' role = 'alert'>
                                Debe de ingresar su contraseña para poder confirmar los cambios PHP.
                                </div>";
    
                } else {
                    $stmt = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
                        $stmt->bind_Param("s", $usuario);
                        $stmt->execute();
                        $stmt->bind_Result($id, $contrasena);

                        if($stmt->affected_rows){
                            $existe = $stmt->fetch();

                            if($existe){

                                if(password_verify($p_conf, $contrasena)){

                                    //Carpeta para las imágenes
                                    $carpetaFotoPerfil = 'fotoPerfil/';

                                    if(!is_dir($carpetaFotoPerfil)){ //Verifica la carpeta existe, de no ser así la crea
                                        mkdir($carpetaFotoPerfil,0777,true);
                                    }

                                    //Generar nombre de la foto
                                    $nombre_foto = md5(uniqid(rand(), true)).".png";

                                    //subir la imagen
                                    move_uploaded_file($imagen['tmp_name'], $carpetaFotoPerfil . $nombre_foto);

                                    require("./modelo/conexionbd.php");
                                    $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                            SET nombre_completo = ?, telefono =?, foto = ?, correo =?
                                                            WHERE nombre_usuario = ?;");
                                    $actualizar->bind_Param("sssss",$nombre, $telefono, $nombre_foto, $correo, $usuario);
                                    $actualizar->execute();
                                    
                                    if($actualizar->error){
                                        echo "no se pudo realizar la actualizacion";
                                    }else{                                     
                                        echo "<div class='text-center alert alert-success' role = 'alert'>
                                            Su información se actualizó con éxito.
                                            </div>";
                                    }

                                } else {
                                    echo "Las contrasenas no coinciden";
                                    
                                }
                            }else{

                            }
                        }else{

                        }
                }
            } catch (Exception $e) {

            }
        }
    }
}