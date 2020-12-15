<?php

class Redireccion{

    public function ctrRedireccion(){


        if(isset($_POST["submit"])){

            if(isset($_POST['correo'])){
            //Se incluye el CONTROLADOR
            
            } else{
            
                header('location:/recupregunta.php');

            }

        } 
    }
}