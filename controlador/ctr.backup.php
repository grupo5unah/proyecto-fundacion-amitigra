<?php
    //Se incluye la conexion a la base de datos
    include("../modelo/conexionbd.php");

    $contrasena = $_POST['contrasena'];
    $usuario = $_POST['usuario'];

    if(!empty($contrasena) || !empty($usuario)){

        $stmt = $conn->prepare("SELECT contrasena FROM tbl_usuarios WHERE nombre_usuario = ?;");
        $stmt->bind_Param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($password_usuario);
        if($stmt->affected_rows){
            $existe = $stmt->fetch();
            
            if ($existe){

                if ($contrasena !=""){
                    
                    if(password_verify($contrasena, $password_usuario)){

                        //Nombre como se guardara la copia de seguridad
                        $nombre_base_datos = "fundacion_amitigra";

                        include("../modelo/conexionbd.php");
                        
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

                            $ruta = "../copiaSeguridad/";

                            if(is_dir($ruta)){
                                mkdir($ruta,777,true);
                            }

                            $nombre_copia=$nombre_base_datos.'_CSBD_fecha_'.date("Y-m-d").'_hora_'.date("H_i_s").'.sql';
                            $fileHandler=fopen($ruta.$nombre_copia,'w+');
                            $number_of_lines=fwrite($fileHandler,$backupSQL);
                            fclose($fileHandler);

                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename='.basename($nombre_copia));
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: '.filesize($nombre_copia));
                            ob_clean();
                            //flush();
                            //readfile($nombre_copia);
                            //readfile($backup_file_name);
	                        //exec('rm ' . $nombre_copia);                         
                            
                        }

                        $respuesta = array(
                            "respuesta" => "exito"
                        );

                        // require_once("../modelo/conexionbd.php");

                        // $bitacora = $conn->prepare("SELECT id_usuario FROM tbl_usuarios
                        //                             WHERE nombre_usuario = ?");
                        // $bitacora->bind_Param("s", $usuario);
                        // $bitacora->execute();
                        // $bitacora->bind_Result($id_usuario);

                        // if($bitacora->affected_rows){
                        //     $existe_bitacora = $bitacora->fetch();

                        //     while($existe_bitacora->fetch()){
                        //         $id = $id_usuario; 
                        //     }

                        //     if($existe_bitacora){

                        //         date_default_timezone_set("America/Tegucigalpa");
                        //         $fecha_bloqueo = date('Y-m-d H:i:s',time());
                        //         $objeto =15;
                        //         $acciones = "Copia base de datos.";
                        //         $descp = "Se generó una copia de seguridad de la base de datos.";

                        //         require_once("../modelo/conexionbd.php");
                        //         $IntentosBitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?);");
                        //         $IntentosBitacora->bind_Param("sssii", $acciones, $descp, $fecha_bloqueo, $id, $objeto);
                        //         $IntentosBitacora->execute();

                        //         if($IntentosBitacora->error){

                        //         } else {

                        //         }

                        //     } else {

                        //     }
                        // }else{

                        // }

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