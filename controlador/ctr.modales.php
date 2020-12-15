<?php
class modales{

    public function ctrModales(){

        if(isset($_POST[''])===''){
            $usuario = $_POST['usuario'];
            $rol = $_POST['rol'];
            $descripcion = $_POST['descripcion'];

            date_default_timezone_set("America/Tegucigalpa");
            $fecha = date('Y-m-d H:i:s',time());

            try {

                $consulta = $conn->prepare("SELECT id_rol FROM tbl_roles WHERE rol=?");
                $consulta->bind_Param("s",$rol);
                $consulta->execute();
                $consulta->bind_Result($id_rol);

                if($consulta->affected_rows){

                    $existe = $consulta->fetch();

                    while($consulta->fetch()){
                        $rol_id = $id_rol;

                    }

                    if($existe){
                        echo "No se pueden repetir los roles";
                    }else{
                        $stmt = $conn->prepare("INSERT INTO tbl_roles (rol, descripcion, creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                VALUES(?,?,?,?,?,?);");
                        $stmt->bind_Param("ssssss",$rol, $descripcion,$usuario, $fecha, $usuario, $fecha);
                        $stmt->execute();

                        if($stmt->error){
                            echo "Se produjo un error al momento de registrar el rol";

                        } else{
                            echo "Se registro con exito el rol";

                        }
                    }

                }
            } catch (Exception $e) {
                die("hubo un error".$e->getMessage);
            }

        }
    }
}