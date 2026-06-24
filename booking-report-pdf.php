<?php

require_once 'config.php';
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);

$pdf->Cell(190,10,'Booking Report',1,1,'C');

$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,10,'ID',1);
$pdf->Cell(25,10,'Bus ID',1);
$pdf->Cell(40,10,'Journey Date',1);
$pdf->Cell(60,10,'Seats',1);
$pdf->Cell(40,10,'Amount',1);

$pdf->Ln();

$result = mysqli_query($conn,"SELECT * FROM bus_bookings");

$pdf->SetFont('Arial','',10);

while($row=mysqli_fetch_assoc($result))
{
    $pdf->Cell(15,10,$row['id'],1);
    $pdf->Cell(25,10,$row['bus_id'],1);
    $pdf->Cell(40,10,$row['journey_date'],1);
    $pdf->Cell(60,10,$row['seats'],1);
    $pdf->Cell(40,10,$row['total_amount'],1);
    $pdf->Ln();
}

$pdf->Output();