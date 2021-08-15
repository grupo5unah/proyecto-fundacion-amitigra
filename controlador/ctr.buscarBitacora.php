<?php

include_once("../modelo/conexionbd.php");

$columns = array('id_bitacora','accion', 'descripcion_bitacora', 'fecha_accion', 'usuario_id', 'objeto_id');

$query = "SELECT * FROM tbl_bitacora WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'fecha_accion BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (id_bitacora LIKE "%'.$_POST["search"]["value"].'%" 
  OR accion LIKE "%'.$_POST["search"]["value"].'%" 
  OR descripcion_bitacora LIKE "%'.$_POST["search"]["value"].'%" 
  OR fecha_accion LIKE "%'.$_POST["search"]["value"].'%"
  OR usuario_id LIKE "%'.$_POST["search"]["value"].'%"
  OR objeto_id LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id_bitacora DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();
$datos = "";
while($row = mysqli_fetch_array($result))
{
 $fecha=date("d/m/Y", strtotime($row["fecha_accion"]));			
 $sub_array = array();
  $sub_array[] = $row["accion"];
 $sub_array[] = $row["descripcion_bitacora"];
 $sub_array[] = $fecha;
 $sub_array[] = $row["usuario_id"];
 $sub_array[] = $row["objeto_id"];
 $sub_array[] = $datos;
 
 $data[] = $sub_array;
}

function get_all_data($conn)
{
 $query = "SELECT accion, descripcion_bitacora, fecha_accion, usuario_id, objeto_id FROM tbl_bitacora";
 $result = mysqli_query($conn, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($conn),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);