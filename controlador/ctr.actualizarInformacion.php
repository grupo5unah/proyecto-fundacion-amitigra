<?php
    class ActualizarInfo{

        public function ctrActualizarInfo(){

            if(isset($_POST['cambio']) == 'act'){
                $nombre = $_POST['nombre'];
                $usuario = $_POST['usuario'];
                $apellido = $_POST['apellido'];
                $telefono = $_POST['telefono'];
                $correo = $_POST['correo'];
                $actual = $_POST['actualPass'];
                $password = $_POST['nuevaPass'];
                $confiPassword = $_POST['confPass'];

                require("./modelo/conexion.php");

                try {

                    if($actual == ""){

                        /*require("./modelo/conexion.php");
                        $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                SET nombre = ?, apellido = ?, telefono =?, correo =?
                                                WHERE nombre_usuario = ?;
                                                ");
                        $actualizar->bind_Param("ssiss",$nombre, $apellido, $telefono, $correo, $usuario);
                        $actualizar->execute();
                        
                        if($actualizar->error){
                            echo "no se pudo realizar la actualizacion";
                        }else{                    
                            echo "Se actualizo con exito";
                        }*/
                        echo "<div class ='text-center alert alert-warning' role = 'alert'>
                                Debe de ingresar su contraseña para poder confirmar los cambios.
                                </div>";
                        
                    } else {

                        require("./modelo/conexion.php");
                        $stmt = $conn->prepare("SELECT id_usuario ,contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
                        $stmt->bind_Param("s", $usuario);
                        $stmt->execute();
                        $stmt->bind_Result($id, $contrasena);

                        if($stmt->affected_rows){

                            $existe = $stmt->fetch();

                            if($existe){

                                if(password_verify($actual, $contrasena)){

                                    if($password == $confiPassword){
                                        $opciones = array('cost' => 12);
                                        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

                                        require("./modelo/conexion.php");
                                        $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                                SET nombre = ?, apellido = ?, telefono =?, correo =?, contrasena = ?
                                                                WHERE nombre_usuario = ?;
                                                                ");
                                        $actualizar->bind_Param("ssisss",$nombre, $apellido, $telefono, $correo, $hashed_password, $usuario);
                                        $actualizar->execute();
                                        
                                        if($actualizar->error){
                                            echo "no se pudo realizar la actualizacion";
                                        }else{                                     
                                            echo "Se actualizo con exito";
                                        }
                                    }else{                                      
                                        echo "La nueva contrasena no coincide";
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
                    die('Se produjo un error'. $e->getMEssage());
                }

            }

        }

    }