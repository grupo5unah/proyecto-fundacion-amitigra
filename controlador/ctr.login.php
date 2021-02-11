<?php
//Clase inicio de sesión

//namespace app;

class Login{

    public function ctrLogin(){
    //verifica que sea lo que viene mediante el metodo $_POST
    if(isset($_POST['tipo']) == 'login') {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

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
                                if(password_verify($password, $password_usuario)){

                                    if($dias_transcurridos <= 30){
                                        session_start();
                                        if($_POST['usuario'] == $usuario && $_POST['password']== $password){
                                            $_SESSION['usuario'] = true;
                                            session_regenerate_id();
    
                                        }
                                        session_encode();
    
                                        $_SESSION['usuario'] = strtolower($usuario);
                                        $_SESSION['rol'] = $rol;
                                        $_SESSION['primer_ingreso'] = $primer_ingreso;
    
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
                                    }else{
    
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
    
                                    $intentos = 3;
    
                                    if($intentos_usuario == $intentos){
    
                                        echo "<div class='alert alert-danger text-center' role='alert'>
                                            El usuario a sido bloqueado ya que realizó los 3 intentos permitidos.
                                            </div>";
                                            
                                        //ESTA PARTE SE VA A REMOVER
                                        $cambio_estado_bloqueo = 3;
                                        $reiniciar_intentos = 0;
    
                                        require_once("../../modelo/conexionbd.php");
    
                                        $bloqueo_intentos = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET estado_id = ?, intentos = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo_intentos->bind_Param("iss",$cambio_estado_bloqueo, $reiniciar_intentos ,$usuario);
                                        $bloqueo_intentos->execute();
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
                                    
                                        $int = $intentos_usuario + 1; 
    
                                        require_once("../../modelo/conexionbd.php");
    
                                        $bloqueo_intentos = $conn->prepare("UPDATE tbl_usuarios
                                                                    SET intentos = ?
                                                                    WHERE nombre_usuario = ?;");
                                        $bloqueo_intentos->bind_Param("ss", $int ,$usuario);
                                        $bloqueo_intentos->execute();
                                        
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

                        /*if ($nombre_estado =="ACTIVO"){   
                            
                            
                        } elseif ($nombre_estado == "BLOQUEADO"){
                            

                        } elseif ($nombre_estado == "NUEVO"){
                            
                        }*/

                } else {
                    /*Muestra mensaje de usuario no existente*/
                    echo "<div class='text-center alert alert-danger' role = 'alert'>
                        El usuario no existe.
                        </div>";

                    /*Genera registro de intento de inicio de sesion con usuario no existente*/
                    $objeto = 1;
                    $acciones = "No existe";
                    $descp = "Se intentó ingresar al sistema con un usuario no registrado en la base de datos";
                    require_once("../../modelo/conexionbd.php");
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