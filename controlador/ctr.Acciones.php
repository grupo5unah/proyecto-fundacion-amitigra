<?php

class AccionesUsuario{

    public function ctrPerfilBitacora(){
        $usuario = $_SESSION['usuario'];
        
        //REGISTRO CLICK PARA VER EL PERFIL
        if(isset($_POST['cambio']) == 'act'){

            include_once("./modelo/conexionbd.php");
            $verificarUsuario = $conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE nombre_usuario = ?");
            $verificarUsuario->bind_Param("s",$usuario);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($id);

            while ($verificarUsuario->fetch()) {
                $id_usuario = $id;
                echo $id;
            }
            
            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                if(!$existe){
                    include_once("./modelo/conexionbd.php");

                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d H:i:s',time());
                    $objeto = 1;
                    $acciones = "Actualizacion de informacion personal";
                    $descripcion = "Cambios de su informacion en el perfil de usuario";

                    $perfilBitacora = $conn->prepare("CALL control_bitacora (?,?,?,?,?)");
                    $perfilBitacora->bind_Param("siiss",$fecha, $id_usuario, $objeto,$acciones,$descripcion);
                    $perfilBitacora->execute();
                }
            }
        }
    }
}