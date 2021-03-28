<?php

require_once "../modelo/conexionbd.php";

    $usuario = $_POST["usuario"];
    $contrasenaActual = $_POST["contrasenaActual"];
    $contrasena = $_POST["contrasena"];
    $confirmarContrasena = $_POST["confirmarContrasena"];
    $pregunta1 = $_POST["pregunta_1"];
    $pregunta2 = $_POST["pregunta_2"];
    $pregunta3 = $_POST["pregunta_3"];
    $id_preg1 = $_POST["id_preg1"];
    $id_preg2 = $_POST["id_preg2"];
    $id_preg3 = $_POST["id_preg3"];

    if(!empty($usuario) || !empty($contrasenaActual) || !empty($contrasena) || !empty($confirmarContrasena ||
    !empty($pregunta1) || !empty($pregunta2) || !empty($pregunta3) || !empty($id_preg1) ||
    !empty($id_preg2) || !empty($id_preg3))) {
        
        try {
            include_once("../modelo/conexionbd.php");

            $consultar = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
            $consultar->bind_Param("s",$usuario);
            $consultar->execute();
            $consultar->bind_Result($id_usuario, $contrasenaUsuario);

            if($consultar->affected_rows){
                $perfecto = $consultar->fetch();

                if($perfecto){

                    if(password_verify($contrasenaActual, $contrasenaUsuario)){
                       
                        if ($contrasena === $confirmarContrasena || strlen($contrasena) < 7){

                            $user_mayuscula = strtoupper($usuario);

                            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/', $contrasena)){
                                
                                //SI LA CONTRASENA NO CUMPLE CON LOS REQUISITOS
                                $respuesta = array(
                                    "respuesta" => "contrasena_requisitos"
                                );
                                
                            } else {
                                //$nom_mayuscula = strtoupper($nombre);
                                
                                $hash_contrasena = password_hash($contrasena, PASSWORD_BCRYPT);
                                
                                try {
                                    //REGISTRO DEL USUARIO

                                    //Valor por Defecto
                                    
                                    $preguntas = 3;
                                    $estado = 1;
                                    $intentos = 0;

                                    //Fecha ACTUAL del sistema
                                    date_default_timezone_set("America/Tegucigalpa");
                                    $fecha = date('Y-m-d H:i:s', time());
                                    
                                    //Genera la fecha del proximo mes
                                    $fecha_actual = new DateTime($fecha);
                                    $fecha_actual->modify('next month');
                                    $vencimiento = $fecha_actual->format('Y-m-d H:i:s');   


                                    include "../modelo/conexionbd.php";
                                    $actualizarInformacion = $conn->prepare("UPDATE tbl_usuarios
                                                                SET contrasena = ?, intentos = ?, estado_id = ?, preguntas_contestadas = ?,
                                                                fecha_mod_contrasena = ?, fecha_vencimiento = ?, creado_por = ?,
                                                                fecha_creacion = ?, modificado_por = ?, fecha_modificacion = ? WHERE id_usuario = ? OR nombre_usuario = ?;");
                                    $actualizarInformacion->bind_Param("siiissssssis", $hash_contrasena, $intentos, $estado, $preguntas,
                                                                                    $fecha, $vencimiento, $usuario, $fecha, $usuario,
                                                                                    $fecha, $id_usuario, $usuario);
                                    $actualizarInformacion->execute();

                                    if(!$actualizarInformacion->error){

                                        /*$objeto = 1;
                                        $acciones = "registro de preguntas";
                                        $descp = "se registraron las preguntas";

                                        $registro = $conn->prepare('CALL control_bitacora (?,?,?,?,?)');
                                        $registro->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario, $objeto);
                                        $registro->execute();*/
                                        //$registro->close();

                                        /*$cambio_contrasena = $conn->prepare("CALL control_hist_contrasena (?,?,?,?,?,?);");
                                        $cambio_contrasena->bind_Param("isssss",$id_usuario, $hashed_password, $user, $fecha, $user, $fecha);
                                        $cambio_contrasena->execute();*/

                                        $respuesta = array(
                                            "respuesta" => "registro_exitoso"
                                        );

                                    }else{

                                        $respuesta = array(
                                            "respuesta" => "error_registro"
                                        );

                                    }

                                    //$insertar->close();
                                    //$insertar = null;
                                    sleep(3);

                                    if(!empty($usuario)){
                                        //$usuario1 = $_POST['usuario']; 

                                        include("../modelo/conexionbd.php");

                                        $verificarUsuario = $conn->prepare ("SELECT id_usuario, nombre_usuario FROM tbl_usuarios
                                                                            WHERE nombre_usuario = ?");
                                        $verificarUsuario->bind_Param("s",$usuario);
                                        $verificarUsuario->execute();
                                        $verificarUsuario->bind_Result($user_registro, $id_nuevo);

                                        if($verificarUsuario->affected_rows){
                                            $existe_registro = $verificarUsuario->fetch();

                                            while ($verificarUsuario->fetch()){
                                                $id_usuario_nuevo = $id_nuevo;

                                            }

                                            if($existe_registro){
                                                date_default_timezone_set("America/Tegucigalpa");
                                                $fecha_hoy = date("Y-m-d H:s:i",time());

                                                include("../modelo/conexionbd.php");
                                                $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,respuesta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                    VALUES (?,?,?,?,?,?,?)");
                                                $insertarRespuesta->bind_Param("iisssss",$id_preg1,$user_registro,$pregunta1,$usuario,$fecha_hoy,$usuario,$fecha_hoy);
                                                $insertarRespuesta->execute();
                                                $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,respuesta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                    VALUES (?,?,?,?,?,?,?)");
                                                $insertarRespuesta->bind_Param("iisssss",$id_preg2,$user_registro,$pregunta2,$usuario,$fecha_hoy,$usuario,$fecha_hoy);
                                                $insertarRespuesta->execute();
                                                $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,respuesta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                    VALUES (?,?,?,?,?,?,?)");
                                                $insertarRespuesta->bind_Param("iisssss",$id_preg3,$user_registro,$pregunta3,$usuario,$fecha_hoy,$usuario,$fecha_hoy);
                                                $insertarRespuesta->execute();

                                                if(!$insertarRespuesta->error){

                                                    /*$respuesta = array(
                                                        "respuesta" => "error_preguntas"
                                                    );*/

                                                }else {

                                                }
                                            }else{

                                            }
                                        }
                                    }
                                                    
                                } catch(Exception $e){
                                    echo "Error:" . $e->getMessage();
                                }//Cierre segundo TRY CATCH
                            }
                            
                        } else {

                            $respuesta = array(
                                "respuesta" => "contrasena_NoCoinciden"
                            );

                        }//Cierre IF que verifica si las contrasena coinciden
                    
                        // $cons_usuario->close();
                        // $cons_usuario = null;
                    

                    }else{
                        //SI LA CONTRASENA ACTUAL NO COINCIDE
                        $respuesta = array(
                            "respuesta" => "no_coincide"
                        );
                    }
                } else{
                    
                }
            }

        } catch(Exception $e) {
            //$respuesta = array('resultado' => 'Error');
        }

        echo json_encode($respuesta);

    }