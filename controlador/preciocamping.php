<?php 
include ('../modelo/conexionbd.php');
$precio=$_POST['preciocamping'];
$datos = array();

$sql="SELECT id_habitacion_servicio, precio_adulto_nacional, precio_nino_nacional,habitacion_area
FROM tbl_habitacion_servicio 
WHERE id_habitacion_servicio= '$precio'";

$result=mysqli_query($conn,$sql);

$precios = mysqli_fetch_array($result);

// $datos['producto'] = $precios["id_producto"];
$datos['alquiler'] = $precios["precio_adulto_nacional"];
$datos['alquilernino'] = $precios["precio_nino_nacional"];


echo json_encode($datos);



