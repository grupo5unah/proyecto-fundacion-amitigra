<?php
class AccionesBitacora{

    public function ctrPassPregunta(){
        
        if (isset($_POST['tipo_pregunta']) == 'recuperarPregunta'){
            $correo = $_POST['email'];

            global $conn;
            include_once("../../modelo/conexionbd.php");
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
                    $PassCorreo = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $PassCorreo->bind_Param("sssii",$acciones, $descp,$fecha,$id, $objeto);
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

            include_once '../../modelo/conexionbd.php';
            global $conn;
            $verificarUsuario = $conn->prepare("SELECT id_usuario
                                                FROM tbl_usuarios
                                                WHERE correo = ?;");
            $verificarUsuario->bind_Param("s", $correo);
            $verificarUsuario->execute();
            $verificarUsuario->bind_Result($id_usuario);

            if($verificarUsuario->affected_rows){
                $existe = $verificarUsuario->fetch();

                while($verificarUsuario->fetch()){
                    $id_us = $id_usuario;
                }

                if($existe){

                    echo $id_us;
                    exit;
                    date_default_timezone_set("America/Tegucigalpa");
                    $fecha = date('Y-m-d H:i:s',time());
                    $accion = "Pass x correo";
                    $desc = "Recuperar contrasena por correo";
                    $object = 1;
                    //$id_usuario1 = 55;

                    include_once '../../modelo/conexionbd.php';
                    $PassCorreo = $conn->prepare("CALL control_bitacora (?, ?, ?, ?, ?);");
                    $PassCorreo->bind_Param("sssii", $accion, $desc, $fecha, $id_us, $object);
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