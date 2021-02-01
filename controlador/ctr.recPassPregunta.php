<?php

//CONTROLADOR PARA RECUPERAR CONTRASEÑA MEDIANTE PREGUNTA DE SEGURIDAD
 class RecuPregunta{

    public function ctrRecuPregunta(){

        if (isset($_POST['tipo_pregunta']) == 'recuperarPregunta'){
            $correo = $_POST['email'];

            global $conn;
            include("../../modelo/conexionbd.php");
            $consultarPregunta = $conn->prepare("SELECT correo FROM tbl_usuarios WHERE correo=?");
            $consultarPregunta->bind_Param("s",$correo);
            $consultarPregunta->execute();
            $consultarPregunta->bind_Result($correo_electronico);

            if ($consultarPregunta->affected_rows){
                $existePregunta = $consultarPregunta->fetch();

                while($consultarPregunta->fetch()){
                    $mi_correo = $correo_electronico;
                }

                if($existePregunta){
                    // echo "<div class='alert alert-success' role ='alert'>
                    // Bien hecho, en un momento te redirigimos al cambio de contrasena.
                    // </div>";

                    echo "<div class='text-center alert alert-danger' role ='alert'>
                    <i class='fa fa-ban icon'></i> Función deshabilitada temporalmente.
                    </div>";
                    exit;

                    sleep(3);

                    if(isset($correo_electronico)){
                        session_start();
                        $_SESSION['correo'] = $correo_electronico;
                        echo '<script type="text/javascript">
                                location.href="recupregunta.php";
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