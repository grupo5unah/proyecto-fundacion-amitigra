<?php
    //Se incluye la conexion a la base de datos
    include("../modelo/conexionbd.php");

    $contrasena = $_POST['contrasena'];
    $usuario = $_POST['usuario'];

    if(!empty($contrasena)){

        $stmt = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
        $stmt->bind_Param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($password_usuario);
        if($stmt->affected_rows){
            $existe = $stmt->fetch();
            
            if ($existe){

                if ($contrasena !=""){
                    
                    if(password_verify($contrasena, $password_usuario)){

                        //Verifica si el archivo es legible
                        if (is_readable('../modelo/conexionbd.php')) {
                            echo 'El fichero es legible';
                        } else {
                            echo 'El fichero no es legible';
                        } 

                        echo '<br>';

                        //Verifica si es un directorio
                        var_dump(is_dir('fotoPerfil'));

                        echo '<br>';

                        //Verifica si el fichero existe
                        if (file_exists('modelo/conexionbd.php')) {
                            echo "El fichero existe";
                        } else {
                            echo "El fichero no existe";
                        }

                        echo '<br>';

                        //Verifica si es un ejecutable
                        if(is_executable('modelo/conexionbd.php')){
                            echo 'Es un ejecutable';
                        } else {
                            echo 'No es un ejecutable';
                        }


                        //Nombre como se guardara la copia de seguridad
                        $db_name = "fundacion_amitigra";

                        include("./modelo/conexionbd.php");
                        
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
                            readfile($backup_file_name);
                            exit;
                            //exec('rm ' . $backup_file_name);
                        }

                        $respuesta = array(
                            "respuesta" => "exito"
                        );

                        //echo "Se realizo correctamente la copia de seguridad";
                        
                    } else {

                        //CONTRASENA INOCRRECTA
                        $respuesta = array(
                            "respuesta" => "incorrecta"
                        );

                    }
                    
                }else{

                    $respuesta = array(
                        "respuesta" => "no_contrasena"
                    );
                    
                }
            } else{
                echo "surgio un error";
            }
        }else{
            echo "error";
        }

        echo json_encode($respuesta);
    }