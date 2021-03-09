<?php

    class ActualizarInfo{

        public function ctrActualizarInfo(){

            if(isset($_POST['cambios']) == 'act'){
                $usuario = $_POST['usuario'];
                $actual = $_POST['actualPass'];
                $password = $_POST['nuevaPass'];
                $confiPassword = $_POST['confPass'];

                require("./modelo/conexionbd.php");

                try {

                    if($actual == ""){
                        
                        echo "<div class ='text-center alert alert-warning' role = 'alert'>
                                Debe de ingresar su contraseña para poder confirmar los cambios.
                                </div>
                                <script>
                                window.setTimeout(function(){
                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                function(){
                                $(this).remove();
                                });
                                }, 3000);
                                </script>";
                    } else {

                        require("./modelo/conexionbd.php");
                        $stmt = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
                        $stmt->bind_Param("s", $usuario);
                        $stmt->execute();
                        $stmt->bind_Result($id, $contrasena);

                        if($stmt->affected_rows){
                            $existe = $stmt->fetch();

                            if($existe){

                                if(password_verify($actual, $contrasena)){

                                    if($password == $confiPassword){

                                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                                        require("./modelo/conexionbd.php");
                                        $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                                SET contrasena = ?
                                                                WHERE nombre_usuario = ?;");
                                        $actualizar->bind_Param("ss",$hashed_password, $usuario);
                                        $actualizar->execute();
                                        
                                        if($actualizar->error){
                                            echo "no se pudo realizar la actualizacion";
                                        }else{                                     
                                            echo "<div class='text-center alert alert-success' role = 'alert'>
                                                Su contrasena se actualizo con exito.
                                                </div>
                                                <script>
                                                window.setTimeout(function(){
                                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                                function(){
                                                $(this).remove();
                                                });
                                                }, 3000);
                                                </script>";
                                        
                                        session_destroy();
                                        
                                        echo '<script>
                                                location.reload();
                                                timer: 10000;
                                                </script>';
                                                
                                        }
                                    }else{                                      
                                        echo "<div class='text-center alert alert-danger' role='alert'>
                                        La nueva contrasena no coincide
                                        </div>
                                        <script>
                                        window.setTimeout(function(){
                                        $('.alert').fadeTo(1500,00).slideDown(1000,
                                        function(){
                                        $(this).remove();
                                        });
                                        }, 3000);
                                        </script>";
                                    }

                                } else {
                                    echo "<div class='text-center alert alert-danger' role='alert'>
                                    Las contrasenas no coinciden
                                    </div>
                                    <script>
                                    window.setTimeout(function(){
                                    $('.alert').fadeTo(1500,00).slideDown(1000,
                                    function(){
                                    $(this).remove();
                                    });
                                    }, 3000);
                                    </script>";
                                    
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