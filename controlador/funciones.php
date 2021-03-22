<?php
class Funciones{

    public function ctrFunciones(){
        
        //EL USUARIO HA SISO BLOQUEADO

        require "../../modelo/conexionbd.php";

        $estado_bloqueo = 3;
        $reiniciar_intentos = 0;

        $bloqueo_intento = $conn->prepare("UPDATE tbl_usuarios 
                                            SET intentos = ?, estado_id = ? WHERE nombre_usuario = ?;");
        $bloqueo_intento->bind_Param("iis", $reiniciar_intentos, $estado_bloqueo, $usuario);
        $bloqueo_intento->execute();
    }
}