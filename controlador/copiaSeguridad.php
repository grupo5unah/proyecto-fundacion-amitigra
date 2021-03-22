<?php

    class CopiaSeguridad{

        public function ctrCopiaSeguridad(){

            //Se incluye la conexion a la base de datos
            include("../modelo/conexionbd.php");

            if(isset($_POST['password']) == 'password'){
                $password = $_POST['password'];

                $usuario = 'ADMIN';//strtoupper($_SESSION['usuario']);

                $stmt = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?; ");
                $stmt->bind_Param("s", $usuario);
                $stmt->execute();
                $stmt->bind_result($password_usuario);
                if($stmt->affected_rows){
                    $existe = $stmt->fetch();
                    if ($existe){

                        if ($password !="" || strlen($password)){
                            if(password_verify($password, $password_usuario)){

                                
                                $mysqlDatabaseName ='bd_fundacion_amitigra';
$mysqlUserName ='root';
$mysqlPassword ='';
$mysqlHostName ='localhost';
$mysqlExportPath ='copiabd.sql';

//Por favor, no haga ningún cambio en los siguientes puntos
//Exportación de la base de datos y salida del status
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' --password="' .$mysqlPassword .'" ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
exec($command,$output=array(),$worked);
switch($worked){
case 0:
echo 'La base de datos <b>' .$mysqlDatabaseName .'</b> se ha almacenado correctamente en la siguiente ruta '.getcwd().'/' .$mysqlExportPath .'</b>';
break;
case 1:
echo 'Se ha producido un error al exportar <b>' .$mysqlDatabaseName .'</b> a '.getcwd().'/' .$mysqlExportPath .'</b>';
break;
case 2:
echo 'Se ha producido un error de exportación, compruebe la siguiente información: <br/><br/><table><tr><td>Nombre de la base de datos:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>Nombre de usuario MySQL:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>Contraseña MySQL:</td><td><b>NOTSHOWN</b></td></tr><tr><td>Nombre de host MySQL:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
break;
}
                                

                                //echo "Se realizo correctamente la copia de seguridad";
                                echo "<div class='text-center alert alert-success' role='alert'>
                                Se realizó correctamente la copia de seguridad.
                                </div>;
                                <script>
                                window.setTimeout(function(){
                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                function(){
                                $(this).remove();
                                });
                                }, 3000);
                                </script>";

                                echo "<script>
                                            if (window.history.replaceState) { // verificamos disponibilidad
                                                window.history.replaceState(null, null, window.location.href);
                                            }
                                            location.reload();
                                            </script>";
                            } else {
                                
                                echo "<div class='text-center alert alert-danger' role='alert'>
                                La contraseña es incorrecta.
                                </div>
                                <script>
                                window.setTimeout(function(){
                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                function(){
                                $(this).remove();
                                });
                                }, 3000);
                                </script>";

                                echo "<script>
                                            if (window.history.replaceState) { // verificamos disponibilidad
                                                window.history.replaceState(null, null, window.location.href);
                                            }
                                            location.reload();
                                            </script>";;
                            }
                        }else{

                            echo "<div class='text-center alert alert-warning' role='alert'>
                            No se ha ingresado ninguna contraseña.
                                </div>
                                <script>
                                window.setTimeout(function(){
                                $('.alert').fadeTo(1500,00).slideDown(1000,
                                function(){
                                $(this).remove();
                                });
                                }, 3000);
                                </script>";

                                echo "<script>
                                            if (window.history.replaceState) { // verificamos disponibilidad
                                                window.history.replaceState(null, null, window.location.href);
                                            }
                                            </script>";;
                        }
                    } else{
                        echo "surgio un error";
                    }
                }else{
                    echo "error";
                }
            }
        }
    }
