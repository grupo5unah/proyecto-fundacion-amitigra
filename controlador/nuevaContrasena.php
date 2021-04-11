<?php

    $contrasena = $_POST["contrasena"];
    $confirmarContrasena = $_POST["confirmarContrasena"];
    $idObjeto = $_POST["idObjeto"];
    $eid = $_POST["eid"];
    $tkn = $_POST["tkn"];
    $exd = $_POST["exd"];

    if(!empty($contrasena) || !empty($confirmarContrasena) || !empty($eid) || !empty($tkn) ||
        !empty($exd) || !empty($idObjeto)){

        if(isset($eid) && isset($tkn) && isset($exd)){

            $correo = urldecode(base64_decode($eid));
            $validacion = urldecode(base64_decode($tkn));
            $expire_date = urldecode(base64_decode($exd));
                        
            date_default_timezone_set("America/Tegucigalpa");
            $current_date = date("Y-m-d H:i:s");

            if($expire_date <= $current_date) {

                //EL ENLACE A CADUCADO
                $respuesta = array(
                    "respuesta" => "caduco"
                );

            } else {

                if($contrasena === $confirmarContrasena) {

                    require '../modelo/conexionbd.php';
                    $Verificar = $conn->prepare("SELECT id_usuario, nombre_usuario FROM tbl_usuarios
                                                    WHERE token = ? OR correo = ?;");
                    $Verificar->bind_Param("ss",$validacion, $correo);
                    $Verificar->execute();
                    $Verificar->bind_Result($id_usuario, $nombre_usuario);

                    /*while ($Verificar->fetch()) {
                        $id = $id_usuario;
                    }*/

                    if($Verificar->affected_rows){
                        $existe = $Verificar->fetch();

                        if($existe){
                            $pattern_up = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/";
                            if(!preg_match($pattern_up, $contrasena)) {
                                //LA CONTRASENA NO CUMPLE LOS REQUISITOS
                                $respuesta = array(
                                    "respuesta" => "no_requisitos"
                                );
                                
                            } else {
                                
                                //Pediente MODIFICACION
                                include '../modelo/conexionbd.php';
                                $contrasenaUsuario = $conn->prepare("SELECT contrasena FROM tbl_hist_contrasena
                                                                WHERE usuario_id = ?;");
                                $contrasenaUsuario->bind_Param("i", $id_usuario);
                                $contrasenaUsuario->execute();
                                $contrasenaUsuario->bind_Result($hist_contrasena);

                                if ($contrasenaUsuario->affected_rows){
                                    $si_existe = $contrasenaUsuario->fetch();

                                    if($si_existe){

                                        if (password_verify($contrasena, $hist_contrasena)) {
                                            //LA CONTRASENA YA ESTUVO EN USO
                                            $respuesta = array(
                                                "respuesta" => "ya_EnUso"
                                            );
                                                                                                    
                                        } else {
                                    
                                            //Estado del usuario
                                            $estado_del_usuario = 1;
                                            //Se extrae la fecha actual
                                            date_default_timezone_set("America/Tegucigalpa");
                                            $fecha_hoy = date('Y-m-d H:i:s', time());
                                            //Calcula el proximo mes
                                            $fecha_actual = new DateTime($fecha_hoy);
                                            $fecha_actual->modify('next month');
                                            $nueva_fecha_vencimiento = $fecha_actual->format('Y-m-d H:i:s');

                                            //Contrasena HASHADA
                                            $hash_password = password_hash($contrasena, PASSWORD_BCRYPT);
                                            $vacio = "";
                                            
                                            require '../modelo/conexionbd.php';
                                            $Actualizacion = $conn->prepare("UPDATE tbl_usuarios
                                                                            SET contrasena = ?, token = ?,
                                                                            primer_ingreso = ?, estado_id = ?,
                                                                            fecha_mod_contrasena = ?,
                                                                            fecha_vencimiento = ?
                                                                            WHERE id_usuario = ?;");
                                            $Actualizacion->bind_Param("sssissi", $hash_password, $vacio, $fecha_hoy, $estado_del_usuario, $fecha_hoy, $nueva_fecha_vencimiento, $id_usuario);
                                            $Actualizacion->execute();

                                            if($Actualizacion->error) {
                                                $respuesta = array(
                                                    "respuesta" => "no_registro"
                                                );

                                            } else {
                                                //LA CONTRASENA SE REGISTRO CON EXITO
                                                $respuesta = array(
                                                    "respuesta" => "exito"
                                                );

                                                    //echo $id_usuario;

                                                    include "../modelo/conexionbd.php";
                                                    /*date_default_timezone_set("America/Tegucigalpa");
                                                    $fecha_actualizacion = date('Y-m-d H:i:s',time());

                                                    //REGISTRO A HISTORIAL CONTRASEÑA LA NUEVA CONTRASENA
                                                    $cambio_contrasena = $conn->prepare("CALL control_historial_contrasena (?,?,?,?,?,?);");
                                                    $cambio_contrasena->bind_Param("isssss",$id_usuario, $hash_password, $nombre_usuario, $fecha_actualizacion,$nombre_usuario,$fecha_actualizacion);
                                                    $cambio_contrasena->execute();*/

                                                    //REGISTRO A BITACORA POR CAMBIO DE CONTRASENA
                                                    date_default_timezone_set("America/Tegucigalpa");
                                                    $fecha = date("Y-m-d H:i:s", time());
                                                    $acciones = "Cambio de contraseña";
                                                    $descripcion = "Cambio de contraseña por correo exitoso";

                                                    $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?)");
                                                    $bitacora->bind_Param("sssii", $acciones, $descripcion, $fecha, $id_usuario, $idObjeto);
                                                    $bitacora->execute();
                                                    
                                            }//Cierre octavo IF

                                        }                                              
                                    }
                                }
                                
                                //exit;
                                
                            }//Cierre septimo IF    
                        } else {
                            $respuesta = array(
                                "respuesta" => "fallo_conexion"
                            );

                        }//Cierre sexto IF
                    }//Cierre quinto IF
                }else {
                    //LAS CONTRASENAS NO COINCIDEN
                    $respuesta = array(
                        "respuesta" => "no_coinciden"
                    );
                            
                }
            }
        } else {

            $respuesta = array(
                "respuesta" => "surgio_error"
            );

        }

        echo json_encode($respuesta);
    }