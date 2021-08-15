<?php
include ('../modelo/conexionbd.php');
$precioe=$_POST['preciocampinge'];
$datose = array();

$sql="SELECT id_habitacion_servicio, precio_adulto_extranjero, precio_nino_extranjero,habitacion_area
FROM tbl_habitacion_servicio 
WHERE id_habitacion_servicio= $precioe";

$resulta=mysqli_query($conn,$sql);

$preciose = mysqli_fetch_array($resulta);

// $datos['producto'] = $precios["id_producto"];
$datose['alquilere'] = $preciose["precio_adulto_extranjero"];
$datose['alquilerninoe'] = $preciose["precio_nino_extranjero"];


echo json_encode($datose);