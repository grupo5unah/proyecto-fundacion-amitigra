<?php

    class CopiaSeguridad{

        public function ctrCopiaSeguridad(){

            //Se incluye la conexion a la base de datos
            include("./modelo/conexion.php");

            if(isset($_POST['password'])){
                $password = $_POST['password'];

                $usuario = strtoupper($_SESSION['usuario']);

                $stmt = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?; ");
                $stmt->bind_Param("s", $usuario);
                $stmt->execute();
                $stmt->bind_result($password_usuario);
                if($stmt->affected_rows){
                    $existe = $stmt->fetch();
                    if ($existe){

                        if ($password !="" || strlen($password)){
                            if(password_verify($password, $password_usuario)){

                                //Nombre como se guardara la copia de seguridad
                                $db_name = "fundacion_amitigra";

                                include("./modelo/conexion.php");
                                
                                $tables=array();
                                $sql="SHOW TABLES";
                                $result=mysqli_query($conn,$sql);

                                while($row=mysqli_fetch_row($result)){
                                    $tables[]=$row[0];
                                }

                                $backupSQL="";
                                foreach($tables as $table){
                                    $query="SHOW CREATE TABLE $table";
                                    $result=mysqli_query($conn,$query);
                                    $row=mysqli_fetch_row($result);
                                    $backupSQL.="\n\n".$row[1].";\n\n";

                                    $query="SELECT * FROM $table";
                                    $result=mysqli_query($conn,$query);

                                    $columnCount=mysqli_num_fields($result);

                                    for($i=0;$i<$columnCount;$i++){
                                        while($row=mysqli_fetch_row($result)){
                                            $backupSQL.="INSERT INTO $table VALUES(";
                                            for($j=0;$j<$columnCount;$j++){
                                                $row[$j]=$row[$j];

                                                if(isset($row[$j])){
                                                    $backupSQL.='"'.$row[$j].'"';
                                                }else{
                                                    $backupSQL.='""';
                                                }
                                                if($j<($columnCount-1)){
                                                    $backupSQL.=',';
                                                }
                                            }
                                            $backupSQL.=");\n";
                                        }
                                    }
                                    $backupSQL.="\n";
                                }

                                if(!empty($backupSQL)){
                                    date_default_timezone_set("America/Tegucigalpa");
                                
                                    $backup_file_name=$db_name.'_backup_'.date("Y-m-d-H-i-s").'.sql';
                                    $fileHandler=fopen($backup_file_name,'w+');
                                    $number_of_lines=fwrite($fileHandler,$backupSQL);
                                    fclose($fileHandler);

                                    header('Content-Description: File Transfer');
                                    header('Content-Type: application/octet-stream');
                                    header('Content-Disposition: attachment; filename='.basename($backup_file_name));
                                    header('Content-Transfer-Encoding: binary');
                                    header('Expires: 0');
                                    header('Cache-Control: must-revalidate');
                                    header('Pragma: public');
                                    header('Content-Length: '.filesize($backup_file_name));
                                    ob_clean();
                                    flush();
                                }

                                //echo "Se realizo correctamente la copia de seguridad";
                                echo "<div class='text-center alert alert-success' role='alert'>
                                Se realizó correctamente la copia de seguridad.
                                </div>";
                            } else {
                                
                                echo "<div class='text-center alert alert-danger' role='alert'>
                                La contraseña es incorrecta.
                                </div>";
                            }
                        }else{

                            echo "<div class='text-center alert alert-warning' role='alert'>
                            No se ha ingresado ninguna contraseña.
                                </div>";
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
