<?php

//Como saber si se esta conectado a la base de datos
/*if($conn->ping()){
    echo "conectado";
} else {
    echo "error de conexion";
}*/


class Login{

    public function ctrLogin(){
    //verifica que sea lo que viene mediante el metodo $_POST
    if(isset($_POST['tipo']) == 'login') {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $mayuscula = strtoupper($_POST['usuario']);
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date("Y-m-d H:i:s", time());

        try {
            if($usuario != $mayuscula){
                //AQUI EL MENSAJE DE QUE EL USUARIO TIENE QUE SER EN LETRAS MAYUSCULAS
                echo "<div class='text-center alert alert-danger' role = 'alert'>
                            El nombre de usuario debe de ser en mayusculas.
                    </div>";
            } else {
                require_once("../../modelo/conexion.php");

                $stmt = $conn->prepare("SELECT id_usuario, contrasena FROM tbl_usuarios WHERE nombre_usuario = ?; ");
                $stmt->bind_Param("s", $usuario);
                $stmt->execute();
                $stmt->bind_result($id, $password_usuario);

                if($stmt->affected_rows){
                    $existe = $stmt->fetch();

                    while ($stmt->fetch()) {
                        $id_usuario = $id;
                    }

                    if($existe){

                            $stmt1 = $conn->prepare("SELECT id_usuario, estado_usuario, primer_ingreso, intentos, rol_id, tbl_roles.rol FROM tbl_usuarios
                                                    INNER JOIN tbl_roles ON tbl_usuarios.rol_id = tbl_roles.id_rol WHERE nombre_usuario = ? OR id_usuario = ?; ");
                            $stmt1->bind_Param("si", $usuario, $id_usuario);
                            $stmt1->execute();
                            $stmt1->bind_result($user_id, $estado_usuario, $ingreso, $intentos_usuario, $rol_id, $rol);

                            while ($stmt1->fetch()) {
                                $estado = $estado_usuario;
                                $id_usuario_bitacora = $user_id;
                                $rol_usuario = $rol_id;
                                $primer_ingreso = $ingreso;
                            }

                            $fecha_registro = new DateTime($ingreso);
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha_hoy = date('Y-m-d H:i:s', time());
                            $fecha_actual = new DateTime($fecha_hoy);
                            $diff = $fecha_registro->diff($fecha_actual);
                            $dias_transcurridos = $diff->days;

                            //Si su estado es activo pasa a comprara las contrasenas
                            if ($estado =="ACTIVO"){   
                                
                                if(password_verify($password, $password_usuario)){


                                    if($dias_transcurridos <= 30){
                                        session_start();
                                        session_encode();

                                        $_SESSION['usuario'] = strtolower($usuario);
                                        $_SESSION['rol'] = $rol;
                                        $_SESSION['primer_ingreso'] = $primer_ingreso;

                                        //Registra en la BITACORA la accion realizada
                                        $objeto = 1;
                                        $acciones = "inicio de sesion";
                                        $descp = "se inicio sesion correctamente";
                                        require_once("../../modelo/conexion2.php");
                                        $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                                        $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                                        $llamar->execute();
                                        $llamar->close();

                                        /*echo "<script>
                                        setTimeout(function () {S
                                        window.location.href= '../../index.php';
                                        }, 3000);
                                        </script>";*/

                                        sleep(2);
                                        header('location:../../index.php');
                                    }else{

                                        echo "<div class='text-center alert alert-danger' role = 'alert'>
                                        su usuario a sido bloqueado.
                                        </div>";

                                        $cambio_estado_usuario = "BLOQUEADO";

                                        require_once("../../modelo/conexion.php");

                                        $bloqueo = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET estado_usuario = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo->bind_Param("ss",$cambio_estado_usuario ,$usuario);
                                        $bloqueo->execute();

                                        if($bloqueo->error){
                                            echo "se produjo un error en la actualizacion";
                                        } else{
                                            echo "El estado del usuario se actualizo con exito";
                                        }

                                    }

                                } else {

                                    $intentos = 3;

                                    if($intentos_usuario == $intentos){

                                        echo "<div class='alert alert-danger text-center' role='alert'>
                                            El usuario a sido bloqueado ya que realizó los 3 intentos permitidos.
                                            </div>";
                                            
                                        //ESTA PARTE SE VA A REMOVER
                                        $cambio_estado_bloqueo = "BLOQUEADO";
                                        $reiniciar_intentos = 0;

                                        require_once("../../modelo/conexion.php");

                                        $bloqueo_intentos = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET estado_usuario = ?, intentos = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo_intentos->bind_Param("sss",$cambio_estado_bloqueo, $reiniciar_intentos ,$usuario);
                                        $bloqueo_intentos->execute();
                                        //HASTA ACA

                                        date_default_timezone_set("America/Tegucigalpa");
                                        $fecha_bloqueo = date('Y-m-d H:i:s',time());
                                        $objeto =1;
                                        $acciones = "usuario bloqueado";
                                        $descp = "Usuario bloqueado, realizo los 3 intentos permitidos para acceder al sistema";

                                        require_once("../../modelo/conexion2.php");
                                        $IntentosBitacora = $conn->prepare("CALL CONTROL_BITACORA (?,?,?,?,?);");
                                        $IntentosBitacora->bind_Param("sssss",$fecha_bloqueo,$id_usuario_bitacora,$objeto, $acciones, $descp);
                                        $IntentosBitacora->execute();

                                    } else {

                                        echo "<div class='text-center alert alert-danger' role = 'alert'>
                                        La contraseña o nombre de usuario son incorrectos.
                                        </div>";
                                  
                                        $int = $intentos_usuario + 1; 

                                        require_once("../../modelo/conexion.php");

                                        $bloqueo_intentos = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET intentos = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo_intentos->bind_Param("ss", $int ,$usuario);
                                        $bloqueo_intentos->execute();
                                        
                                        $objeto = 1;
                                        $acciones = "Error de sesion";
                                        $descp = "ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos";
                                        require_once("../../modelo/conexion2.php");
                                        $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                                        $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                                        $llamar->execute();
                                        $llamar->close();
                                    }
                                    
                                }
                            } elseif ($estado == "BLOQUEADO"){
                                echo "<div class='text-center alert alert-danger' role = 'alert'>
                                    El usuario ha sido bloqueado.
                                    </div>";

                                $objeto = 1;
                                $acciones = "usuario bloqueado";
                                $descp = "ERROR: intento de inicio de sesión con usuario bloqueado";
                                require_once("../../modelo/conexion2.php");
                                $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                                $llamar->execute();
                                $llamar->close();

                            } elseif ($estado == "NUEVO"){
                                $objeto = 1;
                                $acciones = "Usuario nuevo";
                                $descp = "Usuario nuevo, se redirige a la pantalla de configuracion de preguntas de seguridad";
                                require_once("../../modelo/conexion2.php");
                                $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                                $llamar->execute();
                                $llamar->close();

                                header("location:conf_preguntas.php");
                            }

                    } else {
                        echo "<div class='text-center alert alert-danger' role = 'alert'>
                            El usuario no existe.
                            </div>";

                        $objeto = 1;
                        $acciones = "No existe";
                        $descp = "se intentó ingresar al sistema con un usuario no registrado en la base de datos";
                        require_once("../../modelo/conexion2.php");
                        $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                        $llamar->execute();
                        $llamar->close();

                    }
                } else {
                    //$respuesta = array();
                    //AQUI UN MENSAJE DE ERROR
                    //array_push($respuesta,"usuario no existe");
                } 

                //$stmt->close();
                $conn = null;
            }
                
        } catch(Exception $e) {
            die("se produjo un error". $e->getMessage());
        }
        //die(json_encode($respuesta));
    }

    }
}