<?php
    if(isset($_POST['irpdf']) == 'pdf'){
        require("fpdf/fpdf.php");
        class PDF extends FPDF{
            //Cabecera de página
            function Header()
            {
                // Arial bold 15
                $this->SetFont('Arial','B',15);
                //Saltos de linea
                $this->Ln(10);
            }
    
            // Pie de página
            function Footer()
            {
                // Posición: a 1,5 cm del final
                $this->SetY(-15);
                // Arial italic 8
                $this->SetFont('Arial','I',8);
                // Número de página
                $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
            }
        }

    include("../modelo/conexion.php");
    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
    //$pdf->Image('logo.png',120,4);
    $pdf->Cell(80);
    $pdf->SetFont('Arial','B',15);
    $pdf->Cell(90,10,'Fundacion AMITIGRA.',0,1,'C');
    $pdf->cell(80);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(90,10,'Reporte Bitacora.',0,1,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFillColor(93, 183, 134);
    $pdf->Cell(6, 8, '', 0);
    $pdf->Cell(28, 6, 'Usuario', 1,0,'C',2);
    $pdf->Cell(28, 6, 'Objeto', 1,0,'C',2);
    $pdf->Cell(36, 6, 'Fecha', 1,0,'C',2);
    $pdf->Cell(34, 6, 'Accion', 1,0,'C',2);
    $pdf->Cell(122, 6, 'Descripcion', 1,0,'C',2);
    $pdf->Ln(7);
    try {
        $stmt = "SELECT tbl_usuarios.nombre_usuario AS nombre_usuario, tbl_objeto.objeto AS objeto, fecha, accion, tbl_bitacora.descripcion AS descripcion from tbl_bitacora
        INNER JOIN tbl_usuarios
        ON
        tbl_bitacora.usuario_id = tbl_usuarios.id_usuario
        INNER JOIN tbl_objeto
        ON
        tbl_bitacora.objeto_id = tbl_objeto.id_objeto
        ORDER BY id_bitacora DESC;
        ";
        $resultado = $conn->query($stmt);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    while( $registrado = $resultado->fetch_assoc() ) {
        $pdf->Cell(6, 8, '', 0);
        $pdf->Cell(28, 6,$registrado['nombre_usuario'], 1,0,'C');
        $pdf->Cell(28, 6,$registrado['objeto'], 1,0,'C');
        $pdf->Cell(36, 6,$registrado['fecha'], 1,0,'C');
        $pdf->Cell(34, 6,$registrado['accion'], 1,0,'C');
        $pdf->Cell(122, 6,$registrado['descripcion'], 1,0,'C');
        $pdf->Ln(8);
    }
    $pdf->AliasNbPages();
    $pdf->Output();
}
?>