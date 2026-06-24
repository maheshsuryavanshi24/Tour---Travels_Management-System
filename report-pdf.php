<?php
session_start();
include 'config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

require('fpdf.php');

$from = $_GET['from'] ?? date('Y-m-01');
$to   = $_GET['to'] ?? date('Y-m-d');

/* Summary Data */

$total_users = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM users")
)['total'];

$total_buses = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM buses")
)['total'];

$total_bookings = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM bus_bookings
WHERE DATE(booking_date)
BETWEEN '$from' AND '$to'
")
)['total'];

$confirmed = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM bus_bookings
WHERE booking_status='Confirmed'
AND DATE(booking_date)
BETWEEN '$from' AND '$to'
")
)['total'];

$cancelled = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM bus_bookings
WHERE booking_status='Cancelled'
AND DATE(booking_date)
BETWEEN '$from' AND '$to'
")
)['total'];

$revenue = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(total_amount) total
FROM bus_bookings
WHERE booking_status='Confirmed'
AND DATE(booking_date)
BETWEEN '$from' AND '$to'
")
)['total'];

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

/* Header */

$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'BUS BOOKING MANAGEMENT SYSTEM',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'ADMIN REPORT',0,1,'C');

$pdf->Cell(0,8,'Generated On: '.date('d-m-Y h:i A'),0,1,'C');

$pdf->Cell(0,8,'Period: '.$from.' To '.$to,0,1,'C');

$pdf->Ln(5);

/* Summary Table */

$pdf->SetFont('Arial','B',12);

$pdf->Cell(90,10,'Total Users',1);
$pdf->Cell(40,10,$total_users,1);
$pdf->Ln();

$pdf->Cell(90,10,'Total Buses',1);
$pdf->Cell(40,10,$total_buses,1);
$pdf->Ln();

$pdf->Cell(90,10,'Total Bookings',1);
$pdf->Cell(40,10,$total_bookings,1);
$pdf->Ln();

$pdf->Cell(90,10,'Confirmed Bookings',1);
$pdf->Cell(40,10,$confirmed,1);
$pdf->Ln();

$pdf->Cell(90,10,'Cancelled Bookings',1);
$pdf->Cell(40,10,$cancelled,1);
$pdf->Ln();

$pdf->Cell(90,10,'Total Revenue',1);
$pdf->Cell(40,10,'Rs. '.($revenue ?: 0),1);
$pdf->Ln(20);

/* Bus Wise Revenue */

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Bus Wise Revenue Report',0,1);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(100,10,'Bus Name',1);
$pdf->Cell(60,10,'Total Bookings',1);
$pdf->Cell(60,10,'Revenue',1);

$pdf->Ln();

$query = mysqli_query($conn,"
SELECT
b.bus_name,
COUNT(bb.id) total_booking,
SUM(bb.total_amount) revenue
FROM bus_bookings bb
JOIN buses b ON bb.bus_id=b.id
WHERE DATE(bb.booking_date)
BETWEEN '$from' AND '$to'
GROUP BY bb.bus_id
");

$pdf->SetFont('Arial','',10);

while($row=mysqli_fetch_assoc($query))
{
    $pdf->Cell(100,10,$row['bus_name'],1);
    $pdf->Cell(60,10,$row['total_booking'],1);
    $pdf->Cell(60,10,'Rs. '.$row['revenue'],1);
    $pdf->Ln();
}

/* Top Buses */

$pdf->Ln(10);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Top Performing Buses',0,1);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(150,10,'Bus Name',1);
$pdf->Cell(60,10,'Bookings',1);

$pdf->Ln();

$top = mysqli_query($conn,"
SELECT
b.bus_name,
COUNT(bb.id) total_booking
FROM bus_bookings bb
JOIN buses b ON bb.bus_id=b.id
WHERE DATE(bb.booking_date)
BETWEEN '$from' AND '$to'
GROUP BY bb.bus_id
ORDER BY total_booking DESC
LIMIT 5
");

$pdf->SetFont('Arial','',10);

while($row=mysqli_fetch_assoc($top))
{
    $pdf->Cell(150,10,$row['bus_name'],1);
    $pdf->Cell(60,10,$row['total_booking'],1);
    $pdf->Ln();
}

$pdf->Output('D','Bus_Booking_Report.pdf');
exit();
?>