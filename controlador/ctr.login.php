<?php
//Clase inicio de sesión

//namespace app;
global $cambio_estado_bloqueo;
global $reiniciar_intentos;
global $estado_bloqueo;
global $valor;
global $conn;
//require '../../modelo/conexionbd.php';

class Login{

    public function ctrLogin(){
    //verifica la informacion que viene por el metodo $_POST
    if(isset($_POST['tipo']) == 'login') {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $parametro = 'INTENTOS_SESION';

        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date("Y-m-d H:i:s", time());

        try {

            require_once "../../modelo/conexionbd.php";

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

                    $stmt1 = $conn->prepare("SELECT id_usuario, primer_ingreso, intentos, tbl_estado.nombre_estado, rol_id, tbl_roles.rol
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
                            case 'ACTIVO':

                                date_default_timezone_set("America/Tegucigalpa");
                                $permiso = date('H:i', time());

                                if ($permiso == '00:00:00'){//VERIFICA LA HORA SI ES PASADO DE ESE TIEMPO NO PERMITE EL ACCESO
                                    echo '<div class="text-center alert alert-danger" role="alert">
                                            Acceso denegado
                                            </div>';
                                           
                                } else { //CASO CONTRARIO SI LO PERMITE
                                
                                if(password_verify($password, $password_usuario)){

                                    if($dias_transcurridos <= 30){
                                        session_start();
                                        session_encode();
    
                                        $_SESSION['usuario'] = strtolower($usuario);
                                        $_SESSION['rol'] = $rol;
                                        $_SESSION['primer_ingreso'] = $primer_ingreso;
                                        $_SESSION['id'] = $id_usuario_bitacora;

                                        //Ultima conexion
                                        date_default_timezone_set("America/Tegucigalpa");
                                        $fecha_conexion = date('Y-m-d H:i:s', time());

                                        $upd_conexion = $conn->prepare('UPDATE tbl_usuarios
                                                                        SET fecha_ult_conexion = ?
                                                                        WHERE id_usuario = ?;');
                                        $upd_conexion->bind_Param('si',$fecha_conexion, $id_usuario_bitacora);
                                        $upd_conexion->execute();

                                        //Registra en la BITACORA la accion realizada
                                        $objeto = 1;
                                        $acciones = "Inicio de sesion";
                                        $descp = "Inicio de sesion correctamente";
                                        require_once("../../modelo/conexionbd.php");
                                        $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                        $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                        $llamar->execute();
                                        $llamar->close();
    
                                        sleep(2);
                                        header('location:../../index.php');
                                    }else {
    
                                        echo "<div class='text-center alert alert-danger' role = 'alert'>
                                            su usuario a sido bloqueado.
                                            </div>";
    
                                        $cambio_estado_usuario = 3;
    
                                        require_once("../../modelo/conexionbd.php");
    
                                        $bloqueo = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET estado_id = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo->bind_Param("is",$cambio_estado_usuario ,$usuario);
                                        $bloqueo->execute();
    
                                        if($bloqueo->error){
                                            echo "se produjo un error en la actualizacion";
                                        } else{
                                            echo "El estado del usuario se actualizo con exito";
                                        }
    
                                    }
    
                                } else {
                                    //NOTA: El codigo comentado no funciona, hace la consulta pero no actualiza los intentos
                                    
                                    require '../../modelo/conexionbd.php';
                                    $intentos_parameter = $conn->prepare("SELECT valor FROM tbl_parametros WHERE parametro = ?;");
                                    $intentos_parameter->bind_Param("s",$parametro);
                                    $intentos_parameter->execute();
                                    $intentos_parameter->bind_Result($valor);

                                    if($intentos_parameter->affected_rows){                                     
                                        $intento_existe = $intentos_parameter->fetch();

                                        if($intento_existe){

                                            if($intentos_usuario == intval($valor)){
                                                
                                                echo "<div class='alert alert-danger text-center' role='alert'>
                                                    El usuario a sido bloqueado ya que realizó los 3 intentos permitidos.
                                                    </div>";
                                                    
                                                require "../../modelo/conexionbd.php";

                                                $estado_bloqueo = 3;
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
            
                                                require_once("../../modelo/conexionbd.php");
                                                $IntentosBitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                                                $IntentosBitacora->bind_Param("sssii", $acciones, $descp, $fecha_bloqueo, $id_usuario_bitacora, $objeto);
                                                $IntentosBitacora->execute();        
            
                                            } else {
            
                                                //Muesta un mensaje cuando el usuario ingresa mal su contrasena
                                                echo "<div class='text-center alert alert-danger' role = 'alert'>
                                                La contraseña o nombre de usuario son incorrectos.
                                                </div>";
            
                                                require "../../modelo/conexionbd.php";

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
                                                    require_once("../../modelo/conexionbd.php");
                                                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                                    $llamar->execute();
                                                    $llamar->close();
                                                }
                                                
                                            }

                                        }
                                    }
                                    
                                }
                                }
                                break;
                            case 'BLOQUEADO':
                                //Muestra un mensaje de que el usuario fue bloqueado (el bloqueo se produjo previamente)
                                echo "<div class='text-center alert alert-danger' role = 'alert'>
                                Su usuario se encuentra bloqueado.
                                </div>";

                                /*Genera un registro de error en la tbl_bitacora por intento de acceso al sistema
                                    con usuario bloqueado*/
                                $objeto = 1;
                                $acciones = "usuario bloqueado";
                                $descp = "ERROR: intento de inicio de sesión con usuario bloqueado";
                                require_once '../../modelo/conexionbd.php';
                                $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                $llamar->execute();
                                $llamar->close();
                                break;

                                case 'NUEVO':
                                    /*Cuando el usuario es nuevo (el cual no se auto-registro sino que fue el administrador
                                    quien realizo el registro) se redirige a la pantalla preguntas para que las pueda configurar
                                    para el proximo intento de inicio de sesion lo podra hacer sin ningun problema*/
                                    $objeto = 1;
                                    $acciones = "Usuario nuevo";
                                    $descp = "Usuario nuevo, se redirige a la pantalla de configuracion de preguntas de seguridad";
                                    require_once("../../modelo/conexionbd.php");
                                    $llamar = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                                    $llamar->bind_Param("sssii", $acciones, $descp, $fecha, $id_usuario_bitacora, $objeto);
                                    $llamar->execute();
                                    $llamar->close();

                                    header("location:conf_preguntas.php");
                                    break;
                        }

                } else {
                    /*Muestra mensaje de usuario no existente*/
                    echo "<div class='text-center alert alert-danger' role = 'alert'>
                        El usuario no existe.
                        </div>";

                    /*Genera registro de intento de inicio de sesion con usuario no existente*/
                    $objeto = 1;
                    $acciones = "No existe";
                    $descp = "Intentó de ingreso al sistema con usuario no registrado";
                    require "../../modelo/conexionbd.php";
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

                
        } catch(Exception $e) {
            die("se produjo un error". $e->getMessage());
        }
        //die(json_encode($respuesta));
    }

    }
}