<?php

include_once("modelo.conexion.php");

    class ModeloFormularios{

        static public function mdlLogin($tabla, $datos){

            $conn = ModeloConexion::ctrConectar();

            $stmt = $conn->prepare("SELECT id, usuario, correo, contra FROM $tabla WHERE $datos = ?; ");
            $stmt->bind_Param("s", $datos);
            $stmt->execute();
            $stmt->bind_result($id, $nombre_usuario, $correo_admin, $password_usuario);
            
            $stmt->fetch();
            
            $stmt->close();

            $stmt = null;

        }
        //Cambio de contasena
        public function mdlCambioContrasena($tabla, $datos){
            //Esta parte la solicita al modelo

            $stmt = ModeloConexion::ctrConectar()->prepare("SELECT id FROM $tabla WHERE correo = :correo AND token = :validacion;");
            $stmt->bindParam(":correo", $datos['$correo'], PDO::PARAM_STR);
            $stmt->bindParam(":validacion",$datos['$validacion'], PDO::PARAM_STR);
            $stmt->execute();
            $id_usuario = $stmt->bindResult($id);

            if($stmt->affected_rows){
                $existe = $stmt->fetch();
                if(!$existe){
                    $pattern_up = "/^.*(?=.{4,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
                    if(!preg_match($pattern_up, $password)) {
                        echo "Debe tener al menos 8 caracteres de largo, 1 mayúscula, 1 letra minúscula, 1 caracter espececial y 1 número.";
                    } else {

                        $hash_password = password_hash($password, PASSWORD_BCRYPT, ['cost'=>12]);
                        $vacio = "";
                        
                        $stmt1 = $conn->prepare("UPDATE $tabla SET contra = :hash_password, token = :vacio WHERE id = :id_usuario;");
                        $stmt1->bindParam(":hash_password", $datos['$hash_password'], PDO::PARAM_STR);
                        $stmt1->bind_Param(":vacio", $datos['$vacio'], PDO::PARAM_STR);
                        $stmt1->bind_Param("id_usuario", $id_usuario, PDO::PARAM_INT");
                        $stmt1->execute();

                        if($stmt1->error) {
                            die("Fallo la conexion a la base de datos");
                        } else {
                           
                            echo "Nueva contraseña creada correctamente";
                            echo "<br>";
                            echo $expire_date;                   
                        }//Cierre octavo IF
                    }//Cierre septimo IF    
                } else {
                    echo "fallo la conexion";
                }//Cierre sexto IF
            }//Cierre quinto IF
        }

        
    } 
    
}

    

}