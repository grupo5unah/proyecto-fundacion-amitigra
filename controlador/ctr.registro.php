<?php

    class Registro{

        public function ctrRegistro(){
            
            if(isset($_POST["tipo"]) == "registro") {
                $nombre = $_POST['nombre'];
                $usuario = $_POST['usuario'];
                $correo = $_POST['correo'];
                $genero = $_POST['genero'];
                $telefono = $_POST['telefono'];
                $password = $_POST['password'];
                $confpassword = $_POST['password2'];
                $pregunta1 = $_POST['pregunta1'];
                $pregunta2 = $_POST['pregunta2'];
                $pregunta3 = $_POST['pregunta3'];
                $id_preg1 = $_POST['id_pregunta1'];
                $id_preg2 = $_POST['id_pregunta2'];
                $id_preg3 = $_POST['id_pregunta3'];

                try {
                    require_once('../../modelo/conexion.php');

                    $consulta_usuario = $conn->prepare("SELECT id_usuario, nombre_usuario, correo FROM tbl_usuarios WHERE nombre_usuario = ? OR correo = ?;");
                    $consulta_usuario->bind_Param("ss", $usuario, $correo);
                    $consulta_usuario->execute();
                    $consulta_usuario->bind_Result($id_usuario, $nombre_usuario, $correo_usuario);
               
                    if($consultar_usuario->affected_rows) {
                        $existe = $consultar_usuario->fetch();

                        while ($consultar_usuario->fetch()){
                            $id = $id_usuario;
                        }
                        
                        if($existe) {
                            echo "<div class='text-center alert alert-danger' role = 'alert'>
                            El nombre de usuario y/o correo electronico ya estan en uso.
                            </div>";
                        } else {
                            //Validacion contrasenas iguales
                            //if (comprobar_email($_POST["correo"])){
                                
                            if ($password == $confpassword || strlen($password) < 8){

                                $validar_correo = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i";
                                if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,11}$/', $password)){
                                    echo 'la contraseña no cumple con los requisitos.';
                                    "<br>";
                                    echo 'debe contener letra mayuscula, minuscula y caracteres especiales comprendidos en !@#$%';
                                } else {
                                    if(isset($_POST["tipo"]) == "registro"){
                                        $nombre = $_POST['nombre'];
                                        $usuario = $_POST['usuario'];
                                        $correo = $_POST['correo'];
                                        $genero = $_POST['genero'];
                                        $telefono = $_POST['telefono'];
                                        $password = $_POST['password'];
                                        $confpassword = $_POST['password2'];
                                        $nom_mayuscula = strtoupper($nombre);
                                        $ape_mayuscula = strtoupper($apellido);
                                        $user_mayuscula = strtoupper($usuario);
                                        
                                        if($usuario =="" || strlen($usuario) < 5){
                                            $campo = array();
                                            
                                            echo "<div class='alert alert-danger' role='alert'>
                                                    <p class='mensaje'>
                                                    Lo sentimos, no se permiten nombres de usuario con menos de cinco caracteres
                                                    </p>
                                                    </div>";
                                            //echo "Debe de agregar un nombre de usuario con un mayor de 5 letras";
                                        }else{
                                            $opciones = array('cost' => 12);
                                            $hashed_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
                                            
                                            try {
                                                //REGISTRO DEL USUARIO
                                                require_once('../../modelo/conexion.php');

                                                //Valor por Defecto
                                                $rol = 3;
                                                $token = "";
                                                $estado = "ACTIVO";
                                                $preguntas = 0;
                                                $intentos = 0;
                                                $foto = "foto.png";
                                                $user = $usuario;

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
                                                                                                    fecha_vencimiento, creado_por, fecha_creacion,
                                                                                                    modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,
                                                                                                    ?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                                                $insertar->bind_Param("ssssisssiississssss", $nom_mayuscula, $user_mayuscula, $foto,
                                                                                            $genero, $telefono, $correo, $hashed_password, $token, $intentos,
                                                                                            $rol, $estado, $fecha, $preguntas, $fecha, $vencimiento, $user,
                                                                                            $fecha, $user, $fecha);
                                                $insertar->execute();

                                                if($insertar->error){
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                            Se produjo un error al momento de registrar el usuario
                                                            </div>";
                                                }else{
                                                    
                                                    $objeto = 1;
                                                    $acciones = "registro de usuario";
                                                    $descp = "se registro nuevo usuario";

                                                    $registro = $conn->prepare('CALL CONTROL_BITACORA (?,?,?,?,?)');
                                                    $registro->bind_Param("sssss",$acciones, $descp,$fecha, $id_usuario, $objeto);
                                                    $registro->execute();
                                                    $registro->close();

                                                    echo "<p class='mensaje'>";
                                                    echo "<div class='alert alert-success' role = 'alert'>
                                                        El usuario se creo correctamente.
                                                        </div>";
                                                    echo '<script>window.location.href:login.php;</script>';
                                                }

                                                $insertar->close();
                                                $insertar = null;
                                                sleep(3);

                                                if(isset($_POST["tipo"]) == "registro"){
                                                    $usuario1 = $_POST['usuario']; 

                                                    include("../../modelo/conexion.php");

                                                    $verificarUsuario = $conn->prepare ("SELECT id_usuario, nombre_usuario FROM tbl_usuarios
                                                                                        WHERE nombre_usuario = ?");
                                                    $verificarUsuario->bind_Param("s",$usuario1);
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
            
                                                            include("../../modelo/conexion.php");
                                                            $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,respuesta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                                VALUES (?,?,?,?,?,?,?)");
                                                            $insertarRespuesta->bind_Param("iisssss",$pregunta1,$user_registro,$id_preg1,$user_registro,$fecha_hoy,$usuario,$fecha_hoy);
                                                            $insertarRespuesta->execute();
                                                            $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,pregunta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                                VALUES (?,?,?,?,?,?,?)");
                                                            $insertarRespuesta->bind_Param("iisssss",$pregunta2,$user_registro,$id_preg2,$usuario,$fecha_hoy,$usuario,$fecha_hoy);
                                                            $insertarRespuesta->execute();
                                                            $insertarRespuesta = $conn->prepare("INSERT INTO tbl_preguntas_usuario (pregunta_id,usuario_id,pregunta,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                                                                VALUES (?,?,?,?,?,?,?)");
                                                            $insertarRespuesta->bind_Param("iisssss",$pregunta3,$user_registro,$id_preg3,$usuario,$fecha_hoy,$usuario,$fecha_hoy);
                                                            $insertarRespuesta->execute();

                                                            if($insertarRespuesta->error){
                                                                echo "<div class='alert alert-danger' role = 'alert'>
                                                                        Hubo un error al momento de registrar la respuesta.
                                                                        </div>";

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
                                echo 'Las contrasenas no coinciden';
                            }//Cierre IF que verifica si las contrasena coinciden
                        }
                       
                    } else {
                        $respuesta = array();
                        array_push($respuesta,"usuario no existe");
                        $respuesta->$stmt;
                        echo $fecha;
                    }
                    $consultar_usuario->close();
                    $consultar_usuario = null;
                } catch(Exception $e) {
                    $respuesta = array('resultado' => 'Error');
                }
  
            }
                
        }//Fin FUNCION
    }//Fin CLASE