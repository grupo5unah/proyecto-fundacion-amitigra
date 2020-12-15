<?php

//CONTROLADOR PARA RECUPERAR CONTRASEÑA MEDIANTE PREGUNTA DE SEGURIDAD
 class NuevaContrasenaBloqueo{

    public function ctrNuevaContrasenaBloqueo(){

        if (isset($_POST['tipo']) == 'contra_bloqueo'){
            $usuario = $_SESSION['usuario'];

            include("../../modelo/conexion.php");
            $consultarPregunta = $conn->prepare("SELECT correo FROM tbl_usuarios WHERE nombre_usuario=?");
            $consultarPregunta->bind_Param("s",$usuario);
            $consultarPregunta->execute();
            $consultarPregunta->bind_Result($correo_electronico);

            if ($consultarPregunta->affected_rows){
                $existePregunta = $consultarPregunta->fetch();

                while($consultarPregunta->fetch()){
                    $mi_correo = $correo_electronico;
                }

                if($existePregunta){
                    echo "<div class='alert alert-success' role ='alert'>
                    Bien hecho, en un momento te redirigimos al cambio de contrasena.
                    </div>";

                    sleep(3);

                    if(isset($correo_electronico)){
                        session_start();
                        $_SESSION['correo'] = $correo_electronico;
                        echo '<script type="text/javascript">
                                location.href="cambio_password.php";
                                </script>';
                    }

                } else {
                    echo "<div class='text-center alert alert-danger' role='alert'>
                            No existe el usuario con correo.
                            </div>";
                }
            }

        }
    }
 }