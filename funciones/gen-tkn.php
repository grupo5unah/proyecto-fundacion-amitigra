<?php
 function getToken($len) {

    $rand_str = md5(uniqid(mt_rand(), true)); //Crea el hash
    $base64_encode = base64_encode($rand_str); //Protege o codifica el hash
    $modified_base64_encode = str_replace(array('+', '='), array('', ''), $base64_encode);
    $tkn = substr($modified_base64_encode, 0, $len);
    return $tkn;

}