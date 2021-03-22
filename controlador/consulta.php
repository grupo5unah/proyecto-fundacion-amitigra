<?php
require '../../modelo/conexionbd.php';
$usuario = $_POST['usuario'];
$query = 'SELECT nombre_usuario FROM tbl_usuarios WHERE nombre_usuario = "$usuario"';
$resultado = mysqli_query($conn, $query);
$user = mysqli_fetch_row($resultado);

