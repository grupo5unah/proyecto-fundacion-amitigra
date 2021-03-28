<?php

global $mail;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../modelo/conexionbd.php';

    $correo = 'CORREO_SISTEMA';
    $puerto = 'PUERTO_CORREO';

    require '../phpMailer/src/Exception.php';
    require '../phpMailer/src/PHPMailer.php';
    require '../phpMailer/src/SMTP.php';

        try{

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
                    $mail->Username   = $valor;
                    $mail->Password   = "root_amitigra";
                    $mail->SMTPSecure = "tls";
                    $mail->Port       = 587;   

                    $mail->setFrom($valor, "Soporte tecnico");
                    $mail->isHTML(true);
                    //$mail->addReplyTo("no-reply@dfaguilarr.com");

                }
            }

        }catch (Exception $e){
            
        }

