<?php
    include "../modelo/conexionbd.php";

    $contrasena = $_POST["contrasena"];
    $usuario = $_POST["usuario"];
    $path = $_POST["path"];

    if(!empty($usuario) || !empty($contrasena) || !empty($path)){
        
        $verificarContrasena = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
        $verificarContrasena->bind_Param("s", $usuario);
        $verificarContrasena->execute();
        $verificarContrasena->bind_result($contrasenaUsuario);

        if($verificarContrasena->affected_rows){
            $existe = $verificarContrasena->fetch();

            if($existe){

                if(password_verify($contrasena, $contrasenaUsuario)){

                    $host = 'localhost';
                    $nombre_usuariobd = 'root';
                    $contrasena_usuariobd = '';
                    $nombre_bd = 'copia_base_datos';
                    $ubicacion_path = "copiaSeguridad/".$path;
        
                    // Conexion y seleccion de la base de datos
                    $db = new mysqli($host, $nombre_usuariobd, $contrasena_usuariobd, $nombre_bd);
                
                    // Guarda la consulta actual
                    $consulta_actual = '';
                    
                    // lee el archivo completo
                    $leer_archivo = file($ubicacion_path);
                    
                    $error = '';
                    
                    // Recorre cada linea
                    foreach ($leer_archivo as $line){
                        // Omite si es un comentario
                        if(substr($line, 0, 2) == '--' || $line == ''){
                            continue;
                        }
                        
                        // Add this line to the current segment
                        $consulta_actual .= $line;
                        
                        // Si tiene un punto y coma al final, es el final de la consulta.
                        if (substr(trim($line), -1, 1) == ';'){
                            // Realiza la consulta
                            if(!$db->query($consulta_actual)){
                                $error .= 'Se produjo un error al momento de realizar el respaldo "<b>' . $consulta_actual . '</b>": ' . $db->error . '<br /><br />';
                            }
                            
                            // Resetea la variable temporal
                            $consulta_actual = '';
                        }
                    }

                    $respuesta = array(
                        "respuesta" => "exito"
                    );

                }else{
                    $respuesta = array(
                        "respuesta" => "incorrecta"
                    );
                }

            }
        }

        echo json_encode($respuesta);
    }