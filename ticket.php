<?php
session_start();

require('../pdf/fpdf.php');
include '../includes/db.php';

if(!isset($_GET['id'])){
    die("Booking ID Missing");
}

$booking_id = intval($_GET['id']);

// FETCH BOOKING
$query = "SELECT bookings.*, packages.title
          FROM bookings
          JOIN packages ON bookings.package_id = packages.id
          WHERE bookings.id='$booking_id'";

$result = mysqli_query($conn, $query);

if(!$result || mysqli_num_rows($result) == 0){
    die("Booking Not Found");
}

$data = mysqli_fetch_assoc($result);

// CREATE PDF
$pdf = new FPDF();
$pdf->AddPage();

/* HEADER */
$pdf->SetFont('Arial','B',18);
$pdf->SetTextColor(30,60,114);
$pdf->Cell(190,10,'TRAVEL BOOKING TICKET',0,1,'C');

$pdf->Ln(5);

/* LINE */
$pdf->SetDrawColor(200,200,200);
$pdf->Line(10,25,200,25);

$pdf->Ln(10);

/* BODY */
$pdf->SetFont('Arial','',12);
$pdf->SetTextColor(0,0,0);

/* BOX STYLE */
$pdf->SetFillColor(240,240,240);

/* DATA */
$pdf->Cell(60,10,'Customer Name:',0,0);
$pdf->Cell(100,10,$data['customer_name'],0,1);

$pdf->Cell(60,10,'Package:',0,0);
$pdf->Cell(100,10,$data['title'],0,1);

$pdf->Cell(60,10,'Booking Status:',0,0);
$pdf->Cell(100,10,$data['status'],0,1);

$pdf->Cell(60,10,'Booking Date:',0,0);
$pdf->Cell(100,10,$data['booking_date'],0,1);

$pdf->Ln(10);

/* FOOTER */
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,150,136);
$pdf->Cell(190,10,'Thank you for booking with us!',0,1,'C');

$pdf->Output();
?>