<?php

    class NuevaContrasena{

        public function ctrNuevaContrasena(){

            if(isset($_GET['eid']) && isset($_GET['tkn']) && isset($_GET['exd'])){

                //$correo = urldecode(base64_decode($_GET['eid']));
                $validacion = urldecode(base64_decode($_GET['tkn']));
                $expire_date = urldecode(base64_decode($_GET['exd']));
                            
                date_default_timezone_set("America/Tegucigalpa");
                $current_date = date("Y-m-d H:i:s");

                if($expire_date <= $current_date) {
                    echo "<div class='text-center alert alert-danger' role='alert'>
                            Lo sentimos, el enlace ya no es válido
                            </div>";
                } else {
                    if(isset($_POST['tipo']) == 'nuevaContrasena') {
                        $password = $_POST['password'];
                        $confpassword = $_POST['password2'];

                        if($password == $confpassword) {

                            require_once('../../modelo/conexionbd.php');
                            $Verificar = $conn->prepare("SELECT id_usuario, nombre_usuario FROM tbl_usuarios WHERE token = ? ;");
                            $Verificar->bind_Param("s",$validacion);
                            $Verificar->execute();
                            $Verificar->bind_Result($id_usuario, $nombre_usuario);

                            while ($Verificar->fetch()) {
                                $id = $id_usuario;
                            }

                            if($Verificar->affected_rows){
                                $existe = $Verificar->fetch();
                                if(!$existe){
                                    $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
                                    if(!preg_match($pattern_up, $password)) {
                                        echo "Debe tener al menos 8 caracteres de largo, 1 mayúscula, 1 letra minúscula, 1 caracter espececial y 1 número.";
                                    } else {
                                        //Estado del usuario
                                        $estado_del_usuario = 2;
                                        //Se extrae la fecha actual
                                        date_default_timezone_set("America/Tegucigalpa");
                                        $fecha_hoy = date('Y-m-d H:i:s', time());
                                        //Calcula el proximo mes
                                        $fecha_actual = new DateTime($fecha_hoy);
                                        $fecha_actual->modify('next month');
                                        $nueva_fecha_vencimiento = $fecha_actual->format('Y-m-d H:i:s');

                                        //Contrasena HASHADA
                                        $hash_password = password_hash($password, PASSWORD_BCRYPT);
                                        $vacio = "";

                                        
                                        exit;
                                        
                                        require_once('../../modelo/conexionbd.php');
                                        $Actualizacion = $conn->prepare("UPDATE tbl_usuarios
                                        SET contrasena = ?, token = ?, primer_ingreso = ?, estado_id = ?, fecha_vencimiento = ?
                                        WHERE id_usuario = ?;");
                                        $Actualizacion->bind_Param("sssisi", $hash_password, $vacio, $fecha_hoy, $estado_del_usuario, $nueva_fecha_vencimiento, $id_usuario);
                                        $Actualizacion->execute();

                                        if($Actualizacion->error) {
                                            echo "<div class='alert alert-danger' role='alert'>
                                                No se pudo registrar su contraseña
                                                </div>";
                                        } else {
                                            echo "<div class='alert alert-success' role='alert'>
                                                Nueva contraseña creada correctamente
                                                </div>";

                                                //REGISTRO A BITACORA POR CAMBIO DE CONTRASENA
                                                require_once("../../modelo/conexionbd.php");
                                                date_default_timezone_set("America/Tegucigalpa");
                                                $fecha_actualizacion = date('Y-m-d H:i:s',time());
                                                $id_objeto = 1;
                                                $acciones = "Cambio de contraseña";
                                                $descripcion = "Cambio de contraseña, por motivos de olvido o bloqueo";

                                                $actualizarPassword = $conn->prepare("CALL control_bitacora (?,?,?,?,?)");
                                                $actualizarPassword->bind_Param("sssii", $acciones, $descripcion, $fecha_actualizacion,$id_usuario, $id_objeto);
                                                $actualizarPassword->execute();
                                                
                                        }//Cierre octavo IF

                                        
                                    }//Cierre septimo IF    
                                } else {
                                    echo "fallo la conexion";
                                }//Cierre sexto IF
                            }//Cierre quinto IF
                        }else {
                            echo "<div class='alert alert-danger' role='alert'>
                                    Las contraseñas no coinciden
                                    </div>";
                        }//Cierre cuarto IF
                    }//Cierre tercer IF
                }//Cierre segundo IF
            } else {
                echo "Algo salió mal";
            }//Cierre primer IF
        }
    }