<?php

include "../modelo/conexionbd.php";

$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'obtenerUsuario': // OBTIENE UN USUARIO POR NOMBRE DE USUARIO
        $nombre_usuario = $_GET['nombre_usuario'];
        $correo = $_GET['correo'];
        $sql = "SELECT nombre_usuario,correo,id_usuario
        FROM tbl_usuarios WHERE nombre_usuario = '" . $nombre_usuario . "' & correo='" . $correo . "'";
        $result = $conn->query($sql);
        $user_db = array();
        while ($row = $result->fetch_assoc()) {
            array_push($user_db, $row);
        }
        $res['nombre_usuario'] = $user_db;
        break;

    case 'registrarUsuario': // REGISTRA UN USUARIO
        $nombreC = $_POST['nombreCompleto'];
        $nombreusuario = $_POST['nombreusuario'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $Contraseña = $_POST['Contraseña'];
        $ConfirmarContraseña = $_POST['ConfirmarContraseña'];
        $genero = $_POST['genero'];
        $rol = $_POST['rol'];
        $estado = 4;
        $usuario_actual = $_POST['usuario_actual'];

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
            try {
                $sql = $conn->prepare("INSERT INTO tbl_usuarios (nombre_completo, nombre_usuario, genero, telefono,correo,contrasena,
                rol_id,estado_id,fecha_ult_conexion,preguntas_contestadas,primer_ingreso,fecha_vencimiento,creado_por,fecha_creacion,
                modificado_por, fecha_modificacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $sql->bind_param(
                    "ssssssiisissssss",
                    $nombreC,
                    $nombreusuario,
                    $genero,
                    $telefono,
                    $correo,
                    $hashed_password,
                    $rol,
                    $estado,
                    $fecha,
                    $preguntas,
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
        }
        break;
    case 'actualizarUsuario':

        if (
            isset(($_POST['id_usuario'])) && isset($_POST['nombre_completo']) && isset($_POST['nombre_usuario']) && isset($_POST['telefono'])
            && isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_POST['rol_id']) && isset($_POST['estado_id'])
        ) {
            $id_usuario = (int)$_POST['id_usuario'];
            $nombrec = $_POST['nombre_completo'];
            $nombreu = $_POST['nombre_usuario'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $contrasena_hash = password_hash($_POST['contrasena'],PASSWORD_BCRYPT);
            $rol_id = $_POST['rol_id'];
            $estado_id = $_POST['estado_id'];
            //clave encriptada
           //$contrasena_hash=password_hash($contrasena, PASSWORD_BCRYPT);


            $sql = "UPDATE tbl_usuarios SET nombre_completo = '$nombrec', nombre_usuario = '$nombreu',
            telefono='$telefono', correo='$correo', contrasena='$contrasena_hash', rol_id=$rol_id, estado_id=$estado_id
            WHERE id_usuario=" . $id_usuario;
            $resultado = $conn->query($sql);

            if ($resultado == 1) {
                //print_r($resultado);
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
    case 'eliminarUsuario':
        if (isset($_POST['id_usuario'])) {
            $id_usuario = $_POST['id_usuario'];
            $sql = "DELETE FROM tbl_usuarios WHERE id_usuario = " . $id_usuario;
            $resultado = $conn->query($sql);
            if ($resultado == 1) {
                $res['msj'] = "Usuario Eliminado Correctamente";
            } else {
                $res['msj'] = "Se produjo un error al momento de eliminar el Usuario";
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
