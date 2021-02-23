<?php

    class ReanudarSesion{

        public function ctrReanudarSesion(){
        //verifica que sea lo que viene mediante el metodo $_POST
        if(isset($_POST['tipo']) == 'bloqueo') {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            $user = $_SESSION['usuario'];

            session_unset();

            try{

                require_once("../../modelo/conexionbd.php");

                $stmt = $conn->prepare("SELECT id_usuario, contrasena, rol_id, primer_ingreso, tbl_roles.rol FROM tbl_usuarios
                                        INNER JOIN tbl_roles
                                        ON tbl_usuarios.rol_id = tbl_roles.id_rol
                                        WHERE nombre_usuario = ?");
                //$stmt = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?; ");
                $stmt->bind_Param("s", $usuario);
                $stmt->execute();
                $stmt->bind_result($id, $password_usuario, $rol_id, $rol, $primer_ingreso);

                if($stmt->affected_rows){
                    $existe = $stmt->fetch();

                    while ($stmt->fetch()) {
                        $id_usuario = $id;
                    }

                    if($existe){

                        if(password_verify($password, $password_usuario)){
                            
                            //session_create_id();
                            session_cache_expire();
                            session_start();
                            session_regenerate_id();
                            $_SESSION['usuario'] = strtolower($usuario);
                            $_SESSION['rol'] = $rol;
                            $_SESSION['primer_ingreso'] = $primer_ingreso;
                            //header('location:../../index.php');
                            echo "<script>
                            window.location='../../index.php';
                            </script>";
                        } else {
                            session_unset();
                            session_regenerate_id();
                            echo "<div class='text-center alert alert-danger' role = 'alert'>
                            La contraseña es incorrecta.
                            </div>";

                            sleep(3);
                            
                        }
                    }
                } else {
                    //$respuesta = array();
                    //AQUI UN MENSAJE DE ERROR
                    //array_push($respuesta,"usuario no existe");
                } 

                $stmt->close();
                $conn = null;
                    
            } catch(Exception $e) {
                die("se produjo un error". $e->getMessage());
            }
            //die(json_encode($respuesta));
        }

        }
    }