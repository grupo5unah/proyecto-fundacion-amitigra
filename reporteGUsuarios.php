<?php
require('ReportesPDF/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        require_once('funciones/sesiones.php');
        $user = $_SESSION['usuario'];

        // Logo
        $this->Image('vista/dist/img/logo.png', 230, 5, 18);
        // Arial bold 10
        $this->SetFont('Arial', 'B', 10);
        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->Cell(60, 8, utf8_decode('Fundación AMITIGRA'), 0, 1, 'C');
        // Subtitulo
        $this->Cell(260, 8, 'REPORTE DE USUARIOS', 0, 1, 'C');
        //
        echo $this->Cell(23, 8, 'Usuario:' . " " . $user, 0, 1, 'C');
        //
        $this->Cell(58, 8, 'Fecha: _______________________', 0, 0, 'C');
        // Salto de línea
        $this->Ln(12);

        $this->Cell(10, 12, 'Id', 1, 0, 'C', 0);
        $this->Cell(80, 12, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(35, 12, 'Nombre Usuario', 1, 0, 'C', 0);
        $this->Cell(30, 12, utf8_decode('Télefono'), 1, 0, 'C', 0);
        $this->Cell(65, 12, 'Correo', 1, 0, 'C', 0); 
        $this->Cell(30, 12, 'Rol', 1, 0, 'C', 0);
        $this->Cell(30, 12, 'Estado', 1, 1, 'C', 0);
       
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
require 'modelo/conexionbd.php';
$query = mysqli_query($conn, "SELECT us.id_usuario,nombre_completo,nombre_usuario,telefono,correo,ro.rol,
        est.nombre_estado,us.fecha_creacion
        FROM tbl_usuarios us inner JOIN tbl_roles ro 
        ON us.rol_id=ro.id_rol INNER JOIN tbl_estado est
        ON us.estado_id=est.id_estado
        ORDER BY id_usuario ");

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while ($data = mysqli_fetch_array($query)) {
    $pdf->Cell(10, 12, $data['id_usuario'], 1, 0, 'C', 0);
    $pdf->Cell(80, 12, $data['nombre_completo'], 1, 0, 'C', 0);
    $pdf->Cell(35, 12, $data['nombre_usuario'], 1, 0, 'C', 0);
    $pdf->Cell(30, 12, $data['telefono'], 1, 0, 'C', 0);
    $pdf->Cell(65, 12, $data['correo'], 1, 0, 'C', 0);
    $pdf->Cell(30, 12, $data['rol'], 1, 0, 'C', 0);
    $pdf->Cell(30, 12, $data['nombre_estado'], 1, 1, 'C', 0);
 
}
$pdf->Output('', 'ReporteUsuarios.pdf');
