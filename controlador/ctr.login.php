<?php

include "../modelo/conexionbd.php";

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

    //verifica la informacion que viene por el metodo $_POST
    if(!empty($usuario) || !empty($contrasena)) {

        $parametro = 'INTENTOS_SESION';
        $respuesta = array();
        
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date("Y-m-d H:i:s", time());

        try {

            if(empty($usuario) || empty($contrasena)){
                $respuesta = array(
                    "respuesta" => "noCredenciales"
                );
            }else {
                //require_once "../../modelo/conexionbd.php";
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

                        $stmt1 = $conn->prepare("SELECT id_usuario, fecha_mod_contrasena, intentos, tbl_estado.nombre_estado, rol_id, tbl_roles.rol
                                                FROM tbl_usuarios
                                                INNER JOIN tbl_roles
                                                ON tbl_usuarios.rol_id = tbl_roles.id_rol
                                                INNER JOIN tbl_estado
                                                ON tbl_usuarios.estado_id = tbl_estado.id_estado
                                                WHERE nombre_usuario = ? OR id_usuario = ?; ");
                        $stmt1->bind_Param("si", $usuario, $id_usuario);
                        $stmt1->execute();
                        $stmt1->bind_result($user_id, $ingreso, $intentos_usuario, $estado_user, $rol_id, $rol);
                        
                        while ($stmt1->fetch()) {
                            $nombre_estado = $estado_user;
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

                        //ACTUALIZACIÓN A SWITCH
                        switch($nombre_estado){
                            case "ACTIVO":

                                if(password_verify($contrasena, $password_usuario)){

                                    if($dias_transcurridos <= 30){

                                        session_start();
                                        session_encode();
    
                                        $_SESSION['usuario'] = strtolower($usuario);
                                        $_SESSION['rol'] = $rol;
                                        $_SESSION['idRol'] = $rol_id;
                                        $_SESSION['primer_ingreso'] = $primer_ingreso;
                                        $_SESSION['id'] = $id_usuario_bitacora;

                                        //Ultima conexion
                                        $upd_conexion = $conn->prepare('UPDATE tbl_usuarios
                                                                        SET fecha_ult_conexion = ?
                                                                        WHERE id_usuario = ?;');
                                        $upd_conexion->bind_Param('si',$fecha_hoy, $id_usuario_bitacora);
                                        $upd_conexion->execute();

                                        //Registra en la BITACORA la accion realizada
                                        $objeto = 1;
                                        $acciones = "Inicio de sesión";
                                        $descp = "Inicio de sesión correctamente.";
                                        require_once("../modelo/conexionbd.php");
                                        $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                        $llamar->execute();
                                        $llamar->close();

                                        $respuesta =array(
                                            "respuesta" => "inicio_sesion"
                                        );
    
                                    }else {

                                        $respuesta = array(
                                            "respuesta" => "cambio_estado"
                                        );

                                        $cambio_estado_usuario = 2;

                                        require_once("../modelo/conexionbd.php");

                                        $bloqueo = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET estado_id = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo->bind_Param("is",$cambio_estado_usuario ,$usuario);
                                        $bloqueo->execute();
    
                                    }
    
                                } else {
                                    //NOTA: El codigo comentado no funciona, hace la consulta pero no actualiza los intentos
                                    
                                    require '../modelo/conexionbd.php';
                                    $intentos_parameter = $conn->prepare("SELECT valor FROM tbl_parametros WHERE parametro = ?;");
                                    $intentos_parameter->bind_Param("s",$parametro);
                                    $intentos_parameter->execute();
                                    $intentos_parameter->bind_Result($valor);

                                    if($intentos_parameter->affected_rows){                                     
                                        $intento_existe = $intentos_parameter->fetch();

                                        if($intento_existe){

                                            if($intentos_usuario == intval($valor)){
                                                
                                                $respuesta = array(
                                                    "respuesta" => "bloqueado_intentos"
                                                );
                                                    
                                                require "../modelo/conexionbd.php";

                                                $estado_bloqueo = 2;
                                                $reiniciar_intentos = 0;
            
                                                $bloqueo_intento = $conn->prepare("UPDATE tbl_usuarios 
                                                                                    SET intentos = ?, estado_id = ? WHERE nombre_usuario = ?;");
                                                $bloqueo_intento->bind_Param("iis", $reiniciar_intentos, $estado_bloqueo, $usuario);
                                                $bloqueo_intento->execute();
                                                //HASTA ACA

                                                date_default_timezone_set("America/Tegucigalpa");
                                                $fecha_bloqueo = date('Y-m-d H:i:s',time());
                                                $objeto =1;
                                                $acciones = "usuario bloqueado";
                                                $descp = "Usuario bloqueado, realizó los 3 intentos permitidos para acceder al sistema";
            
                                                require_once("../modelo/conexionbd.php");
                                                $IntentosBitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                                                $IntentosBitacora->bind_Param("sssii", $acciones, $descp, $fecha_bloqueo, $id_usuario_bitacora, $objeto);
                                                $IntentosBitacora->execute();        
            
                                                //Si es el usuario super admin no se bloquea
                                            } elseif($intentos_usuario <= intval($valor) && $id_usuario_bitacora == 1){

                                                $respuesta = array(
                                                    "respuesta" => "error_contrasena"
                                                );

                                                require "../modelo/conexionbd.php";

                                                $ints = $intentos_usuario + 0;
                                                
                                                $bloqueo_no_admin = $conn->prepare("UPDATE tbl_usuarios SET intentos = ? WHERE nombre_usuario = ?;");
                                                $bloqueo_no_admin->bind_Param("is", $ints ,$usuario);
                                                $bloqueo_no_admin->execute();
                                            }else {
            
                                                //Muesta un mensaje cuando el usuario ingresa mal su contrasena
                                                $respuesta = array(
                                                    "respuesta" => "error_contrasena"
                                                );

                                                require "../modelo/conexionbd.php";

                                                $int = $intentos_usuario + 1;
            
                                                $bloqueo_intentos = $conn->prepare("UPDATE tbl_usuarios SET intentos = ? WHERE nombre_usuario = ?;");
                                                $bloqueo_intentos->bind_Param("is", $int ,$usuario);
                                                $bloqueo_intentos->execute();

                                                if(!$bloqueo_intentos->error){
                                                    /*Genera un registro de error en la tbl_bitacora al no ingresar
                                                    correctamente su correo y contrasena*/ 
                                                    $objeto = 1;
                                                    $acciones = "Error de sesion";
                                                    $descp = "ERROR: fallo al iniciar sesión: contraseña o nombre de usuario incorrectos";
                                                    require_once("../modelo/conexionbd.php");
                                                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                                    $llamar->execute();
                                                    $llamar->close();
                                                }
                                                
                                            }

                                        }
                                    }
                                    
                                }
                        
                                break;

                            case "BLOQUEADO":

                                /*Genera un registro de error en la tbl_bitacora por intento de acceso al sistema
                                    con usuario bloqueado*/

                                $respuesta = array(
                                    "respuesta" => "bloqueado"
                                );

                                $objeto = 1;
                                $acciones = "usuario bloqueado";
                                $descp = "ERROR: intento de inicio de sesión con usuario bloqueado";
                                require_once '../modelo/conexionbd.php';
                                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                $llamar->execute();
                                $llamar->close();
                                break;

                            case "NUEVO":
                                /*Cuando el usuario es nuevo (el cual no se auto-registro sino que fue el administrador
                                quien realizo el registro) se redirige a la pantalla preguntas para que las pueda configurar
                                para el proximo intento de inicio de sesion lo podra hacer sin ningun problema*/
                                $objeto = 1;
                                $acciones = "Usuario nuevo";
                                $descp = "Usuario nuevo, se redirige a la pantalla de configuracion de preguntas de seguridad";
                                require_once("../modelo/conexionbd.php");
                                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                $llamar->execute();
                                $llamar->close();

                                $contrasenaCorrecta = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
                                $contrasenaCorrecta->bind_Param("s",$usuario);
                                $contrasenaCorrecta->execute();
                                $contrasenaCorrecta->bind_Result($contrasenaVerificar);

                                if($contrasenaCorrecta->affected_rows){
                                    $existeContrasena = $contrasenaCorrecta->fetch();

                                    if($existeContrasena){

                                        if(password_verify($contrasena, $contrasenaVerificar)){
                                            session_start();
                                            session_encode();
                
                                            $_SESSION['usuario'] = strtolower($usuario);

                                            $respuesta = array(
                                                "respuesta" => "redirigiendo"
                                            );
                                        }else{
                                            $respuesta = array(
                                                "respuesta" => "no_verificada"
                                            );
                                        }
                                    }
                                }

                                break;
                            case "NO_ACTIVO":
                                /*Redirige a una nueva pantalla cuando el usuario se auto-registro y
                                esta pendiente de recibir alta*/
                                
                                require "../modelo/conexionbd.php";
                                $verificarContrasena = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
                                $verificarContrasena->bind_Param("s", $usuario);
                                $verificarContrasena->execute();
                                $verificarContrasena->bind_Result($ContrasenaUsusario);

                                if($verificarContrasena->affected_rows){
                                    $existePass = $verificarContrasena->fetch();

                                    if($existePass){

                                        if(password_verify($contrasena, $ContrasenaUsusario)){
                                            //Si la contrasena es correcta accede a la pantalla de pendientes

                                            session_start();
                                            session_encode();
                
                                            $_SESSION['usuario'] = strtolower($usuario);

                                            $respuesta = array(
                                                "respuesta" => "no_activo"
                                            );

                                        }else{

                                            $respuesta = array (
                                                "respuesta" => "error_no_activo"
                                            );
                                        }
                                    }
                                }
                                break;

                            default:

                                break;
                        }       

                    } else {
                        /*Muestra mensaje de usuario no existente*/

                        $respuesta =array(
                            "respuesta" => "usuario_noExiste"
                        );

                            
                        /*Genera registro de intento de inicio de sesion con usuario no existente*/
                        $objeto = 1;
                        $acciones = "No existe";
                        $descp = "Intentó de ingreso al sistema con usuario no registrado";
                        require "../modelo/conexionbd.php";
                        $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
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


          
    } else{
        $respuesta = array(
            "respuesta" => "noCredenciales"
        );
    }

    echo json_encode($respuesta);