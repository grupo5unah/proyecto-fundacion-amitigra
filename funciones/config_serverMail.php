<?php

global $mail;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../modelo/conexionbd.php';

    $correo = 'CORREO_SISTEMA';
    $puerto = 'PUERTO_CORREO';
    $contrasena = 'CONTRASENA_CORREO';

    require '../phpMailer/src/Exception.php';
    require '../phpMailer/src/PHPMailer.php';
    require '../phpMailer/src/SMTP.php';

        try{

            //PUERTO CORREO
            $PuertoCorreo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$puerto';");
            $resultPuerto = mysqli_query($conn, $PuertoCorreo);
            $PPuerto = mysqli_fetch_assoc($resultPuerto);

            //CONTRASENA CORREO
            $ContrasenaCorreo = ("SELECT valor FROM tbl_parametros WHERE parametro = '$contrasena';");
            $resultContrasena = mysqli_query($conn, $ContrasenaCorreo);
            $PContrasena = mysqli_fetch_assoc($resultContrasena);

            $correo_organizacion = $conn->prepare('SELECT valor FROM tbl_parametros WHERE parametro = ?;');
            $correo_organizacion->bind_Param('s',$correo);
            $correo_organizacion->execute();
            $correo_organizacion->bind_Result($valor);

            if($correo_organizacion->affected_rows){

                $existe = $correo_organizacion->fetch();

                if($existe){
                    $mail = new PHPMailer();

                    //Conexion al servidor
                    //$mail->SMTPDebug = 2;
                    $mail->isSMTP();
                    $mail->Host       = "smtp.gmail.com";
                    $mail->SMTPAuth   = true;
                    $mail->Username   = "soporte.fundacionamitigra@gmail.com";
                    $mail->Password   = "root_amitigra";
                    $mail->SMTPSecure = "ssl";
                    $mail->Port       = 465;

                    $mail->setFrom("soporte.fundacionamitigra@gmail.com", "Soporte tecnico");
                    $mail->isHTML(true);
                    //$mail->addReplyTo("no-reply@dfaguilarr.com");

                }
            }

        }catch (Exception $e){
            
        }

