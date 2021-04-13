<?php 
include_once ('../modelo/conexionbd.php');
$precio=$_POST['precio'];

$datos = array();

$sql="SELECT id_producto, precio_compra 
FROM tbl_producto 
WHERE id_producto = '$precio'";

$result=mysqli_query($conn,$sql);

$precios = mysqli_fetch_array($result);

// $datos['producto'] = $precios["id_producto"];
$datos['compra'] = $precios["precio_compra"];


echo json_encode($datos);
