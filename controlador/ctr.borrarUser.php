<?php

class borrar{

    public function ctrBorrar(){

        if(isset($_POST['eliminarUsuario'])){
            $id =$_POST['eliminarUsuario'];
            
            try{
                require_once("../../modelo/conexion.php");
                $stmt = $conn->prepare("DELETE FROM tbl_usuarios WHERE id_usuario=?");
                $stmt->bind_Param("i",$id);
                $stmt->execute();
                
                if ($stmt->error){
                    echo "no se ha eliminado el usuario";
                }
                /*$_SESSION['message'] ='Usuario eliminado exitosamente';
                $_SESSION['message_type']= 'danger';
                header("location: mantenimiento.php");*/
                echo "se borro con exito";
            } catch (Exception $e){
                die("Hubo un error". $e->getMessage());
            }
        }
    }
}