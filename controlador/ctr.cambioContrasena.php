<?php
class CambioContrasena{
    
    public function ctrCambioContrasena(){

        if(isset($_POST['tipo']) == 'cambio_contrasena'){
            $contrasenaActual = $_POST['ConActual'];
            $contrasenaNueva = $_POST['ConNueva'];
            $contrasenaConfirmar = $_POST['ConfPass'];
            $usuario = $_SESSION['usuario'];

            //Verificar si el usuario existe
            include_once("../../modelo/conexionbd.php");
            $verificarUsuario = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?");
            $verificarUsuario->bind_Param("s",$usuario);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($Contrasena);
            
            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                if($existe){

                    if($contrasenaActual == $Contrasena){

                        if($NuevaContrasena == $contrasenaConfirmar){
                            //Generar la contrasena HASHADA
                            $hashed_password = password_hash($contrasenaNueva,PASSWORD_BCRYPT);

                            $NuevaContrasena = $conn->prepare("UPDATE tbl_usuarios
                                                                SET contrasena = ?
                                                                WHERE nombre_usuario = ?");
                            $NuevaContrasena->bind_Param("s",$usuario);
                            $NuevaContrasena->execute();

                            if($NuevaContrasena->error){
                                echo "<div class='alert alert-danger' role='alert'>
                                        No se pudo actualizar su contraseña.
                                        </div>";

                            }else {
                                echo "<div class='alert alert-success' role='alert'>
                                        Contraseña actualizada correctamente.
                                        </div>";
                            }
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                                    Lo sentimos, las contraseña no coinciden.
                                    </div>";

                        }
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                                La contrasena no coincide con la establecida en nuestro registro
                                </div>";
                    }
                }
            }
        }
    }
}