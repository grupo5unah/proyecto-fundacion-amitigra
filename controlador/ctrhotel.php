<?php
include "../modelo/conexionbd.php";

//BUSCAR CLIENTE

 if(isset($_POST['accion']) == 'buscarCliente'){
    if(!empty($_POST['identidad'])){
        $identidad = strval($_POST['identidad']);
        //echo $identidad;

        $resultado = 0;
        $sql=mysqli_query($conn,"SELECT id_cliente,nombre_completo,identidad,telefono,tipo_nacionalidad
        FROM tbl_clientes WHERE identidad = '$identidad'  AND estado_eliminado=1");
        mysqli_close($conn);
        $resultado = mysqli_num_rows($sql);
            $data = '';
        if ($resultado) {
            $data= mysqli_fetch_assoc($sql);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        } 
        
    }
    exit;
    
 }
$res = array('error' => false);
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){ 
    case 'registrarCliente':
        $identidad= $_POST['identidad'];
        $nombre=$_POST['cliente'];
        $nacionalidad=$_POST['nacionalidad'];                 
        $telefono=$_POST['telefono'];
        $estado=1;
        $usuario_actual = $_POST['usuario_actual'];
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());

        if(empty($_POST['identidad'])|| empty($_POST['cliente'])||
            empty($_POST['nacionalidad'])|| empty($_POST['telefono'])|| empty($_POST['usuario_actual'])){
            
            $res['msj'] = 'Es necesario rellenar todos los campos';
            $res['error'] = true;

        }else{
            try{
                $insertar=$conn->prepare("INSERT INTO tbl_clientes (nombre_completo, identidad, telefono, tipo_nacionalidad, 
                                estado_eliminado,creado_por,fecha_creacion, modificado_por, fecha_modificacion)
                                VALUES (?,?,?,?,?,?,?,?,?);");
                $insertar->bind_param('sssiissss', $nombre,$identidad,$telefono,$nacionalidad,$estado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $insertar->execute();

                if ($insertar->error) {
                    $res['msj'] = "Se produjo un error al momento de registrar el Cliente";
                    $res['error'] = true;
                } else {
                    $res['msj'] = "Cliente Registrado Correctamente";
                }
            }catch(exception $e){
                echo $e->getMessage();
            }
        }
            
        
    break;
    case 'hotelJutiapaNE': //realizar una reservacion para hotel jutiapa ambas nacionalidades
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];//fecha de entrada
        $salida = $_POST['salida'];//fecha salida
        $habitacion = $_POST['habitacion'];
        $precioAN = $_POST['precioAdultoN'];
        $precioNN = $_POST['precioNinoN'];
        $precioAE = $_POST['precioAdultoE'];
        $precioNE = $_POST['precioNinoE'];
        $adultoE = $_POST['adultoE'];
        $ninoE = $_POST['ninoE'];
        $adultoN = $_POST['adultoN'];
        $ninoN = $_POST['ninoN'];
        $cant_habitacion = $_POST['cant_habitacion'];
        $total = $_POST['total2'];
        $usuario_actual = $_POST['usuario_actual'];
        $id_usuario = $_POST['id_usuario'];
        $estado_eliminado =1;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
    

        if(empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['salida']) || 
            empty($_POST['habitacion']) ||empty($_POST['precioAdultoN']) ||empty($_POST['precioNinoN'])
            ||empty($_POST['precioAdultoE']) ||empty($_POST['precioNinoE'])|| empty($_POST['adultoN']) ||
            empty($_POST['ninoN']) || empty($_POST['ninoE']) || empty($_POST['adultoE'])
            || empty($_POST['cant_habitacion']) || empty($_POST['total2'])
            || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                $id_cliente=1;
                $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                VALUES (?,?,?,?,?,?,?,?,?,?);");
                $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $inserta->execute();

                //se captura el id de la tabla de reservaciones
                $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                WHERE fecha_reservacion= ?;");
                $capturar_reserva->bind_Param("s", $reservacion);
                $capturar_reserva->execute();
                $capturar_reserva->bind_result($idr);

                if($capturar_reserva->affected_rows){
                    $existe_reservacion = $capturar_reserva->fetch();

                    while ($capturar_reserva->fetch()) {
                        $id_reserva = $idr;
                    }
                    if($existe_reservacion){
                        $canti_adultos = $adultoN + $adultoE;
                        $canti_ninos = $ninoN + $ninoE;
                        //inserta en la tabla detalle de reservacion
                        $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                        total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                        VALUES (?,?,?,?,?,?,?,?,?,?);");
                        $insert->bind_param('iiiiiissss', $idr,$habitacion,$canti_adultos, $canti_ninos,$total,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();

                        //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                        $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                        WHERE habitacion_id = ?;");
                        $captura_ha->bind_Param("s", $habitacion);
                        $captura_ha->execute();
                        $captura_ha->bind_result($idH);

                        if($captura_ha->affected_rows){
                            $existe_ha = $captura_ha->fetch();

                            while ($captura_ha->fetch()) {
                                $id_hab = $idH;
                            }
                            if($existe_ha){
                                $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                WHERE id_habitacion_servicio = '$idH'";

                                $result=$conn->query($actulizar_estado);
                                if ($result == 1) {
                                    $res['msj'] = "Reservación se realizo Correctamente";
                                } else {
                                    $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                    $res['error'] = true;
                                }
                            }

                        }
                        
                        
                    }
                }                          
            }catch(Exception $e){
            echo $e->getMessage();
            }
        }
       
    break;
    case 'hotelJutiapaNoE': //realizar una reservacion para hotel jutiapa para una sola nacionalidad
        $reservacion = $_POST['reservacion']; //fecha de reservacion
        $entrada = $_POST['entrada'];//fecha de entrada
        $salida = $_POST['salida'];//fecha salida
        $habitacion = $_POST['habitacion'];
        $precioAN = $_POST['precioAdultoN'];
        $precioNN = $_POST['precioNinoN'];
        $precioAE = $_POST['precioAdultoE'];
        $precioNE = $_POST['precioNinoE'];
        $adultoE = $_POST['adultoE'];
        $ninoE = $_POST['ninoE'];
        $adultoN = $_POST['adultoN'];
        $ninoN = $_POST['ninoN'];
        $cant_habitacion = $_POST['cant_habitacion'];
        $total1 = $_POST['total1'];
        $total2 = $_POST['total2'];
        $usuario_actual = $_POST['usuario_actual'];
        $id_usuario = $_POST['id_usuario'];
        $estado_eliminado =1;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
    
        try{
            if(empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['salida']) || 
                empty($_POST['habitacion']) ||empty($_POST['precioAdultoN']) ||empty($_POST['precioNinoN'])||
                ($adultoN == "" && $ninoN == "") || ($adultoN =="0" && $ninoN == "0")
                || empty($_POST['cant_habitacion']) || empty($_POST['total1'])
                || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                    $res['msj'] = 'Todos los campos son obligatorios';
                    $res['error'] = true;
            }else{
                
                if($adultoN > 0){
                    $id_cliente=1;
                    $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                    estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?);");
                    $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $inserta->execute();

                    //se captura el id de la tabla de reservaciones
                    $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                    WHERE fecha_reservacion= ?;");
                    $capturar_reserva->bind_Param("s", $reservacion);
                    $capturar_reserva->execute();
                    $capturar_reserva->bind_result($idr);

                    if($capturar_reserva->affected_rows){
                        $existe_reservacion = $capturar_reserva->fetch();

                        while ($capturar_reserva->fetch()) {
                            $id_reserva = $idr;
                        }
                        if($existe_reservacion){
                            
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiissss', $idr,$habitacion,$adultoN, $ninoN,$total1,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_ha->bind_Param("s", $habitacion);
                            $captura_ha->execute();
                            $captura_ha->bind_result($idH);

                            if($captura_ha->affected_rows){
                                $existe_ha = $captura_ha->fetch();

                                while ($captura_ha->fetch()) {
                                    $id_hab = $idH;
                                }
                                if($existe_ha){
                                    $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                    WHERE id_habitacion_servicio = '$idH'";

                                    $result=$conn->query($actulizar_estado);
                                    if ($result == 1) {
                                        $res['msj'] = "Reservación se realizo Correctamente";
                                    } else {
                                        $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                        $res['error'] = true;
                                    }
                                }

                            }
                            
                            
                        }
                    }  
                }
            }
            if(empty($_POST['reservacion']) || empty($_POST['entrada']) || empty($_POST['salida']) || 
                empty($_POST['habitacion']) ||empty($_POST['precioAdultoE'])  ||empty($_POST['precioNinoE'])|| 
                ($adultoE == "" && $ninoE == "") || ($adultoE =="0" &&  $ninoE == "0") 
                || empty($_POST['cant_habitacion']) || empty($_POST['total2'])
                || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){

            }else{
                if($adultoE > 0){
                    $id_cliente=1;
                    $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                    estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?);");
                    $inserta->bind_param('sssiiissss', $reservacion, $entrada,$salida,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $inserta->execute();

                    //se captura el id de la tabla de reservaciones
                    $capturar_reserva = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                    WHERE fecha_reservacion= ?;");
                    $capturar_reserva->bind_Param("s", $reservacion);
                    $capturar_reserva->execute();
                    $capturar_reserva->bind_result($idr);

                    if($capturar_reserva->affected_rows){
                        $existe_reservacion = $capturar_reserva->fetch();

                        while ($capturar_reserva->fetch()) {
                            $id_reserva = $idr;
                        }
                        if($existe_reservacion){
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiissss', $idr,$habitacion,$adultoE, $ninoE,$total2,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_ha = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_ha->bind_Param("s", $habitacion);
                            $captura_ha->execute();
                            $captura_ha->bind_result($idH);

                            if($captura_ha->affected_rows){
                                $existe_ha = $captura_ha->fetch();

                                while ($captura_ha->fetch()) {
                                    $id_hab = $idH;
                                }
                                if($existe_ha){
                                    $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                    WHERE id_habitacion_servicio = '$idH'";

                                    $result=$conn->query($actulizar_estado);
                                    if ($result == 1) {
                                        $res['msj'] = "Reservación se realizo Correctamente";
                                    } else {
                                        $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                        $res['error'] = true;
                                    }
                                }

                            }
                            
                            
                        }
                    }  
                }
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
       
    break;
    case 'hotelRosarioNE': //realizar una reservacion para hotel Rosario ambas nacionalidades
        $reserva = $_POST['reserva']; //fecha de reservacion
        $entra = $_POST['entra'];//fecha de entrada
        $sali = $_POST['sali'];//fecha salida
        $habita = $_POST['habita'];
        $precAN = $_POST['preAdultoN'];
        $precNN = $_POST['preNinoN'];
        $precAE = $_POST['preAdultoE'];
        $precNE = $_POST['preNinoE'];
        $adultE = $_POST['adultE'];
        $ninE = $_POST['ninE'];
        $adultN = $_POST['adultN'];
        $ninN = $_POST['ninN'];
        $canti_habitacion = $_POST['cantiHa'];
        $tot = $_POST['total4'];
        $usuario_actual = $_POST['usuario_actual'];
        $id_usuario = $_POST['id_usuario'];
        $estado_eliminado =1;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
    

        if(empty($_POST['reserva']) || empty($_POST['entra']) || empty($_POST['sali']) || 
            empty($_POST['habita']) ||empty($_POST['preAdultoN']) ||empty($_POST['preNinoN'])
            ||empty($_POST['preAdultoE']) ||empty($_POST['preNinoE'])|| empty($_POST['adultN']) ||
            empty($_POST['ninN']) || empty($_POST['ninE']) || empty($_POST['adultE'])
            || empty($_POST['cantiHa']) || empty($_POST['total4'])
            || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                $res['msj'] = 'Todos los campos son obligatorios';
                $res['error'] = true;
        }else{
            try{
                $id_cliente=1;
                $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                VALUES (?,?,?,?,?,?,?,?,?,?);");
                $inserta->bind_param('sssiiissss', $reserva, $entra,$sali,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                $inserta->execute();

                //se captura el id de la tabla de reservaciones
                $capturar_reserv = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                WHERE fecha_reservacion= ?;");
                $capturar_reserv->bind_Param("s", $reserva);
                $capturar_reserv->execute();
                $capturar_reserv->bind_result($idre);

                if($capturar_reserv->affected_rows){
                    $existe_reserva = $capturar_reserv->fetch();

                    while ($capturar_reserv->fetch()) {
                        $id_reserv = $idre;
                    }
                    if($existe_reserva){
                        $cantid_adultos = $adultN + $adultE;
                        $cantid_ninos = $ninN + $ninE;
                        //inserta en la tabla detalle de reservacion
                        $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                        total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                        VALUES (?,?,?,?,?,?,?,?,?,?);");
                        $insert->bind_param('iiiiiissss', $idre,$habita,$cantid_adultos,$cantid_ninos,$tot,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                        $insert->execute();

                        //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                        $captura_hab = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                        WHERE habitacion_id = ?;");
                        $captura_hab->bind_Param("s", $habita);
                        $captura_hab->execute();
                        $captura_hab->bind_result($idHa);

                        if($captura_hab->affected_rows){
                            $existe_hab = $captura_hab->fetch();

                            while ($captura_hab->fetch()) {
                                $id_habi = $idHa;
                            }
                            if($existe_hab){
                                $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                WHERE id_habitacion_servicio = '$idHa'";

                                $result=$conn->query($actulizar_estado);
                                if ($result == 1) {
                                    $res['msj'] = "Reservación se realizo Correctamente";
                                } else {
                                    $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                    $res['error'] = true;
                                }
                            }

                        }
                        
                        
                    }
                }                          
            }catch(Exception $e){
            echo $e->getMessage();
            }
        }
       
    break;
    case 'hotelRosarioNoE': //realizar una reservacion para hotel Rosario para una sola nacionalidades
        $reserva = $_POST['reserva']; //fecha de reservacion
        $entra = $_POST['entra'];//fecha de entrada
        $sali = $_POST['sali'];//fecha salida
        $habita = $_POST['habita'];
        $precAN = $_POST['preAdultoN'];
        $precNN = $_POST['preNinoN'];
        $precAE = $_POST['preAdultoE'];
        $precNE = $_POST['preNinoE'];
        $adultE = $_POST['adultE'];
        $ninE = $_POST['ninE'];
        $adultN = $_POST['adultN'];
        $ninN = $_POST['ninN'];
        $canti_habitacion = $_POST['cantiHa'];
        $total3 = $_POST['total3'];
        $total4 = $_POST['total4'];
        $usuario_actual = $_POST['usuario_actual'];
        $id_usuario = $_POST['id_usuario'];
        $estado_eliminado =1;
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('Y-m-d H:i:s',time());
    
        try {
            //INSERTAR PARA NACIONALES
            if(empty($_POST['reserva']) || empty($_POST['entra']) || empty($_POST['sali']) || 
                empty($_POST['habita']) || ($adultN == "" && $ninN == "") || ($adultN == "0" && $ninN == "0")
                || empty($_POST['preAdultN']) || empty($_POST['preninoN'])|| empty($_POST['cantiHa']) || empty($_POST['total3'])
                || empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                    $res['msj'] = 'Todos los campos son obligatorios';
                    $res['error'] = true;
            }else{
                if($adultN > 0){
                    $id_cliente=1;
                    $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                    estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?);");
                    $inserta->bind_param('sssiiissss', $reserva, $entra,$sali,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $inserta->execute();

                    //se captura el id de la tabla de reservaciones
                    $capturar_reserv = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                    WHERE fecha_reservacion= ?;");
                    $capturar_reserv->bind_Param("s", $reserva);
                    $capturar_reserv->execute();
                    $capturar_reserv->bind_result($idre);

                    if($capturar_reserv->affected_rows){
                        $existe_reserva = $capturar_reserv->fetch();

                        while ($capturar_reserv->fetch()) {
                            $id_reserv = $idre;
                        }
                        if($existe_reserva){
                            $cantid_adultos = $adultN + $adultE;
                            $cantid_ninos = $ninN + $ninE;
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiissss', $idre,$habita,$adultN,$ninN,$total3,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_hab = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_hab->bind_Param("s", $habita);
                            $captura_hab->execute();
                            $captura_hab->bind_result($idHa);

                            if($captura_hab->affected_rows){
                                $existe_hab = $captura_hab->fetch();

                                while ($captura_hab->fetch()) {
                                    $id_habi = $idHa;
                                }
                                if($existe_hab){
                                    $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                    WHERE id_habitacion_servicio = '$idHa'";

                                    $result=$conn->query($actulizar_estado);
                                    if ($result == 1) {
                                        $res['msj'] = "Reservación se realizo Correctamente";
                                    } else {
                                        $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                        $res['error'] = true;
                                    }
                                }

                            }
                            
                            
                        }
                    }                          
                }
            }
            //INSERTAR PARA EXTRANJEROS
            if(empty($_POST['reserva']) || empty($_POST['entra']) || empty($_POST['sali']) || 
                empty($_POST['habita']) || ($adultE == "" && $ninE == "") || ($adultE == "0" && $ninE == "0")
                ||empty($_POST['preAdultE']) || empty($_POST['preNinoE'])
                || empty($_POST['cantiHa']) || empty($_POST['total4'])|| empty($_POST['usuario_actual'])||empty($_POST['id_usuario'])){
                    $res['msj'] = 'Todos los campos son obligatorios';
                    $res['error'] = true;
            }else{
                if($adultE > 0){
                    $id_cliente=1;
                    $inserta=$conn->prepare("INSERT INTO tbl_reservaciones (fecha_reservacion,fecha_entrada, fecha_salida,cliente_id, usuario_id,
                    estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?);");
                    $inserta->bind_param('sssiiissss', $reserva, $entra,$sali,$id_cliente,$id_usuario,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                    $inserta->execute();

                    //se captura el id de la tabla de reservaciones
                    $capturar_reserv = $conn->prepare("SELECT id_reservacion FROM tbl_reservaciones
                                    WHERE fecha_reservacion= ?;");
                    $capturar_reserv->bind_Param("s", $reserva);
                    $capturar_reserv->execute();
                    $capturar_reserv->bind_result($idre);

                    if($capturar_reserv->affected_rows){
                        $existe_reserva = $capturar_reserv->fetch();

                        while ($capturar_reserv->fetch()) {
                            $id_reserv = $idre;
                        }
                        if($existe_reserva){
                            $cantid_adultos = $adultN + $adultE;
                            $cantid_ninos = $ninN + $ninE;
                            //inserta en la tabla detalle de reservacion
                            $insert=$conn->prepare("INSERT INTO tbl_detalle_reservacion (reservacion_id, habitacion_id, cantidad_persona, cantidad_ninos,
                            total_pago,estado_eliminado,creado_por, fecha_creacion, modificado_por, fecha_modificacion) 
                            VALUES (?,?,?,?,?,?,?,?,?,?);");
                            $insert->bind_param('iiiiiissss', $idre,$habita,$adultE,$ninE,$total4,$estado_eliminado,$usuario_actual,$fecha,$usuario_actual,$fecha);
                            $insert->execute();

                            //se captura el id de la tabla de habitacion servicio para cambiarle el estado
                            $captura_hab = $conn->prepare("SELECT habitacion_id FROM tbl_detalle_reservacion
                            WHERE habitacion_id = ?;");
                            $captura_hab->bind_Param("s", $habita);
                            $captura_hab->execute();
                            $captura_hab->bind_result($idHa);

                            if($captura_hab->affected_rows){
                                $existe_hab = $captura_hab->fetch();

                                while ($captura_hab->fetch()) {
                                    $id_habi = $idHa;
                                }
                                if($existe_hab){
                                    $actulizar_estado = "UPDATE tbl_habitacion_servicio SET estado_id = 5
                                    WHERE id_habitacion_servicio = '$idHa'";

                                    $result=$conn->query($actulizar_estado);
                                    if ($result == 1) {
                                        $res['msj'] = "Reservación se realizo Correctamente";
                                    } else {
                                        $res['msj'] = "Se produjo un error al momento de realizar la reservación ";
                                        $res['error'] = true;
                                    }
                                }

                            }
                            
                            
                        }
                    }                          
                }
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
       
    break;
//    case 'actualizarHotel':
//        if(isset($_POST['id_reservacion']) && isset($_POST['reservacion']) &&
//            isset($_POST['entrada']) && isset($_POST['salida'])&& isset($_POST['adultos'])
//            && isset($_POST['ninos'])&& isset($_POST['pago'])){

//                $id_reservacion=$_POST['id_reservacion'];
//                $reservacion=$_POST['reservacion'];
//                $entrada=$_POST['entrada'];
//                $salida = $_POST['salida'];
//                $cant_adultos = $_POST['adultos'];
//                $cant_ninos = $_POST['ninos'];
//                $totalPagar = $_POST['pago'];
                

//                $actualizarhotel = "UPDATE tbl_detalle_reservacion dr
//                                    inner join tbl_reservaciones r
//                                    on dr.reservacion_id = r.id_reservacion
//                                    inner join tbl_clientes c
//                                    on r.cliente_id = c.id_cliente
//                                    inner join tbl_habitacion_servicio hs
//                                    on dr.habitacion_id = hs.id_habitacion_servicio
//                                    inner join tbl_estado e
//                                    on hs.estado_id = e.id_estado
//                                    set  r.fecha_reservacion='$reservacion', 
//                                    r.fecha_entrada='$entrada', r.fecha_salida='$salida',
//                                    dr.cantidad_persona='$cant_adultos', 
//                                    dr.cantidad_ninos='$cant_ninos',dr.total_pago='$totalPagar'
//                                    WHERE id_reservacion=".$id_reservacion;
                
//                $resultado=$conn->query($actualizarhotel);
//                if ($resultado == 1) {
//                    $res['msj'] = "Reservación se Edito Correctamente";
//                } else {
//                    $res['msj'] = "Se produjo un error al momento de Editar la reservación ";
//                    $res['error'] = true;
//                }
//            }else{
//                $res['msj'] = "Las variables no estan definidas";
//                $res['error'] = true;
//            }
//    break;
//    case 'eliminarHotel':
//        if (isset($_POST['id_reservacion'])) {
//            $id_reservacion = $_POST['id_reservacion'];
//            $sql = "UPDATE tbl_detalle_reservacion SET estado_eliminar = 0 WHERE id_detalle_reservacion = " . $id_reservacion;
//            $resultado = $conn->query($sql);
//            if ($resultado == 1) {
//                $res['msj'] = "Reservacion Eliminada  Correctamente";
//            } else {
//                $res['msj'] = "Se produjo un error al momento de eliminar la reservación";
//                $res['error'] = true;
//            }
//        } else {
//            $res['msj'] = "No se envió el id de la reservacion a eliminar";
//            $res['error'] = true;
//        }

//    break;
    default:
        echo "Falló";
    break;
}
$conn->close();
header('Content-Type: application/json');
//echo $res['solicitudes'][0]['NombrePractica'];
echo json_encode($res);