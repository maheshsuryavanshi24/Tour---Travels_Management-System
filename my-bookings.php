<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT

bus_bookings.*,

packages.title,

buses.bus_name,
buses.from_city,
buses.to_city


FROM bus_bookings

JOIN buses
ON bus_bookings.bus_id = buses.id

LEFT JOIN packages
ON packages.title = buses.to_city

WHERE bus_bookings.user_id='$user_id'

ORDER BY bus_bookings.id DESC
";

$result = mysqli_query($conn, $query);

if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Bus Bookings</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#eef3f8;
    padding:40px;
}

h1{
    text-align:center;
    margin-bottom:30px;
    color:#1e3c72;
}

.table-container{
    max-width:1200px;
    margin:auto;
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1000px;
}

th{
    background:#009688;
    color:#fff;
    padding:12px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f1f1f1;
}

.table-responsive{
    overflow-x:auto;
}

.status{
    padding:5px 10px;
    border-radius:20px;
    color:#fff;
    font-size:13px;
    font-weight:bold;
    display:inline-block;
}

.confirmed{
   color:green;
	font-weight:bold;
}

.pending{
    background:#ff9800;
}

.cancelled{
    background:#dc3545;  
	color:white;
 
}

.route{
    font-weight:bold;
    color:#1e3c72;
}

.price{
    color:green;
    font-weight:bold;
}

@media(max-width:768px){

    body{
        padding:20px;
    }

    table{
        min-width:900px;
    }

    h1{
        font-size:24px;
    }
}

</style>

</head>

<body>

<h1>My Bus Bookings</h1>

<div class="table-container">

<div class="table-responsive">

<table>

<tr>

    <th>Package</th>

    <th>Bus</th>

    <th>Route</th>

    <th>Journey Date</th>

    <th>Seats</th>

    <th>Amount</th>

    <th>Payment</th>

    <th>Status</th>

    <th>Date</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td>
<?php echo $row['title'] ?? 'N/A'; ?>
</td>

<td>
<?php echo $row['bus_name']; ?>
</td>

<td class="route">

<?php echo $row['from_city']; ?>

→

<?php echo $row['to_city']; ?>

</td>

<td>
<?php echo $row['journey_date']; ?>
</td>

<td>
<?php echo $row['seats']; ?>
</td>

<td class="price">
₹<?php echo $row['total_amount']; ?>
</td>

<td>
<?php echo $row['payment_status']; ?>
</td>

<td>

<span class="confirmed <?php echo strtolower($row['booking_status'] ?? 'pending'); ?>">

<?php echo $row['booking_status'] ?? 'Pending'; ?>

</span>

</td>

<td>
<?php echo $row['booking_date']; ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>