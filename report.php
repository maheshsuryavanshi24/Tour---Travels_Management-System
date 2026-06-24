<?php
require_once 'config.php';

$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';

$where = "";

if($from_date != '' && $to_date != '')
{
    $where = " WHERE DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
}

$booking_query = mysqli_query($conn,"
SELECT *
FROM bus_bookings
$where
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Travel Report</title>

<style>
body{
    font-family:Arial;
    background:#f5f5f5;
    padding:20px;
}

.container{
    background:white;
    padding:20px;
    border-radius:10px;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th,
table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

th{
    background:#007bff;
    color:white;
}

.filter{
    margin-bottom:20px;
}

input{
    padding:8px;
}

button{
    padding:10px 15px;
    background:green;
    color:white;
    border:none;
    cursor:pointer;
}

.print-btn{
    background:#dc3545;
}
</style>

</head>
<body>

<div class="container">

<h2>Bus Booking Report</h2>

<form method="GET" class="filter">

    From:
    <input type="date" name="from_date"
    value="<?php echo $from_date; ?>">

    To:
    <input type="date" name="to_date"
    value="<?php echo $to_date; ?>">

    <button type="submit">Generate Report</button>

    <button type="button"
    class="print-btn"
    onclick="window.print()">
    Print
    </button>

</form>

<table>

<tr>
    <th>ID</th>
    <th>Bus ID</th>
    <th>Journey Date</th>
    <th>Seats</th>
    <th>Total Amount</th>
</tr>

<?php

$total = 0;

while($row = mysqli_fetch_assoc($booking_query))
{
    $total += $row['total_amount'];
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['bus_id']; ?></td>

<td><?php echo $row['journey_date']; ?></td>

<td><?php echo $row['seats']; ?></td>

<td>₹<?php echo $row['total_amount']; ?></td>

</tr>

<?php
}
?>

<tr>

<td colspan="4">
<b>Total Revenue</b>
</td>

<td>
<b>₹<?php echo $total; ?></b>
</td>

</tr>

</table>

</div>

</body>
</html>