<?php
session_start();
include 'config.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}

require('fpdf/fpdf.php');

$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

$where = '';

if(!empty($from) && !empty($to)){
    $where = " WHERE DATE(bus_bookings.booking_date)
               BETWEEN '$from' AND '$to' ";
}

/* Summary Data */

$users = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM users")
)['total'];

$buses = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM buses")
)['total'];

$bookings = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT COUNT(*) total FROM bus_bookings")
)['total'];

$revenue = mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT SUM(total_amount) total
    FROM bus_bookings
    WHERE booking_status='Confirmed'
")
)['total'];

$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

/* Header */

$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'BUS BOOKING MANAGEMENT SYSTEM',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Booking & Revenue Report',0,1,'C');

$pdf->Cell(0,8,'Generated On : '.date('d-m-Y h:i A'),0,1,'C');

if(!empty($from) && !empty($to)){
    $pdf->Cell(0,8,"Report Period : $from To $to",0,1,'C');
}

$pdf->Ln(5);

/* Summary Section */

$pdf->SetFont('Arial','B',11);

$pdf->Cell(70,10,'Total Users : '.$users,1);
$pdf->Cell(70,10,'Total Buses : '.$buses,1);
$pdf->Cell(70,10,'Total Bookings : '.$bookings,1);
$pdf->Cell(70,10,'Revenue : Rs. '.($revenue ?: 0),1);

$pdf->Ln(15);

/* Table Header */

$pdf->SetFont('Arial','B',10);

$pdf->Cell(12,10,'ID',1);
$pdf->Cell(35,10,'Passenger',1);
$pdf->Cell(30,10,'Mobile',1);
$pdf->Cell(40,10,'Bus',1);
$pdf->Cell(45,10,'Route',1);
$pdf->Cell(20,10,'Seats',1);
$pdf->Cell(25,10,'Amount',1);
$pdf->Cell(30,10,'Status',1);
$pdf->Cell(40,10,'Date',1);

$pdf->Ln();

/* Booking Data */

$query = mysqli_query($conn,"
SELECT
bus_bookings.*,
users.name,
users.mobile,
buses.bus_name,
buses.from_city,
buses.to_city
FROM bus_bookings
LEFT JOIN users
ON users.id = bus_bookings.user_id
LEFT JOIN buses
ON buses.id = bus_bookings.bus_id
$where
ORDER BY bus_bookings.id DESC
");

$pdf->SetFont('Arial','',9);

while($row = mysqli_fetch_assoc($query))
{
    $route = $row['from_city'].' - '.$row['to_city'];

    $pdf->Cell(12,10,$row['id'],1);
    $pdf->Cell(35,10,substr($row['name'],0,18),1);
    $pdf->Cell(30,10,$row['mobile'],1);
    $pdf->Cell(40,10,substr($row['bus_name'],0,20),1);
    $pdf->Cell(45,10,substr($route,0,25),1);
    $pdf->Cell(20,10,$row['seats'],1);
    $pdf->Cell(25,10,'Rs.'.$row['total_amount'],1);
    $pdf->Cell(30,10,$row['booking_status'],1);
    $pdf->Cell(40,10,$row['booking_date'],1);

    $pdf->Ln();
}

/* Footer */

$pdf->Ln(5);

$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,10,
'This report is generated automatically by the Bus Booking Management System.',
0,1,'C');

$pdf->Output('D','Bus_Booking_Report.pdf');
exit();
?>