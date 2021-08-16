<?php 
include ('../modelo/conexionbd.php');
$precio=$_POST['precio'];

$datos = array();

$sql="SELECT id_tipo_boleto, precio_venta
FROM tbl_tipo_boletos
WHERE id_tipo_boleto = '$precio'";

$result=mysqli_query($conn,$sql);

$precios = mysqli_fetch_array($result);

// $datos['producto'] = $precios["id_producto"];
$datos['compra'] = $precios["precio_venta"];


echo json_encode($datos);
