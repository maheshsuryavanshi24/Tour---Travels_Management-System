<?php
require_once 'config.php';

$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$sql = "
SELECT
    buses.id,
    buses.bus_name,
    buses.total_seats,
    COUNT(bus_bookings.id) AS total_bookings,
    COALESCE(SUM(
        LENGTH(bus_bookings.seats)
        - LENGTH(REPLACE(bus_bookings.seats, ',', ''))
        + 1
    ),0) AS booked_seats,
    COALESCE(SUM(bus_bookings.total_amount),0) AS revenue
FROM buses
LEFT JOIN bus_bookings
ON buses.id = bus_bookings.bus_id
";

if(!empty($from_date) && !empty($to_date))
{
    $sql .= " WHERE bus_bookings.journey_date
              BETWEEN '$from_date' AND '$to_date'";
}

$sql .= " GROUP BY buses.id
          ORDER BY buses.bus_name ASC";

$query = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Bus Seat Report</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
    padding:20px;
}

.container{
    max-width:1300px;
    margin:auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#1e3c72;
    margin-bottom:25px;
}

.filter-box{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:flex-end;
    margin-bottom:20px;
}

input[type="date"]{
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
}

.btn{
    padding:10px 20px;
    border:none;
    border-radius:5px;
    color:#fff;
    cursor:pointer;
    font-weight:bold;
}

.filter-btn{
    background:#007bff;
}

.filter-btn:hover{
    background:#0056b3;
}

.print-btn{
    background:#28a745;
}

.print-btn:hover{
    background:#218838;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#1e3c72;
    color:#fff;
    padding:12px;
    text-align:center;
}

table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

table tr:nth-child(even){
    background:#f9f9f9;
}

table tr:hover{
    background:#eef4ff;
}

.booked{
    color:green;
    font-weight:bold;
}

.available{
    color:red;
    font-weight:bold;
}

.total-row{
    background:#d4edda !important;
    font-weight:bold;
}

@media print{

    .no-print{
        display:none;
    }

    body{
        background:#fff;
        padding:0;
    }

    .container{
        box-shadow:none;
    }
}

@media(max-width:768px){

    .filter-box{
        flex-direction:column;
    }

    .filter-box input,
    .filter-box button{
        width:100%;
    }

    table{
        font-size:13px;
    }
}

</style>

</head>
<body>

<div class="container">

<h2>Bus Seat Booking Report</h2>

<div class="no-print">

<form method="GET" class="filter-box">

    <input type="date"
           name="from_date"
           value="<?= $from_date ?>">

    <input type="date"
           name="to_date"
           value="<?= $to_date ?>">

    <button type="submit"
            class="btn filter-btn">
        Filter Report
    </button>

    <button type="button"
            onclick="window.print()"
            class="btn print-btn">
        Print / Save PDF
    </button>

</form>

</div>

<table>

<tr>
    <th>Bus Name</th>
    <th>Total Seats</th>
    <th>Booked Seats</th>
    <th>Available Seats</th>
    <th>Total Bookings</th>
    <th>Total Revenue</th>
</tr>

<?php

$grandRevenue = 0;

while($row = mysqli_fetch_assoc($query))
{
    $available = $row['total_seats'] - $row['booked_seats'];

    $grandRevenue += $row['revenue'];
?>

<tr>

    <td><?= $row['bus_name']; ?></td>

    <td><?= $row['total_seats']; ?></td>

    <td class="booked">
        <?= $row['booked_seats']; ?>
    </td>

    <td class="available">
        <?= $available; ?>
    </td>

    <td>
        <?= $row['total_bookings']; ?>
    </td>

    <td>
        ₹<?= number_format($row['revenue'],2); ?>
    </td>

</tr>

<?php } ?>

<tr class="total-row">

    <td colspan="5">
        Grand Total Revenue
    </td>

    <td>
        ₹<?= number_format($grandRevenue,2); ?>
    </td>

</tr>

</table>

</div>

</body>
</html>