<?php

require_once "../modelo/conexionbd.php";

    $nombre = $_POST["Nombre"];
    $usuario = $_POST["Usuario"];
    $correo = $_POST["Correo"];
    $genero = $_POST["Genero"];
    $telefono = $_POST["Telefono"];
    $contrasena = $_POST["Contrasena"];
    $confirmarContrasena = $_POST["ConfirmarContrasena"];
    $pregunta1 = $_POST["Pregunta_1"];
    $pregunta2 = $_POST["Pregunta_2"];
    $pregunta3 = $_POST["Pregunta_3"];
    $id_preg1 = $_POST["Id_preg1"];
    $id_preg2 = $_POST["Id_preg2"];
    $id_preg3 = $_POST["Id_preg3"];

    if(!empty($usuario) || !empty($nombre) || !empty($correo) || !empty($genero) || !empty($telefono) ||
    !empty($contrasena) || !empty($confirmarContrasena || !empty($pregunta1) || !empty($pregunta2) ||
    !empty($pregunta3) || !empty($id_preg1) || !empty($id_preg2) || !empty($id_preg3))) {
        
        try {
            include_once("../modelo/conexionbd.php");
        
            //AQUI LA CONDICION
            if(empty($nombre) || empty($usuario) || empty($correo) || empty($contrasena)){
                
                $respuesta = array(
                    "respuesta" => "datos_requeridos"
                );

            }else{
                $cons_usuario = $conn->prepare('SELECT id_usuario, nombre_usuario, correo FROM tbl_usuarios WHERE nombre_usuario = ? OR correo = ?;');
                $cons_usuario->bind_Param("ss", $usuario, $correo);
                $cons_usuario->execute();
                $cons_usuario->bind_Result($id_usuario, $nombre_usuario, $correo_usuario);
        
                if($cons_usuario->affected_rows) {
                    $existe = $cons_usuario->fetch();

                    if($existe) {

                        //SI EL USUARIO EXISTE MOSTRAR NOTIFICACION
                        $respuesta = array(
                            "respuesta" => "usuario_existe"
                        );
                    
                    } else {
                        //Validacion contrasenas iguales
                        //if (comprobar_email($_POST["correo"])){
                            
                        if ($contrasena === $confirmarContrasena || strlen($contrasena) < 8){

                            $validar_correo = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i";
                            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,11}$/', $contrasena)){
                                
                                //SI LA CONTRASENA NO CUMPLE CON LOS REQUISITOS
                                $respuesta = array(
                                    "respuesta" => "contrasena_requisitos"
                                );
                                
                            } else {

                                $nom_mayuscula = strtoupper($nombre);
                                $user_mayuscula = strtoupper($usuario);
                                
                                if($usuario === "" || strlen($usuario) < 5){
                                    
                                    /*SI EL NOMBRE DE USUARIO NO CUMPLE CON LOS REQUISITOS (SER MAYOR
                                    DE 5 CARACTERES)*/
                                    $respuesta = array(
                                        "respuesta" => "usuario_noRequisitos"
                                    );
                                    
                                }else{
                                    $hashed_password = password_hash($contrasena, PASSWORD_BCRYPT);
                                    
                                    try {
                                        //REGISTRO DEL USUARIO
                                        require_once('../modelo/conexionbd.php');

                                        //Valor por Defecto
                                        $rol = 5;
                                        $token = "";
                                        $estado = 10;
                                        $preguntas = 3;
                                        $intentos = 0;

                                        $user = $usuario;

                                        $foto = "";

                                        if($genero === "femenino"){
                                            $foto = "femenino.png";
                                        } else {
                                            $foto = "masculino.png";
                                        }

                                        //Fecha ACTUAL del sistema
                                        date_default_timezone_set("America/Tegucigalpa");
                                        $fecha = date('Y-m-d H:i:s', time());
                                        
                                        //Genera la fecha del proximo mes
                                        $fecha_actual = new DateTime($fecha);
                                        $fecha_actual->modify('next month');
                                        $vencimiento = $fecha_actual->format('Y-m-d H:i:s');                                 

                                        $insertar = $conn->prepare("INSERT INTO tbl_usuarios (nombre_completo, nombre_usuario, foto, genero, telefono,
                                                                                            correo, contrasena, token, intentos, rol_id, estado_id,
                                                                                            fecha_ult_conexion, preguntas_contestadas, primer_ingreso,
                                                                                            fecha_mod_contrasena, fecha_vencimiento, creado_por, fecha_creacion,
                                                                                            modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                        $insertar->bind_Param("ssssisssiississsssss", $nom_mayuscula, $user_mayuscula, $foto,
                                                                                    $genero, $telefono, $correo, $hashed_password, $token, $intentos,
                                                                                    $rol, $estado, $fecha, $preguntas, $fecha, $fecha, $vencimiento, $user,
                                                                                    $fecha, $user, $fecha);
                                        $insertar->execute();

                                        if(!$insertar->error){

                                            $objeto = 1;
                                            $acciones = "registro de usuario";
                                            $descp = "se registro nuevo usuario";

                                            $registro = $conn->prepare('CALL control_bitacora (?,?,?,?,?)');
                                            $registro->bind_Param("sssii",$acciones, $descp,$fecha, $id_usuario, $objeto);
                                            $registro->execute();
                                            //$registro->close();

                                            $cambio_contrasena = $conn->prepare("CALL control_hist_contrasena (?,?,?,?,?,?);");
                                            $cambio_contrasena->bind_Param("isssss",$id_usuario, $hashed_password, $user, $fecha, $user, $fecha);
                                            $cambio_contrasena->execute();

                                            $respuesta = array(
                                                "respuesta" => "registro_exitoso"
                                            );

                                        }else{

                                            $respuesta = array(
                                                "respuesta" => "error_registro"
                                            );

                                        }

                                        $insertar->close();
                                        $insertar = null;
                                        sleep(3);

                                        if(isset($usuario)){
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

                                                    // if(!$insertarRespuesta->error){
                                                    // }else {
                                                    // }
                                                }else{

                                                }
                                            }
                                        }
                                    
                                        //REGISTRO DE LA CONTRASENA EN EL HISTORIAL DE CONTRASENAS
                                        /*$hist_contrasena = $conn->prepare("CALL control_hist_contrasena (?,?,?,?,?,?);");
                                        $hist_contrasena->bind_Param("sissss",$hashed_password,$id,$user,$fecha,$user,$fecha);
                                        $hist_contrasena->execute();

                                        if ($hist_contrasena->error){

                                        }else{

                                        }*/

                                                        
                                    } catch(Exception $e){
                                        echo "Error:" . $e->getMessage();
                                    }//Cierre segundo TRY CATCH
                                }
           
                            }
                            
                        } else {

                            $respuesta = array(
                                "respuesta" => "contrasena_NoCoinciden"
                            );

                        }//Cierre IF que verifica si las contrasena coinciden
                    }
                
                } else {

                    //EL USUARIO NO EXISTE ENTONCES SI SE PUEDE MODIFICAR
                    //echo $fecha;
                }
                $cons_usuario->close();
                $cons_usuario = null;
            }

        } catch(Exception $e) {
            //$respuesta = array('resultado' => 'Error');
        }

       

    }

    echo json_encode($respuesta);