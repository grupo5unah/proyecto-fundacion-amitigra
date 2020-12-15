<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../../phpMailer/src/Exception.php';
    require '../../phpMailer/src/PHPMailer.php';
    require '../../phpMailer/src/SMTP.php';

    /*include_once("../../modelo/conexion.php");

    $traerPuerto = "puerto_correo";

    $PuertoCorreo = $conn->prepare("SELECT valor FROM tbl_parametros WHERE parametro = ?;");
    $PuertoCorreo->bind_Param("s",$traerPuerto);
    $PuertoCorreo->execute();
    $PuertoCorreo->bind_Result($puerto);*/

        $mail = new PHPMailer();

        try{
            //Conexion al servidor
            //$mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host       = "smtp.gmail.com";
            $mail->SMTPAuth   = true;
            $mail->Username   = "sujemartinez26@gmail.com";
            $mail->Password   = "Diosesamor.26";
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;   

            $mail->setFrom("sujemartinez26@gmail.com", "Soporte tecnico");
            $mail->isHTML(true);
            //$mail->addReplyTo("no-reply@dfaguilarr.com");

        }catch (Exception $e){
            
        }

