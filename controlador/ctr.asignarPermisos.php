<?php

    include "../modelo/conexionbd.php";
    
    $usuario = $_POST["usuario"];
    $rol = $_POST["rol"];
    $objeto_id = $_POST["objeto_id"];
    $insertar = $_POST["insertar"];
    $actualizar = $_POST["actualizar"];
    $eliminar = $_POST["eliminar"];
    $consultar = $_POST["consultar"];

    if(!empty($insertar) || !empty($actualizar) || !empty($eliminar) ||
        !empty($consultar) || !empty($usuario) || !empty($rol) || !empty($objeto_id)){

        try{
        
            //VERIFICAR SI EL USUARIO EXISTE
            $verificarUsuario = $conn->prepare("SELECT id_usuario, nombre_usuario FROM tbl_usuarios WHERE nombre_usuario = ?");
            $verificarUsuario->bind_Param("s", $usuario);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($idUsuario, $nombre);

            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                //SI EXISTE, PASAR A VERIFICAR SI EXISTE EL ROL
                if($existe){

                    //VERIFICA SI EL ROL EXISTE
                    include "../modelo/conexionbd.php";
                    $verificarRol = $conn->prepare("SELECT id_rol FROM tbl_roles WHERE rol = ?");
                    $verificarRol->bind_Param("s", $rol);
                    $verificarRol->execute();
                    $verificarRol->bind_Result($idRol);

                    if($verificarRol->affected_rows){
                        $existeRol = $verificarRol->fetch();

                        //SI EXISTE, PASAR A REGISTRAR LOS PERMISOS AL NUEVO ROL
                        if($existeRol){

                            $estado_eliminado = 1;
                            
                            date_default_timezone_set("America/Tegucigalpa");
                            $fecha = date("Y-m-d H:i:s", time());

                            //INSERTAR LOS PERMISOS DEL NUEVO ROL
                            include "../modelo/conexionbd.php";
                            $insertarPermisos = $conn->prepare("INSERT INTO tbl_permisos (permiso_insercion, permiso_eliminacion,
                                                                permiso_actualizacion, permiso_consulta, estado_eliminado, rol_id,
                                                                objeto_id, creado_por, fecha_creacion, modificado_por, fecha_modificacion)
                                                                VALUES(?,?,?,?,?,?,?,?,?,?,?);");
                            $insertarPermisos->bind_Param("iiiiiiissss", $insertar, $eliminar, $actualizar, $consultar, $estado_eliminado,
                                                                        $idRol, $objeto_id, $usuario, $fecha, $usuario, $fecha);
                            $insertarPermisos->execute();


                            if(!$insertarPermisos->error){

                                //SI LA INSERCION ES CORRECTA MOSTRAR ALERTA DE EXITO
                                $respuesta = array(
                                    "respuesta" => "exito"
                                );

                            } else {

                                //SI NO SE INSERTAN LOS DATOS A LA BD MOSTRAR ALERTA DE ERROR
                                $respuesta = array(
                                    "respuesta" => "error"
                                );

                            }

                        } else {
                            
                            //SI EL ROL NO EXISTE, MOSTRAR ALERTA DE ERROR
                            $respuesta = array(
                                "respuesta" => "rol_noExiste"
                            );

                        }

                    }

                } else {

                    //SI EL USUARIO NO EXISTE MOSTRAR ALERTA DE ERROR
                    $respuesta = array(
                        "respuesta" => "usuario_noExiste"
                    );
                }

            }

        } catch(Exception $e){

        }
     
        //IMPRIME LA INFORMACION DEL JSON
        echo json_encode($respuesta);
    }