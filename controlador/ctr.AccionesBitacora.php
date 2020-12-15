<?php
class AccionesBitacora{

    public function ctrPassPregunta(){
        
        if (isset($_POST['tipo_pregunta']) == 'recuperarPregunta'){
            $correo = $_POST['email'];

            include_once("../../modelo/conexion.php");
            $verificarUsuario = $conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE correo = ?;");
            $verificarUsuario->bind_Param("s",$correo);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($id_usuario);

            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                while($verificarUsuario->fetch()){
                    $id =$id_usuario;
                }

                if($existe){

                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d H:i:s',time());
                    $acciones = "Pass x preg";
                    $descp = "Recuperar contrasena por pregunta";
                    $objeto = 1;
                    //$id_usuario1 = 55;

                    include_once("../../modelo/conexion.php");
                    $PassCorreo = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                    $PassCorreo->bind_Param("sssss",$fecha, $id_usuario, $objeto, $acciones, $descp);
                    $PassCorreo->execute();

                    if($PassCorreo->error){
                        echo "ERROR AL REGISTRAR";
                    }else{
                        echo "BIEN HECHO POR PREGUNTA";

                    }
                }else{

                }
            }
        }
    }

    public function ctrPassCorreo(){
        if (isset($_POST['tipo_correo']) == 'recuperarCorreo'){
            $correo = $_POST['email'];

            include_once("../../modelo/conexion2.php");
            $verificarUsuario = $conn->prepare("SELECT id_usuario FROM tbl_usuarios WHERE correo = ?;");
            $verificarUsuario->bind_Param("s",$correo);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($id_usuario);

            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                while($verificarUsuario->fetch()){
                    $id =$id_usuario;
                }

                if($existe){

                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d H:i:s',time());
                    $acciones = "Pass x correo";
                    $descp = "Recuperar contrasena por correo";
                    $objeto = 1;
                    //$id_usuario1 = 55;

                    include_once("../../modelo/conexion.php");
                    $PassCorreo = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                    $PassCorreo->bind_Param("sssss",$fecha, $id_usuario, $objeto, $acciones, $descp);
                    $PassCorreo->execute();

                    if($PassCorreo->error){
                        echo "ERROR AL REGISTRAR";
                    }else{
                        echo "BIEN HECHO POR CORREO";

                    }
                }else{

                }
            }
        }
    }
}