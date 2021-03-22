<?php

    include("../modelo/conexionbd.php");

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $confirmarContrasena = $_POST['confirmarContrasena'];
    $pregunta_1 = $_POST['pregunta_1'];
    $pregunta_2 = $_POST['pregunta_2'];
    $pregunta_3 = $_POST['pregunta_3'];
    $id_preg1 = $_POST['id_preg1'];
    $id_preg2 = $_POST['id_preg2'];
    $id_preg3 = $_POST['id_preg3'];


    if(!empty($nombre) || !empty($usuario) || !empty($correo) || !empty($genero) || !empty($telefono) || !empty($contrasena) || !empty($confirmarContrasena) || !empty($pregunta_1) || !empty($pregunta_2) || !empty($pregunta_3) || !empty($id_preg1) || !empty($id_preg2) || !empty($id_preg3)){

        try {

            //AQUI LA CONDICION
            if(empty($nombre) && empty($usuario) && empty($correo) && empty($contrasena)){
                
                    //LLENAR TODOS LOS CAMPOS
                    $respuesta = array(
                        "respuesta" => "obligatorio"
                    );

            }else{
                $cons_usuario = $conn->prepare('SELECT id_usuario, nombre_usuario, correo FROM tbl_usuarios WHERE nombre_usuario = ? OR correo = ?;');
                $cons_usuario->bind_Param("ss", $usuario, $correo);
                $cons_usuario->execute();
                $cons_usuario->bind_Result($id_usuario, $nombre_usuario, $correo_usuario);
        
                if($cons_usuario->affected_rows) {
                    $existe = $cons_usuario->fetch();
                    
                    if($existe) {

                        $respuesta = array(
                            "respuesta" => "usuario_no_disponible"
                        );

                    } else {
                        //Validacion contrasenas iguales
                        //if (comprobar_email($_POST["correo"])){

                            
                        if ($contrasena === $confirmarContrasena || strlen($contrasena) < 8){

                            $validar_correo = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i";
                            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/', $contrasena)){
                                
                                $respuesta = array(
                                    "respuesta" => "contra_no_cumple"
                                );

                            } else {
                                if(isset($_POST["tipo"]) == "registro"){
                                    
                                    $nom_mayuscula = strtoupper($nombre);
                                    $user_mayuscula = strtoupper($usuario);
                                    
                                    if($usuario =="" || strlen($usuario) < 5){
                                        $campo = array();

                                        //SI EL NOMBRE DE USUARIO NO ES MAYOR A 5 CARACTERES
                                        $respuesta = array(
                                            "respuesta" => "no_disponible"
                                        );
                                    
                                    }else{
                                        
                                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                        
                                        try {
                                            //REGISTRO DEL USUARIO
                                            require_once('../../modelo/conexionbd.php');

                                            //Valor por Defecto
                                            $rol = 2;
                                            $token = "";
                                            $estado = 2;
                                            $preguntas = 3;
                                            $intentos = 0;
                                            $foto = "foto";

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

                                            if($insertar->error){

                                                //SI NO SE PUDO REGISTRAR EL USUARIO
                                                $respuesta = array(
                                                    "respuesta" => "error_registro"
                                                );

                                            }else{
                                                
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
                                                    "respuesta" => "exito"
                                                );

                                            }

                                            $insertar->close();
                                            $insertar = null;
                                            sleep(3);

                                            if(!empty($usuario)){ 

                                                include("../../modelo/conexionbd.php");

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
                                                        $pregunta1 = $_POST['pregunta1'];
                                                        $pregunta2 = $_POST['pregunta2'];
                                                        $pregunta3 = $_POST['pregunta3'];
                                                        $id_preg1 = $_POST['id_pregunta1'];
                                                        $id_preg2 = $_POST['id_pregunta2'];
                                                        $id_preg3 = $_POST['id_pregunta3'];
                                                        date_default_timezone_set("America/Tegucigalpa");
                                                        $fecha_hoy = date("Y-m-d H:s:i",time());
        
                                                        include("../../modelo/conexionbd.php");
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

                                                        if($insertarRespuesta->error){
                                                            
                                                            //Hubo un error al momento de registrar la respuesta.      

                                                        }else {

                                                        }
                                                    }else{

                                                    }
                                                }
                                            }
                                        
                                            //REGISTRO DE LA CONTRASENA EN EL HISTORIAL DE CONTRASENAS
                                            /*$hist_contrasena = $conn->prepare("INSERT INTO tbl_hist_contrasena (contrasena, usuario_id, creado_por, fecha_creacion, modificado_por, fecha_modificacion)
                                            VALUES (?,?,?,?,?,?);");
                                            $hist_contrasena->bind_Param("sissss",$hashed_password,$id,$user,$fecha,$user,$fecha);
                                            $hist_contrasena->execute();

                                            if ($hist_contrasena->error){

                                            }else{

                                            }*/

                                                            
                                        } catch(Exception $e){
                                            echo "Error:" . $e->getMessage();
                                        }//Cierre segundo TRY CATCH
                                    }

                                } else{
                                    echo "<p>";
                                    echo "surgio un error al parecer el usuario ya existe";
                                    echo "</p>";
                                }            
                            }
                            
                        } else {

                            $respuesta = array(
                                "respuesta" => "no_coinciden"
                            );

                        }//Cierre IF que verifica si las contrasena coinciden
                    }
                
                } else {
                    $respuesta = array();
                    array_push($respuesta,"usuario no existe");
                    //$respuesta->$stmt;
                    echo $fecha;
                }
                $cons_usuario->close();
                $cons_usuario = null;
            }

        } catch(Exception $e) {
            $respuesta = array('resultado' => 'Error');
        }
        echo json_encode($respuesta);

    }