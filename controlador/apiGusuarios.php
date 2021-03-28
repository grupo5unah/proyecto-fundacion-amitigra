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

                    try {
                        $sql = $conn->prepare("INSERT INTO tbl_usuarios (nombre_completo, nombre_usuario,foto, genero, telefono,correo,contrasena,
                rol_id,estado_id,fecha_ult_conexion,preguntas_contestadas,primer_ingreso, fecha_mod_contrasena,fecha_vencimiento,creado_por,fecha_creacion,
                modificado_por, fecha_modificacion) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $sql->bind_param(
                            "sssssssiisisssssss",
                            $nombreC,
                            $nombreusuario,
                            $foto,
                            $genero,
                            $telefono,
                            $correo,
                            $hashed_password,
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
                            $res['msj'] = "Se produjo un error al momento de registrar el Usuario";
                            $res['error'] = true;
                        } else {
                            $res['msj'] = "Usuario Registrado Correctamente";
                        }
                        // $sql->close();
                        // $sql = null;
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
                $res['msj'] = "El usuario se edito correctamente";
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
        //clave encriptada
        $id_usuario = (int)$_POST['id_usuario'];
        $contrasena = $_POST['Contraseña_reset'];
        $repcontra = $_POST['ConfirmarContraseña_reset'];
        $usuario_actual = $_POST['usuario_actual'];

        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);
        if (
            empty(($_POST['id_usuario'])) && empty(($_POST['Contraseña_reset'])) && empty($_POST['ConfirmarContraseña_reset'])
        ) {
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;
        } else {

            $sql = "UPDATE tbl_usuarios SET contrasena='$contrasena_hash' 
                    WHERE id_usuario=" . $id_usuario;
            $resultado = $conn->query($sql);

            if ($resultado > 0) {
                $res['msj'] = "La contraseña se Reseteo correctamente";


                $accion_realizada = 'reseteo de contraseña';
                $descripcion = 'se realizo reseteo de contraseña';
                $objeto = 7;

                //select para traer el id del usuario
                require('modelo/conexionbd.php');
                $consulid = mysqli_query($conn, "SELECT id_usuario
                FROM tbl_usuarios
                WHERE nombre_usuario='$usuario_actual'");
                $resulta = mysqli_fetch_array($consulid);

                if ($resulta > 0) {
                    $id_user = $resulta['id_usuario'];

                    //insertar en bitacora
                    $sql_insert = mysqli_query($conn, "INSERT INTO tbl_bitacora(accion,descripcion,fecha_accion,usuario_id,objeto_id)
                    VALUES('$accion_realizada','$descripcion',now(),$id_user,$objeto)");
                    if ($sql_insert) {
                        $res['msj'] = "Se inserto Correctamente en bitacora";
                    } else {
                        $res['msj'] = "no se inserto en bitacora";
                        $res['error'] = true;
                    }
                } else {
                    $res['msj'] = "no setrajo el id del usuario";
                    $res['error'] = true;
                }
            } else {
                $res['msj'] = "Se produjo un error al momento de resetear la contraseña";
                $res['error'] = true;
            }
        }
        break;


    case 'eliminarUsuario':
        if (isset($_POST['id_usuario'])) {
            $id_usuario = $_POST['id_usuario'];
            $sql = "DELETE FROM tbl_usuarios WHERE id_usuario = " . $id_usuario;
            $resultado = $conn->query($sql);
            if ($resultado > 0) {
                $res['msj'] = "Usuario Eliminado Correctamente";
            } else {
                $res['msj'] = "No se pudo eliminar el Usuario";
                $res['error'] = true;
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
