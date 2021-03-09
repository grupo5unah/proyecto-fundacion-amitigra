<?php
require('ReportesPDF/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        require('modelo/conexionbd.php');
        require_once('funciones/sesiones.php');
        $user = $_SESSION['usuario'];


        $hora1 = new DateTime(null, new DateTimeZone('America/Tegucigalpa'));
        $hora = $hora1->format("h:i:s");

        // Logo
        $this->Image('vista/dist/img/logo.png', 230, 5, 18);
        // Arial bold 10
        $this->SetFont('Arial', 'B', 10);
        // Movernos a la derecha
        $this->Cell(100);
        // Título
        $this->Cell(60, 8, utf8_decode('Fundación AMITIGRA'), 0, 1, 'C');
        // Subtitulo
        $this->Cell(260, 8, 'Reporte De Solicitudes', 0, 1, 'C');
        //
        echo $this->Cell(30, 8, 'Usuario:' . " " . $user, 0, 1, 'C');

        $this->Cell(78, 8, utf8_decode('Fecha y Hora de Impresión:') . ' ' . date('d') . ' ' . 'de' . ' ' . date('M') . ' ' . 'de' . ' ' . date('Y'), 0, 0, 'R');
        $this->Cell(20, 8, $hora, 0, 0, 'R');

        // Salto de línea
        $this->Ln(12);

        $this->Cell(13, 12, 'Id', 1, 0, 'C', 0);
        $this->Cell(60, 12, 'Nombre Cliente', 1, 0, 'C', 0);
        $this->Cell(32, 12, utf8_decode('Télefono'), 1, 0, 'C', 0);
        $this->Cell(55, 12, 'Tipo De Solicitud', 1, 0, 'C', 0);
        $this->Cell(40, 12, 'Precio De Solicitud', 1, 0, 'C', 0);
        $this->Cell(40, 12, 'Estado De Solicitud', 1, 1, 'C', 0);
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

$consult_solicitud = mysqli_query($conn, "SELECT id_solicitud,cli.nombre_completo,cli.telefono,tipo,tips.precio_solicitud,est.estatus
FROM tbl_solicitudes sol INNER JOIN tbl_clientes cli
ON sol.cliente_id=cli.id_cliente INNER JOIN tbl_tipo_solicitud tips
ON sol.tipo_solicitud=tips.id_tipo_solicitud INNER JOIN tbl_estatus_solicitud est
ON sol.estatus_solicitud=est.id_estatus_solicitud ORDER BY id_solicitud");

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while ($data = mysqli_fetch_array($consult_solicitud)) {
    $pdf->Cell(13, 12, $data['id_solicitud'], 1, 0, 'C', 0);
    $pdf->Cell(60, 12, $data['nombre_completo'], 1, 0, 'C', 0);
    $pdf->Cell(32, 12, $data['telefono'], 1, 0, 'C', 0);
    $pdf->Cell(55, 12, $data['tipo'], 1, 0, 'C', 0);
    $pdf->Cell(40, 12, $data['precio_solicitud'], 1, 0, 'C', 0);
    $pdf->Cell(40, 12, $data['estatus'], 1, 1, 'C', 0);
}
$pdf->Output('', 'ReporteSolicitud.pdf');
