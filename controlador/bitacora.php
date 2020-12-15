<?php

class Bitacora{

    public function ctrBitacoraInicio(){

        session_start();
        $id_usuario_bitacora = $_SESSION['usuario'];

        date_default_timezone_set("America/Tegucigalpa");
                                    $fecha = date("Y-m-d H:i:s", time());
                                    
    }


    public function ctrBitacoraCerrar(){
        $id_usuario_bitacora = 7;

        date_default_timezone_set("America/Tegucigalpa");
                                    $fecha = date("Y-m-d H:i:s", time());
                                    $objeto = 1;
                                    $acciones = "Cerrar sesion";
                                    $descp = "se cerro sesion";
                                    require_once("../../modelo/conexion2.php");
                                    $llamar = $conn->prepare("CALL CONTROL_BITACORA (?, ?, ?, ?, ?);");
                                    $llamar->bind_Param("sssss", $fecha, $id_usuario_bitacora, $objeto, $acciones, $descp);
                                    $llamar->execute();
                                    $llamar->close();
    }
}