<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';


if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {

    case 'registrarUsuario': // REGISTRA UN USUARIO
        $nombreC = $_POST['nombreCompleto'];
        $nombreusuario = $_POST['nombreusuario'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $Contraseña = $_POST['Contraseña'];
        $ConfirmarContraseña = $_POST['ConfirmarContraseña'];
        $genero = $_POST['genero'];
        $rol = $_POST['rol'];
        $estado = 3;
        $usuario_actual = $_POST['usuario_actual'];
        $foto = "foto";

        $preguntas = 0;
        $intentos = 0;
        $hashed_password = password_hash($Contraseña, PASSWORD_BCRYPT);

        //Fecha ACTUAL del sistema
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('Y-m-d H:i:s', time());

        //Genera la fecha del proximo mes
        $fecha_actual = new DateTime($fecha);
        $fecha_actual->modify('next month');
        $vencimiento = $fecha_actual->format('Y-m-d H:i:s');

        if (
            empty($_POST['nombreCompleto']) || empty($_POST['nombreusuario'])  || empty($_POST['telefono'])
            || empty($_POST['correo']) || empty($_POST['Contraseña']) || empty($_POST['ConfirmarContraseña'])
            || empty($_POST['genero']) || empty($_POST['rol'])
        ) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

            $query = mysqli_query($conn, "SELECT * FROM tbl_usuarios WHERE nombre_usuario = '$nombreusuario' OR correo = '$correo' ");
            $result = mysqli_fetch_array($query);

            if ($result > 0) {
                $res['msj'] = "El usuario o correo ya existe";
                $res['error'] = true;
            } else {
                //Validacion contrasenas iguales
                if ($Contraseña == $ConfirmarContraseña) {
                    // insertar en la tabla tbl_usuarios
                    if ($genero === "femenino") {
                        $foto = "femenino.png";
                    } else {
                        $foto = "masculino.png";
                    }
                    try {
                        $sql = $conn->prepare("INSERT INTO tbl_usuarios (nombre_completo, nombre_usuario,foto, genero, telefono,correo,contrasena,
                intentos,rol_id,estado_id,fecha_ult_conexion,preguntas_contestadas,primer_ingreso, fecha_mod_contrasena,fecha_vencimiento,creado_por,fecha_creacion,
                modificado_por, fecha_modificacion) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $sql->bind_param(
                            "sssssssiiisisssssss",
                            $nombreC,
                            $nombreusuario,
                            $foto,
                            $genero,
                            $telefono,
                            $correo,
                            $hashed_password,
                            $intentos,
                            $rol,
                            $estado,
                            $fecha,
                            $preguntas,
                            $fecha,
                            $fecha,
                            $vencimiento,
                            $usuario_actual,
                            $fecha,
                            $usuario_actual,
                            $fecha
                        );
                        $sql->execute();

                        if ($sql->error) {

                            //select para traer el id del usuario
                            $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                            WHERE nombre_usuario='$usuario_actual'");
                            $resulta = mysqli_fetch_array($consulid);
                            if ($resulta > 0) {
                                $id_user = $resulta['id_usuario'];
                            }

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Error al crear usuario";
                            $descripcion = "Se intentó registrar un nuevo usuario";
                            $objeto = 20;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();

                            $res['msj'] = "Se produjo un error al momento de registrar el Usuario";
                            $res['error'] = true;
                        } else {

                               //select para traer el id del usuario
                               $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                               WHERE nombre_usuario='$usuario_actual'");
                               $resulta = mysqli_fetch_array($consulid);
                               if ($resulta > 0) {
                                   $id_user = $resulta['id_usuario'];
   
                                   date_default_timezone_set("America/Tegucigalpa");
                                   $fechaAccion = date("Y-m-d H:i:s", time());
   
                                   $accion = "Autoregistro de usuario";
                                   $descripcion = "Se registró un nuevo usuario por el administrador";
                                   $objeto = 20;
                                   include "../modelo/conexionbd.php";
   
                                   //INSERTAR LA ACCION EN BITACORA
                                   $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                                   $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                                   $bitacora->execute();
                           
                                   $res['msj'] = "Usuario creado con éxito";
   
   
                                  
                               }

                            require '../funciones/config_serverMail.php';
                                   
                            $mail->addAddress($_POST['correo']);
                            $mail->Subject = "Confirmacion creación de cuenta";
                            $mail->Body = "<h3>Hola: {$nombreusuario} </h3><h4>Te damos la bienvenida a nuestro sistema.</h4>
                                        <p>A continuación te brindamos tus credenciales:</p>
                                        <p>Nombre de usuario: {$nombreusuario}</p>
                                        <p>Contraseña: {$Contraseña}</p>></br>
                                        <a href='http://fundacionamitigra.com/vista/modulos/login.php' Haga clic aquí para su primer inicio de sesión</a>
                                       
                                        <p> <spam><strong>Nota:<strong></spam> no compartas tus credenciales con nadie.</p>";

                            if ($mail->send()) {
                            }
  
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } else {
                    $res['msj'] = "La contraseñas no coinciden";
                    $res['error'] = true;
                }
            }
        }
        break;
    case 'actualizarUsuario':

        if (
            isset(($_POST['id_usuario'])) && isset($_POST['nombre_completo']) && isset($_POST['nombre_usuario'])
            && isset($_POST['telefono'])
            && isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_POST['rol_id'])
            && isset($_POST['estado_id'])
        ) {
            $id_usuario = (int)$_POST['id_usuario'];
            $nombrec = $_POST['nombre_completo'];
            $nombreu = $_POST['nombre_usuario'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $contrasena_hash = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
            $rol_id = $_POST['rol_id'];
            $estado_id = $_POST['estado_id'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());


            $sql = "UPDATE tbl_usuarios SET nombre_completo = '$nombrec', nombre_usuario = '$nombreu',
            telefono='$telefono', correo='$correo', rol_id=$rol_id, estado_id=$estado_id,modificado_por='$usuario_actual',
            fecha_modificacion=' $fecha'
            WHERE id_usuario=" . $id_usuario;
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                //select para traer el id del usuario
                $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                WHERE nombre_usuario='$usuario_actual'");
                $resulta = mysqli_fetch_array($consulid);
                if ($resulta > 0) {
                    $id_user = $resulta['id_usuario'];

                    date_default_timezone_set("America/Tegucigalpa");
                    $fechaAccion = date("Y-m-d H:i:s", time());

                    $accion = "Actualización de datos de usuario";
                    $descripcion = "Se actualizaron datos de un usuario por el administrador";
                    $objeto = 20;
                    include "../modelo/conexionbd.php";

                    //INSERTAR LA ACCION EN BITACORA
                    $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                    $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                    $bitacora->execute();
                }
                $res['msj'] = "Usuario actualizado con éxito";
            } else {
                $res['msj'] = "Se produjo un error al momento de editar el Isuario ";
                $res['error'] = true;
            }
        } else {
            //print_r($id_inventario);
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }

        break;

    case 'resetearClave':
        if (
            isset(($_POST['id_usuario'])) && isset($_POST['contrasena'])
        ) {
            $id_usuario = $_POST['id_usuario'];

            $contrasena = $_POST['contrasena'];
            $confirmacontra = $_POST['confirmacontrasena'];
            $usuario_actual = $_POST['usuario_actual'];
            $fecha = date('Y-m-d H:i:s', time());

            if ($contrasena == $confirmacontra) {
                $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

                $sql = "UPDATE tbl_usuarios SET contrasena='$contrasena_hash',fecha_mod_contrasena='$fecha', 
                modificado_por='$usuario_actual',fecha_modificacion=' $fecha'
                WHERE id_usuario=" . $id_usuario;
                $resultado = $conn->query($sql);


                if ($resultado > 0) {

                    //select para traer el id del usuario
                    $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
        WHERE nombre_usuario='$usuario_actual'");
                    $resulta = mysqli_fetch_array($consulid);
                    if ($resulta > 0) {
                        $id_user = $resulta['id_usuario'];

                        date_default_timezone_set("America/Tegucigalpa");
                        $fechaAccion = date("Y-m-d H:i:s", time());

                        $accion = "Reseteo de contraseña";
                        $descripcion = "Se realizó reseteo de contraseña por parte del administrador";
                        $objeto = 20;
                        include "../modelo/conexionbd.php";

                        //INSERTAR LA ACCION EN BITACORA
                        $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                        $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                        $bitacora->execute();
                    }

                    $res['msj'] = "contraseña reseteada con éxito";
                } else {
                    $res['msj'] = "Se produjo un error al momento de resetear la contraseña";
                    $res['error'] = true;
                }
            } else {
                $res['msj'] = "Las contraseñas no coinciden";
                $res['error'] = true;
            }
        } else {
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
        break;





    case 'eliminarUsuario':
        if (isset($_POST['id_usuario'])) {
            $id_usuario = $_POST['id_usuario'];
            $usuario_actual = $_POST['usuario_actual'];

            //convertir el usuario actual a mayuscula
            $usuario_actual = strtoupper($usuario_actual);


            //consulta para traer el usuario que se desea eliminar

            $consulta_usuario = mysqli_query($conn, "SELECT id_usuario,nombre_usuario FROM tbl_usuarios 
            WHERE id_usuario=$id_usuario");
            $resultado_usuario = mysqli_fetch_array($consulta_usuario);

            if ($resultado_usuario > 0) {
                $usuario_traido = $resultado_usuario['nombre_usuario'];


                if ($usuario_traido == $usuario_actual) {

                    //select para traer el id del usuario
                    $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                WHERE nombre_usuario='$usuario_actual'");
                    $resulta = mysqli_fetch_array($consulid);
                    if ($resulta > 0) {
                        $id_user = $resulta['id_usuario'];

                        date_default_timezone_set("America/Tegucigalpa");
                        $fechaAccion = date("Y-m-d H:i:s", time());

                        $accion = "Eliminación del usuario logueado";
                        $descripcion = "Se intentó eliminar el usuario logueado actualmente";
                        $objeto = 20;
                        include "../modelo/conexionbd.php";

                        //INSERTAR LA ACCION EN BITACORA
                        $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                        $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                        $bitacora->execute();
                    }

                    $res['msj'] = "El usuario actual no se puede eliminar";
                    $res['error'] = true;
                } else {

                    $sql = "DELETE FROM tbl_usuarios WHERE id_usuario = " . $id_usuario;
                    $resultado = $conn->query($sql);
                    if ($resultado > 0) {
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Eliminación de un usuario";
                            $descripcion = "Se eliminó un usuario por el administrador";
                            $objeto = 20;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                        $res['msj'] = "Usuario eliminado con éxito";
                    } else {
                        //select para traer el id del usuario
                        $consulid = mysqli_query($conn, "SELECT id_usuario FROM tbl_usuarios
                        WHERE nombre_usuario='$usuario_actual'");
                        $resulta = mysqli_fetch_array($consulid);
                        if ($resulta > 0) {
                            $id_user = $resulta['id_usuario'];

                            date_default_timezone_set("America/Tegucigalpa");
                            $fechaAccion = date("Y-m-d H:i:s", time());

                            $accion = "Eliminación de un usuario";
                            $descripcion = "Se intentó eliminar un usuario";
                            $objeto = 20;
                            include "../modelo/conexionbd.php";

                            //INSERTAR LA ACCION EN BITACORA
                            $bitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                            $bitacora->bind_Param("sssii", $accion, $descripcion, $fechaAccion, $id_user, $objeto);
                            $bitacora->execute();
                        }
                        $res['msj'] = "No se pudo eliminar el usuario";
                        $res['error'] = true;
                    }
                }
            }
        } else {
            $res['msj'] = "Las variables no estan definidas";
            $res['error'] = true;
        }
        break;


    default:

        break;
}

$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);
