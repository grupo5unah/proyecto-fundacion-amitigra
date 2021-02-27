<?php
    function usuario_autenticado(){
        if(!revisar_usuario() AND !revisar_rol() AND !revisar_ingreso() AND !revisar_idUsuario()){
            header('location:vista/modulos/login.php');
            exit();
        }
    }
    
    function revisar_usuario(){
        return isset($_SESSION['usuario']);
    }

    function revisar_rol(){
        return isset($_SESSION['rol']);
    }

    function revisar_ingreso(){
        return isset($_SESSION['primer_ingreso']);
    }

    function revisar_idUsuario(){
        return isset($_SESSION['id']);
    }

    session_start();
    usuario_autenticado();