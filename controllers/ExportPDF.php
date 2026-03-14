<?php
require_once __DIR__ . '/../libs/fpdf/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();

/* Use ONLY built-in Arial */
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Admin Attendance & Worksheet Report', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 8, 'PDF export working correctly.', 0, 1);

$pdf->Output();
exit;