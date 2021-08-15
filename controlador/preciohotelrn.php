<?php 
include ('../modelo/conexionbd.php');
$precio=$_POST['preciohotelr'];
$datos = array();

$sql="SELECT id_habitacion_servicio, precio_adulto_nacional, precio_nino_nacional,habitacion_area
FROM tbl_habitacion_servicio 
WHERE id_habitacion_servicio= '$precio'";

$result=mysqli_query($conn,$sql);

$precios = mysqli_fetch_array($result);

// $datos['producto'] = $precios["id_producto"];
$datos['reservrn'] = $precios["precio_adulto_nacional"];
$datos['reservninorn'] = $precios["precio_nino_nacional"];


echo json_encode($datos);