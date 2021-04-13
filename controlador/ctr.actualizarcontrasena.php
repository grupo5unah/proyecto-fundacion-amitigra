<?php

include '../modelo/conexionbd.php';

$contrasenaActual = $_POST['contrasenaActual'];
$contrasenaNueva = $_POST['contrasenaNueva'];
$confirmarContrasena = $_POST['confirmarContrasena'];
$usuario = $_POST['usuario2'];

    if(!empty($usuario) || !empty($contrasenaActual) || !empty($contrasenaNueva) || !empty($confirmarContrasena)){

        try{
            $usuarios = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
            $usuarios->bind_Param("s", $usuario);
            $usuarios->execute();
            $usuarios->bind_Result($id, $contrasena);

            if($usuarios->affected_rows){
                $siExiste = $usuarios->fetch();
                /*$respuesta = array(
                    'respuesta' => 'exito'
                );*/
                
                if($siExiste){

                    if(password_verify($contrasenaActual, $contrasena)){
                    
                        if( $contrasenaNueva == $confirmarContrasena){
                            
                            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/', $contrasenaNueva)){
                                
                                $respuesta = array(
                                    "respuesta" => "requisitos"
                                );

                            } else {

                                //SI LAS CONTRASENAS COINCIDEN
                                $respuesta = array(
                                    "respuesta" => "confirmar"
                                );

                                if($contrasenaNueva == $contrasenaActual){
                                    
                                    //SI LA CONTRASENA ACTUAL Y LA NUEVA COINCIDEN NO PERMITE EL CAMBIO DE CONTRASENA
                                    $respuesta = array(
                                        "respuesta" => "igual"
                                    );
                                } else {

                                    //FECHA
                                    require ("../modelo/conexionbd.php");
                                    /*$comp_contrasena = $conn->prepare("SELECT contrasena FROM tbl_hist_contrasena WHERE usuario_id = ? LIMIT 1;");
                                    $comp_contrasena->bind_Param("i",$id);
                                    $comp_contrasena->execute();
                                    $comp_contrasena->bind_Result($hist_contrasena);*/
                                    
                                    /*if($comp_contrasena->affected_rows){
                                        $comp_existe = $comp_contrasena->fetch();
                                        if($comp_existe){*/

                                            /*$consulta = "SELECT count(contrasena) FROM tbl_hist_contrasena WHERE usuario_id = '$id'";
                                            $resultado = mysqli_query($conn, $consulta);
                                            $passw = mysqli_fetch_assoc($resultado);

                                            if(password_verify($contrasenaNueva, $passw['contrasena'])){

                                                $respuesta = array(
                                                    "respuesta" => "existe_registro"
                                                );

                                            }else{*/

                                                date_default_timezone_set("America/Tegucigalpa");
                                                $fecha_hoy = date("Y-m-d H:i:s", time());

                                                $fechaActualizacion= new DateTime($fecha_hoy);
                                                $fechaActualizacion->modify("next month");
                                                $vecimiento = $fechaActualizacion->format("Y-m-d H:i:s");


                                                $hash_password = password_hash($contrasenaNueva, PASSWORD_BCRYPT);

                                                //QUERY ACTUALIZAR LA INFORMACION DEL USUARIO (tbl_usuarios)
                                                include ("../modelo/conexionbd.php");
                                                $actualizar = $conn->prepare("UPDATE tbl_usuarios
                                                                            SET contrasena = ?, fecha_mod_contrasena = ?, fecha_vencimiento = ?
                                                                            WHERE nombre_usuario = ?");
                                                $actualizar->bind_Param("ssss", $hash_password, $fecha_hoy, $vecimiento ,$usuario);
                                                $actualizar->execute();

                                                if(!$actualizar->error){

                                                    $respuesta = array (
                                                        "respuesta" => "actualizacion"
                                                    );

                                                    sleep(2);
                                                    session_unset();
                                                    ob_flush();
                                                    //session_abort();

                                                }else{
                                                    $respuesta = array (
                                                        "respuesta" => "noActualizacion"
                                                    );
                                                }

                                                //QUERY ACTUALIZACION EN LA tbl_hist_contrasena
                                                include "../modelo/conexionbd.php";
                                                $insHistorialContrasena = $conn->prepare("CALL control_hist_contrasena (?,?,?,?,?,?);");
                                                $insHistorialContrasena->bind_Param("isssss", $id,$hash_password, $usuario, $fecha_hoy, $usuario, $fecha_hoy);
                                                $insHistorialContrasena->execute();

                                            //}
                                        //}

                                    /*}else{

                                    }*/
                                    
                                }
                            }
                        
                        }else{
                            //SI LA CONTRASENA NUEVA CON LA CONFIRMACION NO COINCIDEN
                            $respuesta = array(
                                "respuesta" => "no_iguales"
                            );
                        }
                    }else{
                        //SI LA CONTRASENA NO EXISTE
                        $respuesta = array(
                            "respuesta" => "no_existe"
                        );
                    }

                }
                //echo json_encode($respuesta);
            }
        } catch(Exception $e){
            
            $respuesta = array(
                "respuesta" => "try"
            );

        }

        echo json_encode($respuesta);
    }